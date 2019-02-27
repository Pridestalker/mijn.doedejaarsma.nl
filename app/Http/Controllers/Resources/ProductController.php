<?php

namespace App\Http\Controllers\Resources;

use App\Events\Product\ProductCreatedEvent;
use App\Events\Product\ProductFinished;
use App\Events\Product\ProductStarted;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * The current user.
     *
     * @var \App\User
     */
    private $_user;
    
    private $_producten = [];
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        ($this->isAnAdmin() || $this->isADesigner())
            ? $this->fetchAllProducts() : $this->fetchOwnedProducts();
        
        return \View::make('products.index')
            ->with('products', $this->_producten);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        //
        if ($this->isADesigner()) {
            return redirect()
                ->to('/')
                ->with('status', 'Je bent niet bevoegd om deze pagina te bekijken');
        }
        
        return \View::make('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        $validated = $request->validate([
            'name'      => 'required|string',
            'deadline'  => 'required',
            'soort'     => 'required',
        ]);
        
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')
                ->storePublicly('voorbeelden');
        }
        
        try {
            $atts = $request->except('attachment');
            $atts['status'] = 'aangevraagd';
            $atts['attachment'] = $path?? '';
            $atts['user_id'] = $request->has('user_id') ?
                $request->get('user_id') :
                \Auth::user()->id;
            
            $product = Product::create($atts);
    
            if ($request->hasAny([ 'oplage', 'papier', 'gewicht', 'afleveradres' ])) {
                $data = [
                    'oplage' => $request->get('oplage')?? '',
                    'papier' => $request->get('papier')?? '',
                    'gewicht'=> $request->get('gewicht')?? '',
                    'afleveradres' => $request->get('afleveradres')?? '',
                ];
                
                $product->options = json_encode($data);
            }
            
            $product->save();
        } catch (\Exception $e) {
            return back()
                ->with('status', $e->getMessage());
        }
        
        if ($product) {
            event(new ProductCreatedEvent($product, \Auth::user()));
            
            return redirect()
                ->route('products.show', $product->id)
                ->with('clearStorage', true);
        } else {
            return back()
                ->with('status', 'De aanvraag is niet doorgekomen. Als dit vaker voor komt neem dan contact met ons op');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return \View::make('products.show')
            ->with('product', $product);
    }
    
    public function showImage(Product $product)
    {
        return \Storage::download($product->attachment);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return \View::make('products.edit')
            ->with('product', $product);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Product                   $product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        
        if ($request->has('status')) {
            if ($request->get('status') === 'opgepakt') {
                try {
                    event(new ProductStarted($product));
                } catch (\Exception $exception) {
                    return back()->with('status', $exception->getMessage());
                }
            }
            
            if ($request->get('status') === 'afgerond') {
                try {
                    event(new ProductFinished($product));
                } catch (\Exception $exception) {
                    return back()->with('status', $exception->getMessage());
                }
            }
        }
        
        $product->update($request->except('deadline'));
        
        return back()
            ->with('status', 'Product aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    private function isAnAdmin()
    {
        $this->setUser();
        return $this->_user->isAn('admin');
    }
    
    private function isADesigner()
    {
        $this->setUser();
        return $this->_user->isA('designer');
    }
    
    private function fetchOwnedProducts()
    {
        $this->setUser();
        $this->_producten = Product::byUser(\Auth::user())
            ->orderByDesc('deadline')
            ->get();
    }
    
    private function fetchAllProducts()
    {
        $this->_producten = Product::orderByDesc('deadline')->get();
    }
    
    private function setUser()
    {
        if (!isset($this->_user)) {
            $this->_user = \Auth::user();
        }
    }
}
