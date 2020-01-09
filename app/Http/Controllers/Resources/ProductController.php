<?php

namespace App\Http\Controllers\Resources;

use App\Events\Product\ProductCreatedEvent;
use App\Events\Product\ProductFinished;
use App\Events\Product\ProductStarted;
use App\Exports\ProductExport;
use App\Http\Controllers\Services\ProductService;
use App\Models\Product;
use App\Notifications\NewProduct;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Storage;
use Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use View;

class ProductController extends Controller
{
    /**
     * The current user.
     *
     * @var User
     */
    private $user;

    /**
     * An array of products.
     *
     * @var Product[]
     */
    private $producten = [];

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:read,\\App\\Models\\Product')
            ->only(['index', 'show', 'showImage', 'download']);

        $this->middleware('permission:create,\\App\\Models\\Product')
            ->only(['create', 'store']);

        $this->middleware('permission:update,\\App\\Models\\Product')
            ->only(['edit', 'update']);

        $this->middleware('permission:delete,\\App\\Models\\Product')
            ->only('destroy');
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

        return View::make('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request the current request.
     *
     * @return RedirectResponse|Response
     */
    public function store(Request $request)
    {
        try {
            $productService = new ProductService($request);
            $product = $productService->store();

            return redirect()
                ->route('products.index', $product->id)
                ->with('clearStorage', true);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage(), $exception->getTrace());

            return back()
                ->with(
                    'status',
                    'De aanvraag is niet doorgekomen.
                    Neem contact met ons op als dit vaker voorkomt'
                );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product the product injected via {param}.
     *
     * @return \Illuminate\Contracts\View\View|Response
     */
    public function show(Product $product)
    {
        return View::make('products.show')
            ->with('product', $product);
    }

    /**
     * Fetch attachment for a product.
     *
     * @param Product $product the product to fetch attachment for.
     *
     * @return StreamedResponse
     */
    public function showImage(Product $product): StreamedResponse
    {
        return \Storage::download($product->info->attachment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product the product that is going to be edited.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        //
        return View::make('products.edit')
            ->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request the current request.
     * @param Product $product the requested product injected via URL {param}
     *
     * @return RedirectResponse|Response
     */
    public function update(Request $request, Product $product)
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

        return back()
            ->with('status', 'Product aangepast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product the product to be removed.
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        //
        try {
            $product->delete();
            return redirect()
                ->route('products.index')
                ->with('status', 'Product verwijderd!');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
            return redirect()
                ->route('products.index')
                ->with('status', 'Er is iets fout gegaan met verwijderen.');
        }
    }

    public function download()
    {
        try {
            return Excel::download(new ProductExport(), 'producten.xlsx');
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
            return response()
                ->json(
                    [
                        'message'   => $e->getMessage(),
                        'code'      => $e->getCode(),
                        'trace'     => $e->getTraceAsString()
                    ]
                );
        }
    }

    /**
     * Checks if the user is an admin.
     *
     * @return bool
     */
    private function isAnAdmin(): bool
    {
        $this->setUser();
        return $this->user->isAn('admin');
    }

    /**
     * Checks if the user is a designer.
     *
     * @return bool
     */
    private function isADesigner(): bool
    {
        $this->setUser();
        return $this->user->isA('designer');
    }

    /**
     * Sets the products in a private variable
     *
     * @return void
     */
    private function fetchOwnedProducts(): void
    {
        $this->setUser();
        $this->producten = Product::byUser(Auth::user())
                                  ->orderByDesc('deadline')
                                  ->get();
    }

    /**
     * Sets all products in private variable
     *
     * @return void
     */
    private function fetchAllProducts(): void
    {
        $this->producten = Product::orderByDesc('deadline')->get();
    }

    /**
     * Sets the current user.
     *
     * @return void
     */
    private function setUser(): void
    {
        if (!isset($this->user)) {
            $this->user = Auth::user();
        }
    }
}
