<?php

namespace App\Http\Controllers\Resources;

use App\Events\Product\ProductCreatedEvent;
use App\Events\Product\ProductFinished;
use App\Events\Product\ProductStarted;
use App\Exports\ProductExport;
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
    private $_user;
    
    /**
     * An array of products.
     *
     * @var array
     */
    private $_producten = [];
    
    /**
     * ProductController constructor.
     */
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
        ($this->_isAnAdmin() || $this->_isADesigner())
            ? $this->_fetchAllProducts() : $this->_fetchOwnedProducts();
        
        return View::make('products.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        //
        if ($this->_isADesigner()) {
            return redirect()
                ->to('/')
                ->with('status', 'Je bent niet bevoegd om deze pagina te bekijken');
        }
        
        return View::make('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request the current request.
     *
     * @return Response
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
            $atts['attachment'] = $path?? null;
            $atts['user_id'] = $request->has('user_id') ?
                $request->get('user_id') :
                Auth::user()->id;
            
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
            
            return redirect()
                ->route('products.show', $product->id)
                ->with('clearStorage', true);
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
     * @param Product $product the product injected via {param}.
     *
     * @return Response
     */
    public function show(Product $product)
    {
        //
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
        return \Storage::download($product->attachment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product the product that is going to be edited.
     *
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        //
        
        if ($request->has('status')) {
            if ($request->get('status') === 'opgepakt') {
                try {
                    event(new ProductStarted($product));
                } catch (Exception $exception) {
                    return back()->with('status', $exception->getMessage());
                }
            }
            
            if ($request->get('status') === 'afgerond') {
                try {
                    event(new ProductFinished($product));
                } catch (Exception $exception) {
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
            return redirect()
                ->route('products.index')
                ->with('status', 'Er is iets fout gegaan met verwijderen.');
        }
    }
    
    public function download()
    {
        try {
            return Excel::download(new ProductExport(), 'producten.xlsx');
        } catch (\Exception $e) {
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
