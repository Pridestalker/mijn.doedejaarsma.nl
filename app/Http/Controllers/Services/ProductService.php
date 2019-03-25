<?php
namespace App\Http\Controllers\Services;

use App\Events\Product\ProductCreatedEvent;
use App\Models\Product;
use App\User;
use Auth;
use Error;
use Exception;
use Illuminate\Http\Request;
use Log;

class ProductService
{
    protected $model = Product::class;
    
    protected $request;
    
    protected $product;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function store()
    {
        /*
        * TODO: Fill the MessageBag with errors after wrong validation.
         *      see: https://laravel.com/docs/5.8/validation
        */
        $validated = $this->request->validate(
            [
                'name'      => 'required|string',
                'deadline'  => 'required',
                'soort'     => 'required',
            ]
        );
        
        if (!$validated) {
            throw new Error('Not all fields are filled');
        }
        
        if ($this->hasFile()) {
            $path = $this->storeFile();
        }
    
        try {
            $atts = $this->request->except('attachment');
            $atts['status'] = 'aangevraagd';
            $atts['attachment'] = $path?? null;
            $atts['user_id'] = $this->request->has('user_id') ?
                $this->request->get('user_id') :
                Auth::user()->id;
    
            $this->product = Product::create($atts);
            
            if ($this->hasPrintOptions()) {
                $data = [
                    'oplage' => $this->request->get('oplage')?? '',
                    'papier' => $this->request->get('papier')?? '',
                    'gewicht'=> $this->request->get('gewicht')?? '',
                    'afleveradres' => $this->request->get('afleveradres')?? '',
                ];
    
                $this->product->options = json_encode($data);
            }
            $this->product->save();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
            throw new Error('Error creating product');
        }
        
        
        if ($this->product->exists()) {
            if ($this->request->has('user_id')) {
                event(
                    new ProductCreatedEvent(
                        $this->product,
                        User::findOrFail($this->request->get('user_id'))
                    )
                );
            } else {
                event(new ProductCreatedEvent($this->product, Auth::user()));
            }
            return $this->product;
        } else {
            Log::error('Aanvraag error', [ 'user' => Auth::user()]);
            throw new Error('Error creating product');
        }
    }
    
    protected function hasPrintOptions(): bool
    {
        return $this->request->hasAny(['oplage','papier','gewicht','afleveradres']);
    }
    
    protected function hasFile(): bool
    {
        return $this->request->hasFile('attachment');
    }
    
    protected function storeFile()
    {
        /* @noinspection NullPointerExceptionInspection */
        return $this
            ->request
            ->file('attachment')
            ->storePublicly('voorbeelden');
    }
}
