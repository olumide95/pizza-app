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

       return $this->respondWithSuccess(['data' => $menu]);
    }
}
