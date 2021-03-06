<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_skus')) {
            Schema::create('product_skus', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('product_id')->default(0)->comment('商品id');
                $table->string('title', 1024)->default('')->comment('title');
                $table->integer('unti_price')->default(0)->comment('价格');
                $table->tinyInteger('unti')->default(0)->comment('单位');
                $table->integer('stock')->default(0)->comment('库存');
                $table->tinyInteger('shipping_type')->default(0)->comment('发货方式');
                $table->json('extends')->nullable()->comment('扩展');
                $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
                $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
                $table->integer('deleted_at')->unsigned()->default(0)->comment('删除时间');

            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_skus');
        //
    }
}
