<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 轮播图迁移文件
 */
class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('轮播图标题');
            $table->string('url')->nullable()->comment('跳转连接');
            $table->string('img')->comment('轮播图图片');
            $table->tinyInteger('status')->default(0)->comment('状态：0禁用；1正常');
            $table->integer('seq')->default(1)->comment('轮播图排序');
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
        Schema::dropIfExists('slides');
    }
}
