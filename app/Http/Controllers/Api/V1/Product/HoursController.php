<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Resources\Hour\Hour as Resource;
use App\ModelFilters\HoursFilter\DefaultFilter;
use App\Models\Hour;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class HoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request The current request.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return Resource::collection(
            Hour::filter($request->all(), DefaultFilter::class)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request The current request.
     *
     * @return Resource
     */
    public function store(Request $request): \App\Http\Resources\Hour\Hour
    {
        $hour = Hour::create(
            [
                'user_id'       => app('auth')->user()->id,
                'product_id'    => $request->get('product_id'),
                'hours'         => $request->get('hours'),
                'remarks'       => $request->get('remarks')?? '',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]
        );
        
        $product = Product::find($request->get('product_id'));
        
        $product->update(
            [
                'updated_at'        => now(),
                'updated_by'        => Auth::user()->id,
            ]
        );
        
        return new Resource($hour);
    }
    
    /**
     * Display the specified resource.
     *
     * @param Hour $hour The requested hour.
     *
     * @return Resource
     */
    public function show(Hour $hour): \App\Http\Resources\Hour\Hour
    {
        return new Resource($hour);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request The current request.
     * @param Hour    $hour    The requested hour.
     *
     * @return Response
     */
    public function update(Request $request, Hour $hour): Response
    {
        return response()->json(['Not implemented'], 500);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Hour $hour The hour to be deleted.
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Hour $hour): Response
    {
        $hour->delete();
        return response()->json([], 204);
    }
}
