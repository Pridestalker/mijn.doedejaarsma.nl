<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->unsignedInteger('user_id');
                $table->string('orderable_type');
                $table->unsignedBigInteger('orderable_id');
                $table->enum('status', ['aangevraagd', 'opgepakt', 'afgerond']);
                $table->timestamp('deadline');
                $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('standard_products', static function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->string('name');
                $table->unsignedInteger('team_id');
            $table->timestamps();

            $table->foreign('team_id')
                  ->references('id')->on('teams')
                  ->onDelete('cascade');
        });

        Schema::create('cost_centres', static function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->string('name');
                $table->unsignedInteger('team_id');
            $table->timestamps();

            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');
        });

        Schema::create('info_products', static function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->string('infoable_type');
                $table->unsignedBigInteger('infoable_id');
                $table->text('description')->nullable();
                $table->string('options')->nullable();
                $table->string('format')->nullable();
                $table->string('attachment')->nullable();
                $table->unsignedBigInteger('cost_centre')->nullable();
            $table->timestamps();

            $table->foreign('cost_centre')
                  ->references('id')->on('cost_centres')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('standard_products');
        Schema::dropIfExists('info_products');
        Schema::dropIfExists('cost_centres');
        Schema::dropIfExists('orders');
    }
}
