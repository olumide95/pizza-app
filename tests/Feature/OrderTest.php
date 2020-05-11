<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;
use App\User;
use App\Menu;

class OrderTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * Test order confirmation request
     *
     * @return void
     */
    public function test_order_items_are_required()
    {
        $order_data = $this->order_data();
        unset($order_data['order']);
        
        $response = $this->post('api/order',$order_data)->assertStatus(422)->assertJsonStructure([
            'error',
            'message' => [
                'order'
            ]
        ]);
    }


    /**
     * Test order confirmation request
     *
     * @return void
     */
    public function test_delivery_information_are_required()
    {
        $order_data = $this->order_data();
        unset($order_data['customer_name']);
        unset($order_data['customer_phone']);
        unset($order_data['delivery_address']);
        
        $response = $this->post('api/order',$order_data)->assertStatus(422)->assertJsonStructure([
            'error',
            'message' => [
                'customer_name',
                'customer_phone',
                'delivery_address'
            ]
        ]);
    }


    /**
     * Test customer can order
     *
     * @return void
     */
    public function test_customer_can_order()
    {
        $this->artisan("db:seed");

        $order_data = $this->order_data();

        $menu_item = Menu::find(1);

        $order_data['order'][0]['uuid'] = $menu_item->uuid;
        $order_data['order'][0]['quantity'] =  1;
        $order_data['order'][0]['amount'] =  $menu_item->amount;
        
        $response = $this->post('api/order',$order_data)->assertStatus(200);
    }



    /**
     * Test logged in user can view order
     *
     * @return void
     */
    public function test_logged_in_user_can_view_order()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $user = User::find(1);
        $token = $user->createJWT();

        $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('api/orders')->assertStatus(200);
    }


    /**
     * Test only guest user cannot view order
     *
     * @return void
     */
    public function test_guest_customer_cannot_view_order()
    {
        $response = $this->get('api/orders')->assertStatus(401)->assertJsonStructure([
            "status_code",
            "message"
        ]);
    }


    /**
     * Dummy order data
     *
     * @return array
     */
    public function order_data()
    {
        $faker = \Faker\Factory::create();

        return [
            'customer_name' => $faker->name,
            'customer_phone' => $faker->phoneNumber,
            'delivery_address' => $faker->address,
            'order' => []
        ];
    }

    /**
     * Dummy user data
     *
     * @return array
     */
    public function user_data()
    {
        $faker = \Faker\Factory::create();

        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    
}
