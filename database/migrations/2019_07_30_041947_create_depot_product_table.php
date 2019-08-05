<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepotProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_product', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('depot_id')->unsigned();
            $table->bigInteger('count')->default(5000)->unsigned();
            $table->timestamps();
            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('depot_id')->references('id')
                ->on('depots')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depot_product');
    }
}
