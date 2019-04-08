<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Events\Product\ProductFinished;
use App\Events\Product\ProductStarted;
use App\Http\Controllers\Services\ProductService;
use App\Http\Resources\Product\Product as Resource;
use App\Http\Resources\Product\ProductCollection;
use App\ModelFilters\ProductsFilter\DefaultFilter;
use App\Models\Product;
use App\User;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Builder;
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
    public function index(Request $request)
    {
        //
        //        ($this->_isAnAdmin() || $this->_isADesigner())
        //            ? $this->_fetchAllProducts($request)
        //            : $this->_fetchOwnedProducts($request);
        
        return new ProductCollection(
            Product::filter($request->all(), DefaultFilter::class)
                   ->paginate($request->get('per_page') ?? 15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\App\Http\Resources\Product\Product
     */
    public function store(Request $request)
    {
        //
        try {
            $productService = new ProductService($request);
            $product = $productService->store();
        
            return response()
                ->json(
                    new Resource($product),
                    201
                );
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage(), $exception->getTrace());
            
            return response()
                ->json(
                    [
                        'error' => $exception->getMessage(),
                    ],
                    500
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
     * @return \App\Http\Resources\Product\Product
     */
    public function update(Request $request, Product $product)
    {
        if ($request->has('status')) {
            if ($request->get('status') === 'opgepakt') {
                try {
                    event(new ProductStarted($product));
                } catch (Exception $exception) {
                    \Log::error($exception->getMessage(), $exception->getTrace());
                    return back()->with('status', $exception->getMessage());
                }
            }
        
            if ($request->get('status') === 'afgerond') {
                try {
                    event(new ProductFinished($product));
                } catch (Exception $exception) {
                    \Log::error($exception->getMessage(), $exception->getTrace());
                    return back()->with('status', $exception->getMessage());
                }
            }
        }
        
        $product->update($request->except('deadline'));
        
        $product->update(
        	[
        		'updated_at'        => now(),
	        ]
        );
    
        return new Resource($product);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()
                ->json([], 204);
        } catch (Exception $exception) {
            \Log::error($exception->getMessage(), $exception->getTrace());
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
     * @param Request $request the current request
     *
     * @return void
     */
    private function _fetchOwnedProducts(Request $request): void
    {
        $this->_setUser();
        $query = Product::query();
        $query = $this->addSearchParamsToQuery($request, $query);
        
        $query = $query->where('user_id', '=', Auth::user()->id);
    
        $this->_producten = $request->has('per_page')?
            $query->paginate($request->get('per_page')) : $query->get();
    }
    
    /**
     * Sets all products in private variable
     *
     * @param Request $request the current request
     *
     * @return void
     */
    private function _fetchAllProducts(Request $request): void
    {
        $query = Product::query();
        
        $query = $this->addSearchParamsToQuery($request, $query);
        
        $this->_producten = $request->has('per_page')?
            $query->paginate($request->get('per_page')) : $query->get();
    }
    
    /**
     * Sets the current user.
     *
     * @return void
     */
    private function _setUser(): void
    {
        if (!isset($this->_user)) {
            $this->_user = auth('api')->user();
        }
    }
    
    /**
     * Add search params to each request
     *
     * @param Request $request the current request.
     * @param Builder $query   The current query.
     *
     * @return Builder
     */
    protected function addSearchParamsToQuery(
        Request $request,
        Builder $query
    ): Builder {
        $query->when(
            $request->has('status'),
            function (Builder $q) use ($request) {
                return $q->where('status', $request->get('status'));
            }
        );
        
        $query->when(
            $request->has('product_name'),
            function (Builder $q) use ($request) {
                return $q->where(
                    'name',
                    'like',
                    "%{$request->get('product_name')}%"
                );
            }
        );
        
        $query->when(
            $request->has('order_by'),
            function (Builder $q) use ($request) {
                return $q->orderBy(
                    $request->get('order_by'),
                    $request->get('order')?? 'ASC'
                );
            }
        );
        
        return $query;
    }
}
