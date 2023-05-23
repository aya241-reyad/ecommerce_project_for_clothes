<?php

namespace App\Http\Controllers\api;

use App\Models\Gov;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\CouponUser;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\helpers\helper;
use App\Http\Controllers\Controller;
use App\Models\Coupon   ;
use DB;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->helper = new helper();
    }

    public function checkout(Request $request){
        $validator=validator()->make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'company_name'=>'required',
            'governorate_id'=>'required|exists:govs,id',
            'address'=>'required',
            'city'=>'required',
            'country_state'=>'required',
            'post_code'=>'required',
            'phone'=>'required',
            'notes'=>'required',
            ]);
            if($validator->fails()){
          return $this->helper->ResponseJson(0,$validator->errors()->first(),$validator->errors());
            }
            $order = Order::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_name'=>$request->company_name,
                'governorate_id'=>auth()->user()->governorate_id,
                'address'=>$request->address,
                'city'=>$request->city,
                'country_state'=>$request->country_state,
                'post_code'=>$request->post_code,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'notes'=>$request->notes,
                'client_id'=>auth()->user()->id,
                'total_after_disc'=>$request->total_after_disc
            ]);
            $order->save();
            $cart=Cart::where('client_id',auth()->user()->id)->get();
        if($cart != '[]'){
            
        

            foreach($cart as $item)
            {
                OrderItem::create([
                    'product_id'=>$item->product_id,
                    'product_color_id'=>$item->product_color_id,
                    'product_size_id'=>$item->product_size_id,
                    'quantity'=>$item->quantity,
                    'price'=>$item->price,
                    'sub_total'=>$item->sub_total,
                    'order_id'=>$order->id,
                    'category_id'=>$item->category_id
    
                ]);
                $product = Product::where('id',$item->product_id)->first();
                $product->decrement('quantity',$item->quantity);
                $price = Cart::where('id',$item->id)->first();
                 $collectCartPrice[] = $item->sub_total;
            }
            $sub_total = array_sum($collectCartPrice);
            if(!Shipping::where('governorate_id',auth()->user()->governorate_id)->first())
            {
                $shipping = 0;
            }else{
                            $shipping = Shipping::where('governorate_id',auth()->user()->governorate_id)->first()->value('cost');

            }

            $total = $sub_total + $shipping;
     if ($request->total_after_disc == 0) {
                     $order->update([
                'sub_total' => $sub_total,
                'total' => $total,
                'total_after_disc' => $total
            ]);

     }else{
          $order->update([
                'sub_total' => $sub_total,
                'total' => $total,
                'total_after_disc' => $request->total_after_disc
            ]);

     }
    
    
            $cartItems = Cart::where('client_id',auth()->user()->id)->get();
    
            Cart::destroy($cartItems);
    
    
    
               return $this->helper->ResponseJson(1, __('apis.success'), $order);
        }else{
                           return $this->helper->ResponseJson(1, __('apis.cart_is_empty'),[]);

        }
    
    }
    
    public function coupon(Request $request)
    {

        if (!$coupon = Coupon::whereCouponNum($request->coupon_num)->first()) {
            return ['msg' => __('apis.not_avilable_coupon'), 'key' => 'fail'];
        }
        if ($coupon->status == 'closed') {
            return ['msg' => __('apis.not_avilable_coupon'), 'key' => 'fail'];
        }
        if ($coupon->status == 'usage_end') {
            return ['msg' => __('apis.max_usa_coupon'), 'key' => 'fail'];
        }

        if ($coupon->expire_date < today()) {
            $coupon->update([
                'status' => 'expire',
            ]);

            return ['msg' => __('apis.coupon_end_at', [ date('d-m-Y  h:i A', strtotime($coupon->expire_date))]), 'key' => 'fail'];
            
        }
        if ($coupon->use_times >= $coupon->max_use) {
            $coupon->update([
                'status' => 'usage_end',
            ]);

            return $this->helper->responseJson('1', __('apis.usage_end'));

        }
                $redeemer = CouponUser::where('client_id',auth()->user()->id)->first();

        if (optional($redeemer)->client_id == auth()->user()->id ){
            return ['msg' => __('apis.already_use'), 'key' => 'fail'];

            }

        $couponUse = CouponUser::firstOrCreate([
            
            'coupon_id' => $coupon->id,
            'client_id'=> auth()->user()->id
            ]) ;

        $coupon->increment('use_times', 1);

        if ('ratio' == $coupon->type) {
            $disc_amount = $coupon->discount * $request->total_price / 100;
            if ($disc_amount > $coupon->max_discount) {
                $disc_amount = $coupon->max_discount;
                $total_price = $request->total_price - $disc_amount;

            }
            $total_price = $request->total_price - $disc_amount;

        } else {
            $disc_amount = $coupon->discount;
            $total_price = $request->total_price - $disc_amount;
        }

        return [
            'msg' => __('apis.disc_amount') . ' ' . $disc_amount,
            'key' => 'success',
            'data' => [
                'disc_amount' => $disc_amount,
                'total_price' => $total_price,
                'coupon' => $coupon->only(['type', 'discount', 'id']),
            ],
        ];

    }






}
