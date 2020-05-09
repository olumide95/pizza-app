<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class MenuController extends Controller
{
    /**
     * List items on the menu
     *
     * @return JsonResponse
     */
    public function index()
    {
       $menu = Menu::all();
       
       if($menu->isEmpty()){
        return $this->respondWithError('There are no items in the menu',404);
       }

       $store_info = ['delivery_cost'=>env('DELIVERY_COST'),'EUR_TO_USD'=>env('EUR_TO_USD')];
       
       return $this->respondWithSuccess(['data' => $menu,'store_info'=>$store_info]);
    }
}
