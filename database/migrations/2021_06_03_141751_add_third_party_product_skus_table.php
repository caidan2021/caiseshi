<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThirdPartyProductSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('third_party_product_skus')) {
            Schema::create('third_party_product_skus', function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('module_type')->default(0)->comment('记录的type，1：标题；2：五点；...');
                $table->unsignedInteger('product_id')->default(0)->comment('商品id');
                $table->unsignedInteger('self_sku_id')->default(0)->comment('css的skuId');
                $table->string('title', 1024)->default('')->comment('title');
                $table->integer('unit_price')->default(0)->comment('价格');
                $table->tinyInteger('unit')->default(0)->comment('单位');
                $table->integer('stock')->default(0)->comment('库存');
                $table->tinyInteger('shipping_type')->default(0)->comment('发货方式');
                $table->json('images')->nullable()->comment('图片');
                $table->json('five_point')->nullable()->comment('五点');
                $table->json('search_term')->nullable();
                $table->json('description')->nullable()->comment('详情');
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
        //
        Schema::dropIfExists('third_party_product_skus');

    }
}
