<?php

namespace App\Http\Controllers\FrontEnd;

use Cart;
use App\Coupon;
use App\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $output = '';
            $output_2 = '';
            $output_3 = '';
            $total = 0;
            if(Cart::content()->count() > 0){
                foreach(Cart::content() as $cten){
                    $max_qty = Products::where('product_id',$cten->id)->first();
                    $total += ($cten->qty)*($cten->price);
                    $output .='
                    <tr class="first odd">
                        <td class="image">
                            <a class="product-image" title="Sample Product"
                                href="'.route('product-detail.show',$cten->id).'">
                                <img width="75px" alt="'.$cten->name.'"
                                    src="'.url('uploads/product/'.$cten->options->image).'">
                            </a>
                        </td>
                        <td>
                            <h2 class="product-name"> <a
                                    href="'.route('product-detail.show',$cten->id).'">'.$cten->name.'</a>
                            </h2>
                        </td>
                        <td class="a-center">
                            <a title="Edit item parameters" class="edit-bnt"
                                href="#configure/id/15945/"></a>
                        </td>
                        <td class="a-right">
                            <span class="cart-price"> <span class="price">'.number_format($cten->price).' vnđ</span> </span>
                        </td>
                        <td class="a-center movewishlist">
                            <input type="number" maxlength="12" max="'.$max_qty->product_quantity.'"
                                    class="input-text qty updateqty" title="Qty"
                                    data-id="'.$cten->id.'" data-rowid="'.$cten->rowId.'"
                                    value="'.$cten->qty.'" name="cartqty"
                                    oninput="this.value = Math.abs(this.value)">
                        </td>
                        <td class="a-right movewishlist">
                            <span class="cart-price">
                                <span class="price">
                                '.number_format(($cten->qty)*($cten->price)).' vnđ
                                </span>
                            </span>
                        </td>
                        <td class="a-center last">
                            <a class="button remove-item remove_cart_rowId" data-href_rowid="'.route('cart.show',$cten->rowId).'" title="Remove item"><span>Remove item</span></a>
                        </td>
                    </tr>';
                }
                $output_3 .= '
                    <button id="empty_cart_button" class="button btn-empty" title="Clear Cart" value="empty_cart" name="update_cart_action"
                    type="button"><span>Clear Cart</span></button>';
                    if(Session::get('coupon')){
                        $output_3 .= '<button class="button btn-update" title="Clear Coupon" id="empty_coupon_button"
                        type="button"><span>Clear Coupon</span></button>';
                    }
            }else{
                $output .='
                <tr class="first odd">
                    <td colspan="7" style="text-align: center; font-size: 16px; color: #eaeaea; font-weight: bold; text-shadow: 1px 1px #b3afaf, -1px -1px #cac6c6;">Product Not Found</td>
                </tr>';
            }
            $output_2 .='
                <tr>
                    <td colspan="1" class="a-left"> Tax </td>
                    <td class="a-right"><span class="price">'.number_format($total*0.02).' vnđ</span></td>
                </tr>';
                if(Session::get('coupon')){
                    foreach(Session::get('coupon') as $copo){
                    $output_2 .='
                        <tr>
                            <td colspan="1" class="a-left"> Coupon </td>
                            <td class="a-right"><span class="price">'.number_format($total*($copo['coupon_number']/100)).' vnđ</span></td>
                        </tr>';
                    }
                }
                $output_2 .='
                <tr>
                    <td colspan="1" class="a-left"> Subtotal </td>
                    <td class="a-right"><span class="price">'.number_format($total).' vnđ</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" class="a-left"><strong>Grand Total</strong></td>';
                    if(Session::get('coupon')){
                        foreach(Session::get('coupon') as $copo){
                            if($copo['coupon_condition'] == 2){

                                $output_2 .='<td class="a-right"><strong><span class="price">'.number_format($total+($total*0.02)-($total*($copo['coupon_number']/100))).' vnđ</span></strong></td>';
                            }else{

                                $output_2 .='<td class="a-right"><strong><span class="price">'.number_format(($total+($total*0.02))-$copo['coupon_number']).' vnđ</span></strong></td>';
                            }
                        }
                    }else{
                        $output_2 .='<td class="a-right"><strong><span class="price">'.number_format($total+($total*0.02)).' vnđ</span></strong></td>';
                    }
                    $output_2 .='
                </tr>
            ';

            return response()->json([
                'data'=>$output,
                'dataTotal'=>$output_2,
                'dataDel'=>$output_3
            ]);
        }

        return view('FrontEnd.shoppingCart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            if(request()->action){
                Session::forget('coupon');
            }else if(Cart::content()->count() == 0){
                Session::forget('coupon');

                return response()->json([
                    'status'=>200
                ]);
            }else{
                return response()->json([
                    'status'=>403
                ]);
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            if ($request->coupon_code) {
                $data = $request->all();
                $today_d =  Carbon::now('Asia/Ho_Chi_Minh')->format('d');
                $today_m =  Carbon::now('Asia/Ho_Chi_Minh')->format('m');
                $today_y =  Carbon::now('Asia/Ho_Chi_Minh')->format('Y');
                if (Auth::user()) {
                    $date_coupon = Coupon::where('coupon_code', $data['coupon_code'])->where('coupon_status',1)->first();
                    if ($date_coupon) {
                        $create = date_create($date_coupon->coupon_date_end);
                        $day = date_format($create,'d');
                        $month = date_format($create,'m');
                        $year = date_format($create,'Y');

                        if ($month > $today_m && $year >= $today_y) {
                            $used_coupon = Coupon::where('coupon_code', $data['coupon_code'])->where('coupon_status',1)->where('coupon_used', 'LIKE', '%'.Auth::id().'%')->first();
                        }else if($month == $today_m && $year == $today_y){
                            if ($day >= $today_d) {
                                $used_coupon = Coupon::where('coupon_code', $data['coupon_code'])->where('coupon_status',1)->where('coupon_used', 'LIKE', '%'.Auth::id().'%')->first();
                            }else{
                                return response()->json(['error'=>'The discount code is incorrect or has expired']);
                            }
                        }else{
                            return response()->json(['error'=>'The discount code is incorrect or has expired']);
                        }



                    }else{
                        return response()->json(['error'=>'The discount code is incorrect or has expired']);
                    }
                }else{
                    return response()->json([
                        'url'=>route('login.index'),
                        'error_login'=>'Please login to use discount code!'
                    ]);
                }

                if ($used_coupon) {
                    return response()->json(['error'=>'Discount code already used, please enter another code']);
                }else{
                    $date_coupon = Coupon::where('coupon_code', $data['coupon_code'])->where('coupon_status',1)->first();
                    $create_date = date_create($date_coupon->coupon_date_end);
                    $day = date_format($create_date,'d');
                    $month = date_format($create_date,'m');
                    $year = date_format($create_date,'Y');
                    if ($month > $today_m && $year >= $today_y) {
                        $coupon = Coupon::where('coupon_code', $data['coupon_code'])->where('coupon_status',1)->first();
                    }else if($month == $today_m && $year == $today_y){
                        if ($day >= $today_d) {
                            $coupon = Coupon::where('coupon_code', $data['coupon_code'])->where('coupon_status',1)->first();
                        }else{
                            return response()->json(['error'=>'The discount code is incorrect or has expired']);
                        }
                    }else{
                        return response()->json(['error'=>'The discount code is incorrect or has expired']);
                    }

                    if ($coupon) {
                        $coupon_count = $coupon->count();
                        if ($coupon_count>0) {
                            $coupon_session = Session::get('coupon');
                            if ($coupon_session==true) {
                                $is_avaiable = 0;
                                if ($is_avaiable==0) {
                                    $coun[] = array(
                                        'coupon_code' => $coupon->coupon_code,
                                        'coupon_condition' => $coupon->coupon_condition,
                                        'coupon_number' => $coupon->coupon_sale_number,
                                    );
                                    Session::put('coupon',$coun);
                                }
                            }else{
                                $coun[] = array(
                                        'coupon_code' => $coupon->coupon_code,
                                        'coupon_condition' => $coupon->coupon_condition,
                                        'coupon_number' => $coupon->coupon_sale_number,
                                    );
                                Session::put('coupon',$coun);
                            }
                            Session::save();

                            return response()->json(['message'=>'Add Coupon Successfully']);

                        }
                    }else{
                        return response()->json(['error'=>'The discount code is incorrect or has expired']);
                    }
                }
            }else
            if($request->id_pro){
                $product_cart = Products::where('product_id',$request->id_pro)->first();
                if ($request->qtycart == '') {
                    $quantity = 1;
                }else{
                    $quantity = $request->qtycart;
                }
                if ($product_cart->product_price_sale != 0) {
                    $price = $product_cart->product_price_sale;
                }else{
                    $price = $product_cart->product_price;
                }
                $data['id'] = $product_cart->product_id;
                $data['qty'] = $quantity;
                $data['name'] = $product_cart->product_name;
                $data['price'] = $price;
                $data['weight'] = $price;
                $data['options']['image'] = $product_cart->product_image;
                $data['options']['slug'] = $product_cart->product_slug;
                Cart::add($data);

                return response()->json([
                    'status'=>200,
                    'message'=>'Add Cart Successfully'
                ]);
            }else{
                Cart::destroy();
                return response()->json([
                    'status'=>200
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()){
            if(request()->qty){
                $pro = Products::findOrfail(request()->id_pro);
                if(request()->qty <= $pro->product_quantity){
                    Cart::update($id, request()->qty);
                    return response()->json([
                        'status'=>200,
                        'message'=>'Update Qty Successfully'
                    ]);
                }else{
                    return response()->json([
                        'status'=>403,
                        'message'=>'Qty is too large'
                    ]);
                }
            }else{
                Cart::update($id, 0);
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
