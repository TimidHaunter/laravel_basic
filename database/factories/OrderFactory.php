<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $addresIds = Address::where('city', '>', 0)->pluck('code');
//        dd($addresIds);


        $orders = [
            'user_id' => 1,
            'order_no' => $this->faker->randomNumber(9, true),
            'amount' => $this->faker->numberBetween(10, 9999999),
            'status' => $this->faker->numberBetween(1, 4),
            'address_id' => $this->faker->randomElement($addresIds),
            'express_type' => '',
            'express_no' => '',
            'pay_time' => null,
            'pay_type' => '',
            'trade_no' => '',
        ];

        // status 1下单 2支付 3发货 4收货
        // 只有发货以后才有 快递类型 和 快递单号
        if ($orders['status'] >= 2) {
            $orders['express_type'] = $this->faker->randomElement(['YD', 'SF', 'YZ', 'ST', 'HT']);
            $orders['express_no'] = $this->faker->randomNumber(9, true);
        }
        // 支付以后才有 支付时间、支付类型、支付单号
        if ($orders['status'] >= 3) {
            $orders['pay_time'] = $this->faker->dateTimeInInterval('now', '+1 days', 'PRC');
            $orders['pay_type'] = $this->faker->randomElement(['wx', 'zfb']);
            $orders['trade_no'] = $this->faker->randomNumber(9, true);
        }

        return $orders;
    }

}
