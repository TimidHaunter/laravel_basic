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
        /**
         * order_no     订单单号
         * user_id      下单用户
         * amount       总金额，单位：分
         * status       订单状态 1下单 2支付 3发货 4收货
         * address_id   收货地址
         * express_type 快递类型 SF YT YD
         * express_no   快递单号
         * pay_time     支付时间
         * pay_type     支付类型 支付宝 微信
         * trade_no     支付单号
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('下单用户');
            $table->string('order_no')->comment('订单单号');
            $table->integer('amount')->comment('总金额，单位：分');
            $table->tinyInteger('status')->default(1)->comment('订单状态 1下单 2支付 3发货 4收货');
            $table->integer('address_id')->comment('收货地址');
            $table->string('express_type')->comment('快递类型 SF YT YD');
            $table->string('express_no')->comment('快递单号');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->string('pay_type')->nullable()->comment('支付类型 支付宝 微信');
            $table->string('trade_no')->nullable()->comment('支付单号');
            $table->timestamps();
            $table->index('order_no');
            $table->index('status');
            $table->index('trade_no');
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
