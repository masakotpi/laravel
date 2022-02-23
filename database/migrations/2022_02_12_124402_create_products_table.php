<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('商品名');
            $table->string('code')->unique()->comment('商品コード');
            $table->integer('maker_id')->comment('メーカーID');
            $table->string('color')->nullable()->comment('カラー');
            $table->integer('per_case')->comment('入り数');
            $table->float('purchase_price')->comment('下代');
            $table->integer('selling_price')->comment('上代');
            $table->timestamps();
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
