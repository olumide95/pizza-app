<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Menu;

class MenuTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * Test Menu list has 10 Items
     *
     * @return void
     */
    public function test_menu_has_more_than_7_items()
    {
        $this->artisan("db:seed");
        $this->assertGreaterThanOrEqual(8, Menu::count());
    }


    /**
     * Test Menu list route returns 200 OK
     *
     * @return void
     */
    public function test_menu_list()
    {
        $this->artisan("db:seed");
        $response = $this->get('/api/menu')->assertOk();
    }
}
