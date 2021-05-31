<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->increments('id')->comments('id');
                $table->string('title', 1024)->default('')->comments('标题');
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
        Schema::dropIfExists('products');
    }
}
