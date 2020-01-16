<?php

namespace App\Http\Controllers\Services;

use Log;
use Auth;
use App\User;
use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\Product\ProductCreatedEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductService
{
    protected $model = Product::class;

    protected $request;

    protected $product;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Product|\Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function store()
    {
        $validated = \Validator::make(
            $this->request->all(),
            [
                'name'      => 'required|string',
                'deadline'  => 'required',
                'soort'     => 'required',
            ]
        );

        if ($validated->fails()) {
            \Session::flash('errors', $validated->errors());
            throw new BadRequestHttpException('Not all fields are filled');
        }

        if ($this->hasFile()) {
            $path = $this->storeFile();
        } else {
            $path = null;
        }

        // Attachment is stored separately
        $attributes = collect($this->request->except('attachment'));
        $attributes->put('status', 'aangevraagd');
        $attributes->put('user_id', $this->getUserId());

        try {
            $this->product = Product::create([
                'name'  => $attributes->get('name')
            ]);

            $this->product->order()->create([
                'user_id'   => $attributes->get('user_id'),
                'status'    => $attributes->get('status'),
                'deadline'  => $attributes->get('deadline')
            ]);

            $this->product->info()->create([
                'description'   => $attributes->get('description'),
                'attachment'    => $path,
                'options'       => $this->getPrintOptions(),
                'format'        => $attributes->get('format'),
                'type'          => $attributes->get('soort'),
                'cost_centre'   => $attributes->get('kostenplaats'),
                'reference'     => $attributes->get('referentie')
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
            throw new Exception('Error creating product');
        }

        if ($this->product::exists()) {
            if ('std_product' !== $this->request->input('product_type')) {
                event(new ProductCreatedEvent($this->product, $this->getUser()));
            }

            return $this->product;
        }

        Log::error('Aanvraag error', [ 'user' => Auth::user()]);
        throw new \RuntimeException('Error creating product');
    }

    protected function getUser()
    {
        try {
            return User::findOrFail($this->getUserId());
        } catch (Exception $exception) {
            return Auth::user();
        }
    }

    protected function getUserId()
    {
        return $this->request->input('user_id', Auth::user()->id);
    }

    protected function getPrintOptions(): ?string
    {
        if ($this->hasPrintOptions()) {
            $data = [
                'oplage' => $this->request->get('oplage') ?? '',
                'papier' => $this->request->get('papier') ?? '',
                'gewicht' => $this->request->get('gewicht') ?? '',
                'afleveradres' => $this->request->get('afleveradres') ?? '',
            ];

            return json_encode($data);
        }

        return null;
    }

    protected function hasPrintOptions(): bool
    {
        return $this->request->hasAny(['oplage','papier','gewicht','afleveradres']);
    }

    protected function hasFile(): bool
    {
        return $this->request->hasFile('attachment');
    }

    protected function storeFile()
    {
        /* @noinspection NullPointerExceptionInspection */
        return $this
            ->request
            ->file('attachment')
            ->storePublicly('voorbeelden');
    }
}
