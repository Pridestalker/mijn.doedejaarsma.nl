<?php

namespace App\Http\Controllers\Api\V1\Product;

use Log;
use Auth;
use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Events\Product\ProductStarted;
use App\Events\Product\ProductFinished;
use App\Http\Controllers\Services\ProductService;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\Product as Resource;
use App\ModelFilters\ProductsFilter\DefaultFilter;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return ProductCollection
     */
    public function index(Request $request): ProductCollection
    {
        return new ProductCollection(
            Product::filter($request->all(), DefaultFilter::class)
                   ->paginate($request->get('per_page') ?? 15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Resource|JsonResponse|RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $productService = new ProductService($request);
            $product = $productService->store();

            return response()
                ->json(new Resource($product), 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());

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
     * @return \App\Http\Resources\Product\Product
     */
    public function show(Product $product): \App\Http\Resources\Product\Product
    {
        return new Resource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     *
     * @return Resource
     */
    public function update(Request $request, Product $product): \App\Http\Resources\Product\Product
    {
        if ($request->has('status')) {
            if ($request->get('status') === 'opgepakt') {
                try {
                    event(new ProductStarted($product));
                } catch (Exception $exception) {
                    Log::error($exception->getMessage(), $exception->getTrace());
                    return back()->with('status', $exception->getMessage());
                }
            }

            if ($request->get('status') === 'afgerond') {
                try {
                    event(new ProductFinished($product));
                } catch (Exception $exception) {
                    Log::error($exception->getMessage(), $exception->getTrace());
                    return back()->with('status', $exception->getMessage());
                }
            }
        }

        $product->update($request->except('deadline'));

        $product->update(
            [
                'updated_at'        => now(),
                'updated_by'        => Auth::user()->id,
            ]
        );

        if ($request->has('status')) {
            $product->order->update([
                'status'    => $request->input('status')
            ]);
        }

        return new Resource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     *
     * @return Response|JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()
                ->json([], 204);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            return response([], 400);
        }
    }
}
