<?php

namespace App\Http\Controllers\Services;

use App\Models\StandardProduct;
use Auth;
use Illuminate\Http\Request;

class StandardProductService
{
    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var StandardProduct $product
     */
    protected $product;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {
        $validated = \Validator::make(
            $this->request->all(),
            [
                'name'      => 'required|string',
                'team_id'   => 'required',
            ]
        );

        if ($validated->fails()) {
            \Session::flash('errors', $validated->errors);
            throw new \RuntimeException('Not all required fields are filled');
        }

        if ($this->hasFile()) {
            $path = $this->storeFile();
        } else {
            $path = null;
        }

        $attributes = collect($this->request->except('attachment'));

        try {
            $this->product = StandardProduct::create([
                'name'      => $attributes->get('name'),
                'team_id'   => $attributes->get('team_id')
            ]);

            $this->product->info()->create([
                'options'    => $this->getPrintOptions(),
                'format'     => $attributes->get('format'),
                'type'       => $attributes->get('soort'),
                'attachment' => $path
            ]);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage(), $exception->getTrace());
            throw $exception;
        }

        return $this->product;
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

            return json_encode($data, JSON_THROW_ON_ERROR, 512);
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
            ->storePublicly('std_products/voorbeelden');
    }

    public static function make(...$params): self
    {
        return new static(...$params);
    }
}
