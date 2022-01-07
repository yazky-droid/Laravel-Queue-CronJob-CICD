<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 5),
            'product_id' => $this->faker->numberBetween(1,3),
            'product_qty' => $this->faker->numberBetween(1,10),
            'amount' => $this->faker->numberBetween(10000,100000),
            'status' => Transaction::STATUS[$this->faker->numberBetween(0,2)],
        ];
    }
}
