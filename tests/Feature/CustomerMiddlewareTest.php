<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class CustomerMiddlewareTest extends TestCase
{

    use RefreshDatabase;


    /**
     * Test token not sent returns 401 error
     *
     * @return void
     */
    public function test_response_401_for_token_not_in_request()
    {

        $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer ',
        ])->get('api/orders')->assertStatus(401);
    }


     /**
     * Test invalid token not sent return 403 error
     *
     * @return void
     */
    public function test_response_403_for_invalid_token_not_request()
    {

        $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer invalidtoken',
        ])->get('api/orders')->assertStatus(403);
    }

    /**
     * Test expired user token returns 403 error
     *
     * @return void
     */
    public function test_expired_user_token_return_403_error()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $user = User::find(1);
        $token = $user->createJWT(true,1);
        sleep(1);
        $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('api/orders')->assertStatus(403);
    }

    /**
     * Test token for non-existent user is invalid and returns 403 error
     *
     * @return void
     */
    public function test_response_403_for_token_for_invalid_user()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $user = User::find(1);
        $token = $user->createJWT();
        $user->delete();
        $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('api/orders')->assertStatus(403);
    }


    /**
     * Test valid token passes
     *
     * @return void
     */
    public function test_response_200_for_token_for_valid_user()
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
