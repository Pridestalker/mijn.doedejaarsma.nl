<?php

namespace App\Console\Commands\Sync;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:product-order
    {ids* : The product IDS to send to the order table}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs product to order database';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ids = $this->argument('ids');

        foreach ($ids as $id) {
            if (Order::find($id)) {
                $this->warn("Product with $id already exists.");
                $this->info('skipping');
                continue;
            }
            try {
                $product = Product::findOrFail($id);
            } catch (ModelNotFoundException $exception) {
                $this->warn("product with $id not found.");
                $this->info('skipping');
                continue;
            }

            $order = new Order([
                'user_id'   => $product->user->id,
                'status'    => $product->status,
                'deadline'  => $product->deadline,
                'updated_by'=> $product->updated_by,
            ]);

            $product->order()->save($order);

            $this->line("Created Order: {$order->id}");
        }
    }
}
