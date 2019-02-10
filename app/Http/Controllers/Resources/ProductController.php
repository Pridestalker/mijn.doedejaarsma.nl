<?php

namespace App\Http\Controllers\Resources;

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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ($this->isAnAdmin() || $this->isADesigner())
            ? $this->fetchAllProducts() : $this->fetchOwnedProducts();
        
        return \View::make('products.index')
            ->with('products', $this->_producten);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')
                ->storePublicly('voorbeelden');
        }
        
        try {
            $product = Product::create(
                $request->except('attachment') +
                [
                    'status'    => 'aangevraagd',
                    'attachment'  => $path?? '',
                ]
            );
            
            $product->user_id = \Auth::user()->id;
        } catch (\Exception $e) {
            return back()
                ->with('status', $e->getMessage());
        }
        
        if ($product) {
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $product->update($request->all());
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
    }
    
    private function fetchAllProducts()
    {
        $this->_producten = Product::all();
    }
    
    private function setUser()
    {
        if (!isset($this->_user)) {
            $this->_user = \Auth::user();
        }
    }
}
