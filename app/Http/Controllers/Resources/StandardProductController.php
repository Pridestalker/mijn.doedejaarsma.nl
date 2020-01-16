<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\StandardProductService;
use App\Models\StandardProduct;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Log;

class StandardProductController extends Controller
{
    protected static $user = null;

    /**
     * StandardProductController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    }

    public function create()
    {
        return view('stdProduct.create');
    }

    public function store(Request $request)
    {
        $stdProductService = StandardProductService::make($request);

        try {
            $stdProductService->store();
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return back()->with('status', 'De aanvraag is niet doorgekomen.
        	Neem contact met ons op als dit vaker optreedt.');
        }

        return redirect()
            ->route('products.index')
            ->with('clearStorage', true);
    }

    public function show(StandardProduct $product)
    {
    }

    public function downloadImage(StandardProduct $product)
    {
        return \Storage::download($product->info->attachment);
    }

    public function edit(StandardProduct $product)
    {
    }

    public function update(StandardProduct $product)
    {
    }

    public function destroy(StandardProduct $product)
    {
    }

    private function setGetUser(): User
    {
        if (null !== static::$user) {
            return static::$user;
        }

        return static::$user = Auth::user();
    }
}
