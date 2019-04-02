<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Resources\Hour\Hour as Resource;
use App\Models\Hour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class HoursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * TODO: Create query params.
     *      https://github.com/Tucker-Eric/EloquentFilter
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return Resource::collection(Hour::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request The current request.
     *
     * @return Resource
     */
    public function store(Request $request)
    {
        //
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
        
        return new Resource($hour);
    }
    
    /**
     * Display the specified resource.
     *
     * @param Hour $hour The requested hour.
     *
     * @return Resource
     */
    public function show(Hour $hour)
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
    public function update(Request $request, Hour $hour)
    {
        //
        return response()->json(['Not implemented'], 500);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Hour $hour The hour to be deleted.
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy(Hour $hour)
    {
        //
        $hour->delete();
        return response()->json([], 204);
    }
}
