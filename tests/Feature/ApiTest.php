<?php

namespace Tests\Feature;

use AWS\CRT\HTTP\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_checkout_status()
    {
        $response = $this->post('/api/checkout', [
                    'user_id' => '1',
                    'product_id' => '1',
                    'product_qty' => '2',
                    'expired_at' => now(),
                    'amount' => '20.000',
                    'date' => '2',
        ]);

        $response->assertStatus(200);
    }

    // public function test_api_transaction_history()
    // {
    //     // test failed get data
    //     $response = $this->get('/api/transaction-history/2');

    //     $response->assertStatus(200);
    // }

    // public function test_api_()
    // {

    // }
}
