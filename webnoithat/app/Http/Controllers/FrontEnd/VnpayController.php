<?php

namespace App\Http\Controllers\FrontEnd;

use Cart;
use App\City;
use App\User;
use App\Order;
use App\Wards;
use App\Customer;
use App\District;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VnpayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->vnp_ResponseCode == "00" || $request->vnp_ResponseCode == "07") {

            $order_customer = Session::get('order_customer');
            $checkout_code = mt_rand();

            $order = new Order;
            $order->user_id  = Auth::id();
            $order->order_status = 1;
            $order->order_review = 0;
            $order->order_code = $checkout_code;
            $order->save();

            foreach ($order_customer as $data_cus) {
                $customer = new Customer();
                $customer->customer_name = $data_cus['name_order'];
                $customer->customer_phone = $data_cus['phone_number_order'];
                $customer->customer_address = $data_cus['address_order'];
                $customer->customer_note = $data_cus['note_order'];
                $customer->customer_pay = 'ATM-VNPAY';
                $customer->customer_code = $checkout_code;

                $customer->save();
            }

            if(Session::get('cart')==true){
                foreach(Cart::content() as  $cart){
                    $order_details = new OrderDetail;
                    $order_details->order_code = $checkout_code;
                    $order_details->pro_id  = $cart->id;
                    $order_details->order_de_price = $cart->price;
                    $order_details->order_de_qty = $cart->qty;
                    $order_details->order_review = 0;
                    if (Session::get('coupon')) {
                        foreach (Session::get('coupon') as $cou) {
                            $order_details->order_de_coupon =  $cou['coupon_code'];
                        }
                    }else{
                        $order_details->order_de_coupon =  'no';
                    }
                    $order_details->save();
                }
            }
            if (Session::get('coupon')) {
                foreach(Session::get('coupon') as $coun){
                    $coupon_qty = Coupon::where('coupon_code',$coun['coupon_code'])->first();
                    $coupon_qty->coupon_used = ','.Auth::id();
                    $coupon_qty->coupon_qty--;
                    $coupon_qty->save();
                }
            }
            Session::forget('cart');
            Session::forget('coupon');

            if ($request->vnp_ResponseCode == "07") {

                return redirect()->route('home')->with('message','Đặt hàng thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường)');
            }else{

                return redirect()->route('home')->with('message','Đặt hàng thành công');
            }

        }else if ($request->vnp_ResponseCode == "09") {
            return redirect()->route('checkout.index')->with('message','Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng');
        }else if ($request->vnp_ResponseCode == "10") {
            return redirect()->route('checkout.index')->with('message','Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần');
        }else if ($request->vnp_ResponseCode == "11") {
            return redirect()->route('checkout.index')->with('message','Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch');
        }else if ($request->vnp_ResponseCode == "12") {
            return redirect()->route('checkout.index')->with('message','Thẻ/Tài khoản của khách hàng bị khóa');
        }else if ($request->vnp_ResponseCode == "13") {
            return redirect()->route('home')->with('message','Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch');
        }else if ($request->vnp_ResponseCode == "24") {
            return redirect()->route('checkout.index')->with('message','Giao dịch không thành công do: Khách hàng hủy giao dịch');
        }else if ($request->vnp_ResponseCode == "51") {
            return redirect()->route('checkout.index')->with('message','Tài khoản của quý khách không đủ số dư để thực hiện giao dịch');
        }else if ($request->vnp_ResponseCode == "65") {
            return redirect()->route('checkout.index')->with('message','Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày');
        }else if ($request->vnp_ResponseCode == "75") {
            return redirect()->route('checkout.index')->with('message','Ngân hàng thanh toán đang bảo trì');
        }else if ($request->vnp_ResponseCode == "79") {
            return redirect()->route('checkout.index')->with('message','KH nhập sai mật khẩu thanh toán quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch');
        }else if ($request->vnp_ResponseCode == "99") {
            return redirect()->route('checkout.index')->with('message','Các lỗi khác (lỗi còn lại, không có trong danh sách mã lỗi đã liệt kê)');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $total = 0;
        $total_sub = 0;
        foreach(Cart::content() as $cart){
            $total_sub += ($cart->qty)*($cart->price);
            if(Session::get('coupon')){
                foreach(Session::get('coupon') as $copo){
                    if($copo['coupon_condition'] == 2){
                        $sub = $total_sub*($copo['coupon_number']/100);
                        $total = $total_sub + ($total_sub*0.02) - $sub;
                    }else{
                        $total = $total_sub + ($total_sub*0.02) - $copo['coupon_number'];
                    }
                }
            }else{
                $total = $total_sub + ($total_sub*0.02);
            }
        }
        $output = '';
        $validator = Validator::make($request->all(),[
            'checkout_name'=>'required',
            'checkout_address'=>'required',
            'checkout_wards'=>'required',
            'checkout_district'=>'required',
            'checkout_city'=>'required',
            'checkout_phone'=>'required',
            'checkout_payment'=>'required',
        ]);
        if ($validator->fails()) {
            $output .='
                <dl>
                    <dt class="complete"> Billing Address <span class="separator">|</span> <a
                            href="#">Change</a> </dt>
                    <dd class="complete">
                        <address>
                            '.Auth::user()->name.'<br>
                            ABC Technology Labs.<br>
                            23 North Main Stree<br>
                            Windsor<br>
                            Holtsville, New York, 00501<br>
                            Phone: 08736542xxx <br>
                            ID: '.$request->checkout_code.'
                        </address>
                    </dd>
                    <dt class="complete"> Shipping Address <span class="separator">|</span> <a
                            href="#">Change</a> </dt>
                    <dd class="complete">
                        <address>
                            '.Auth::user()->name.'<br>
                            ABC Technology Labs.<br>
                            23 North Main Stree<br>
                            Windsor<br>
                            Holtsville, New York, 00501<br>
                            Phone: 08736542xxx <br>
                            ID: '.$request->checkout_code.'
                        </address>
                    </dd>
                    <dt class="complete"> Shipping Method <span class="separator">|</span> <a
                            href="#">Change</a> </dt>
                    <dd class="complete"> Flat Rate - Fixed <br>
                        <span class="price">'. number_format($total) .' vnđ</span>
                    </dd>
                    <dt> Payment Method </dt>
                    <dd class="complete"></dd>
                </dl>
            ';
        }else{
            $output .='
                <dl>
                    <dt class="complete"> Billing Address <span class="separator">|</span> <a
                            href="#">Change</a> </dt>
                    <dd class="complete">
                        <address>
                            '.Auth::user()->name.'<br>
                            '.$request->checkout_address.',<br>
                            '.Wards::find($request->checkout_wards)->name_wards.',<br>
                            '.District::find($request->checkout_district)->name_district.',<br>
                            '.City::find($request->checkout_city)->name_city.'.<br>
                            Phone: '.$request->checkout_phone.'<br>
                            ID: '.$request->checkout_code.'
                        </address>
                    </dd>
                    <dt class="complete"> Shipping Address <span class="separator">|</span> <a
                            href="#">Change</a> </dt>
                    <dd class="complete">
                        <address>
                            '.$request->checkout_name.'<br>
                            '.$request->checkout_address.',<br>
                            '.Wards::find($request->checkout_wards)->name_wards.',<br>
                            '.District::find($request->checkout_district)->name_district.',<br>
                            '.City::find($request->checkout_city)->name_city.'.<br>
                            Phone: '.$request->checkout_phone.'<br>
                            ID: '.$request->checkout_code.'
                        </address>
                    </dd>
                    <dt class="complete"> Shipping Method <span class="separator">|</span> <a
                            href="#">Change</a> </dt>
                    <dd class="complete"> Flat Rate - Fixed <br>
                        <span class="price">'. number_format($total) .' vnđ</span>
                    </dd>
                    <dt> Payment Method </dt>
                    <dd class="complete">'.$request->checkout_payment.' - '.$request->checkout_type_payment.'</dd>
                </dl>
            ';
        }
        return response()->json([
            'status'=>200,
            'data'=>$output
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
