<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Menu;
use App\DeliveryInfo;
use App\Helpers\Helpers;
use Illuminate\Http\JsonResponse;
class OrderController extends Controller
{


    /**
     * List registered user orders
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request): JsonResponse
    {
        
        $orders = DeliveryInfo::where('user_id',$request->auth->id)->with('order')->get();
       
        return $this->respondWithSuccess(['data' => $orders]);
    }



    /**
     * Take customers order
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function take_order(Request $request) : JsonResponse
    {
    
        $validator = $request->validate([
            'order'=>'required',
            'order.*.uuid'  => 'required',
            'order.*.quantity'     => 'required',
            'customer_name'  => 'required',
            'customer_phone'     => 'required',
            'delivery_address'  => 'required'
        ]);

        $data = [];

        $delivery_info = $request->except('order');
        
        $order = $request->order;

        if (!is_array($request->order)) {
            $order = json_decode($request->order);
        }

        $order_id = Helpers::OrderID();
        $user_uuid = $request->get('user_id',null);

        $data['order_id'] = $order_id;

        $data['user_id'] = NULL;

        $user = User::where('uuid',$user_uuid)->first();
        if(isset($user->id)){
            $data['user_id'] =  $user->id;
        }

        foreach($order as $item){
            $item = (array)$item;
        
            $menu_item = Menu::where('uuid',$item['uuid'])->first();

            $data['menu_id'] =  $menu_item->id;
            $data['amount'] =   $menu_item->amount;
            
            
            $order = Order::create(array_merge($item,$data));
        }

        $delivery_info = DeliveryInfo::create(array_merge($delivery_info,$data));

        return $this->respondWithSuccess([ 'message' => 'Order Has been Placed successfully!']);

        
    }
}
