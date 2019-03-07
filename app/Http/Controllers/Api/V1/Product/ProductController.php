<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Events\Product\ProductCreatedEvent;
use App\Http\Resources\Product\Product as Resource;
use App\Http\Resources\Product\ProductCollection;
use App\Models\Product;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * The current user.
     *
     * @var User
     */
    private $_user;
    
    /**
     * An array of products.
     *
     * @var array
     */
    private $_producten = [];
    
    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     */
    public function index()
    {
        //
        ($this->_isAnAdmin() || $this->_isADesigner())
            ? $this->_fetchAllProducts() : $this->_fetchOwnedProducts();
        
        return new ProductCollection($this->_producten);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return Resource
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate(
            [
                'name'      => 'required|string',
                'deadline'  => 'required',
                'soort'     => 'required',
            ]
        );
    
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')
                ->storePublicly('voorbeelden');
        }
    
        try {
            $atts = $request->except('attachment');
            $atts['status'] = 'aangevraagd';
            $atts['attachment'] = $path?? null;
            $atts['user_id'] = $request->has('user_id') ?
                $request->get('user_id') :
                Auth::user()->id;
        
            $product = Product::create($atts);
        
            if ($request->hasAny(
                [
                    'oplage',
                    'papier',
                    'gewicht',
                    'afleveradres'
                ]
            )
            ) {
                $data = [
                    'oplage' => $request->get('oplage')?? null,
                    'papier' => $request->get('papier')?? null,
                    'gewicht'=> $request->get('gewicht')?? null,
                    'afleveradres' => $request->get('afleveradres')?? null,
                ];
            
                $product->options = json_encode($data);
            }
        
            $product->save();
        } catch (Exception $e) {
            return back()
                ->with('status', $e->getMessage());
        }
    
        if ($product) {
            if ($request->has('user_id')) {
                event(new ProductCreatedEvent($product, User::findOrFail($request->get('user_id'))));
            } else {
                event(new ProductCreatedEvent($product, Auth::user()));
            }
        
            return new Resource($product);
        } else {
            return back()
                ->with(
                    'status',
                    'De aanvraag is niet doorgekomen.
                    Als dit vaker voor komt neem dan contact met ons op'
                );
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param Product $product
     *
     * @return mixed
     */
    public function show(Product $product)
    {
        //
        return new Resource($product);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product                  $product
     *
     * @return Resource
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->except('deadline'));
    
        return new Resource($product);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     *
     * @return Resource
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()
                ->json([], 204);
        } catch (Exception $exception) {
            return response([], 400);
        }
    }
    
    
    /**
     * Checks if the user is an admin.
     *
     * @return bool
     */
    private function _isAnAdmin(): bool
    {
        $this->_setUser();
        return $this->_user->isAn('admin');
    }
    
    /**
     * Checks if the user is a designer.
     *
     * @return bool
     */
    private function _isADesigner(): bool
    {
        $this->_setUser();
        return $this->_user->isA('designer');
    }
    
    /**
     * Sets the products in a private variable
     *
     * @return void
     */
    private function _fetchOwnedProducts(): void
    {
        $this->_setUser();
        $this->_producten = Product::byUser(Auth::user())
                                   ->orderByDesc('deadline')
                                   ->get();
    }
    
    /**
     * Sets all products in private variable
     *
     * @return void
     */
    private function _fetchAllProducts(): void
    {
        $this->_producten = Product::orderByDesc('deadline')->get();
    }
    
    /**
     * Sets the current user.
     *
     * @return void
     */
    private function _setUser(): void
    {
        if (!isset($this->_user)) {
            $this->_user = Auth::user();
        }
    }
}
