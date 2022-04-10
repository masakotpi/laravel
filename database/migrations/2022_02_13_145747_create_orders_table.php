<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_by')->comment('順番');
            $table->string('order_number')->unique()->comment('注文No.');
            $table->string('product_id')->comment('商品ID');
            $table->integer('maker_id')->comment('メーカーID');
            $table->string('product_name')->comment('商品名');
            $table->string('color')->nullable()->comment('カラー');
            $table->integer('per_case')->comment('入り数');
            $table->integer('quantity')->comment('数量');
            $table->float('purchase_price')->comment('下代');
            $table->date('expected_arrival_date')->nullable()->comment('入荷予定日');
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
        Schema::dropIfExists('orders');
    }
}
