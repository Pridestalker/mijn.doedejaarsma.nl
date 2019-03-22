<?php

namespace Tests\Feature\Export;

use App\Models\Product;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductExport extends TestCase
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
        factory(Product::class)->create()->times(5);
        
        $user = factory(User::class)->create();
        
        $this->actingAs($user);
        
        $res = $this->get(route('download.product.all'));
        
        Excel::assertDownloaded('products.xlsx');
        
    }
}
