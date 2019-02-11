<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('options')->comment('JSON via PHP')->nullable();
            $table->string('format')->comment('Like A4 or 21x25mm')->nullable();
            $table->string('attachment')->comment('Path to attachment')->nullable();
            $table->string('factuur')->comment('The factuur id from informer')->nullable();
            $table->string('kostenplaats')->comment('Kostenplaats')->nullable();
            $table->string('referentie')->comment('Referentie')->nullable();
            
            $table->unsignedInteger('user_id')->comment('Is the requestee');
            
            $table->enum('soort', [ 'digitaal', 'drukwerk' ]);
            $table->enum('status', [ 'aangevraagd', 'opgepakt', 'afgerond' ]);
            
            $table->timestamp('deadline')->comment('When should the product be finished');
            $table->timestamps();
    
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
