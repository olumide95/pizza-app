<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class CustomerTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * Test customer with valid info can register
     *
     * @return void
     */
    public function test_customer_can_register()
    {

        $response = $this->post('api/register',$this->user_data());
        $response->assertJsonStructure([
            'token'
        ]);
        $this->assertEquals(1, User::count());

    }


    /**
     * Test name is passed during registration
     *
     * @return void
     */
    public function test_name_is_required()
    {
        
        $response = $this->post('api/register',array_merge($this->user_data(),['name'=>'']));

        $response->assertStatus(422)->assertJsonStructure([
            'error',
            'message' => [
                'name'
            ]
        ]);

        $this->assertEquals(0, User::count());

    }


    /**
     * Test email is passed unique
     *
     * @return void
     */
    public function test_email_is_unique()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $response = $this->post('api/register',array_merge($this->user_data(),['email'=>$user_data['email']]));

        $response->assertStatus(422)->assertJsonStructure([
            'error',
            'message' => [
                'email'
            ]
        ]);

        $this->assertEquals(1, User::count());

    }


    /**
     * Test customer with valid info can login
     *
     * @return void
     */
    public function test_customer_with_correct_login_info()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $response = $this->post('api/login',['email'=>$user_data['email'],'password'=>$user_data['password']])
        ->assertJsonStructure([
            'token'
        ])->assertOk();

        $this->assertEquals(1, User::count());
    }

    /**
     * Test customer with invalid info cant login
     *
     * @return void
     */
    public function test_customer_with_incorrect_login_info()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $response = $this->post('api/login',['email'=>$user_data['email'],'password'=>'wrong password'])->assertStatus(401);

        $this->assertEquals(1, User::count());
    }


    /**
     * Test email is required on login
     *
     * @return void
     */
    public function test_customer_email_is_required_on_login()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $response = $this->post('api/login',['email'=>'','password'=>$user_data['password']])->assertStatus(422);

        $response->assertStatus(422)->assertJsonStructure([
            'error',
            'message' => [
                'email'
            ]
        ]);
    }


    /**
     * Test password is required on login
     *
     * @return void
     */
    public function test_customer_password_is_required_on_login()
    {
        $user_data = $this->user_data();

        $this->post('api/register',$user_data);

        $response = $this->post('api/login',['email'=>$user_data['email'],'password'=>''])->assertStatus(422);

        $response->assertStatus(422)->assertJsonStructure([
            'error',
            'message' => [
                'password'
            ]
        ]);
    }


    /**
     * Test password is confirmed on register
     *
     * @return void
     */
    public function test_customer_password_is_confirmed_on_register()
    {

        $response =  $this->post('api/register',array_merge($this->user_data(),['password_confirmation'=>'']))->assertStatus(422);

        $response->assertStatus(422)->assertJsonStructure([
            'error',
            'message' => [
                'password'
            ]
        ]);
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
