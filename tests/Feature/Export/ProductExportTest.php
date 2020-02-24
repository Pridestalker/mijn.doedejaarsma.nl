<?php

namespace Tests\Feature\Export;

use Excel;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductExportTest extends ExportTestCase
{
	use RefreshDatabase;

    /**
     * Test if exports are downloadable.
     *
     * @test
     * @testdox An export can be downloaded
     *
     * @return void
     */
    public function exportsAreDownloadabe(): void
    {
        Excel::fake();
        factory(Product::class, 5)->create();

        $this->runWithActor('admin');

        $this->get(route('download.product.all'));

        Excel::assertDownloaded('producten.xlsx');
    }
}
