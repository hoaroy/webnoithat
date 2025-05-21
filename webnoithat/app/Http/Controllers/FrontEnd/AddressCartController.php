<?php

namespace App\Http\Controllers\FrontEnd;

use Cart;
use App\City;
use App\Order;
use App\Wards;
use App\Coupon;
use App\Customer;
use App\District;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddressCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check() && Cart::content()->count() > 0){
            $city = City::all();
            return view('FrontEnd.addressCart', compact('city'));
        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->all();

        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = District::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option value="">-- Choose --</option>';
                foreach($select_province as $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_district.'</option>';
                }

            }else{

                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option value="">-- Choose --</option>';
                foreach($select_wards as $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_wards.'</option>';
                }
            }
            echo $output;
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
        $total = 0;
        $checkout_code = mt_rand();
        if($request->checkout_payment == 'ATM'){
            if($request->checkout_type_payment == 'Vnpay'){

                $vnp_OrderInfo = "TT Fashion Shop";
                $vnp_OrderType = "billpayment";
                foreach(Cart::content() as $key => $cart){
                    $total += ($cart->qty)*($cart->price);
                    if (Session::get('coupon')) {
                        foreach(Session::get('coupon') as $key => $coun){
                            if($coun['coupon_condition']==2){
                                $total_pre = $total+($total*0.02)-($total*($coun['coupon_number']/100));
                                $totalPrice = $total_pre;
                            }else{
                                $total_coupon = ($total+($total*0.02))-$copo['coupon_number'];
                                $totalPrice = $total_coupon;
                            }
                        }
                        $vnp_Amount = $totalPrice * 100;
                    }else{
                        $vnp_Amount = $total * 100;
                    }
                }
                $vnp_Locale = config('app.locale');
                $vnp_BankCode = $request->checkout_bank;
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

                $name_order = $request->checkout_name;
                $email_order = Auth::user()->email;
                $address_order = $request->checkout_address.','.Wards::find($request->checkout_wards)->name_wards.','.District::find($request->checkout_district)->name_district.','.City::find($request->checkout_city)->name_city;
                $phone_number_order = $request->checkout_phone;
                $note_order = $request->checkout_note;
                $code_order = $checkout_code;
                $BankCode_order = $vnp_BankCode;


                $count_order[] = array(
                    'name_order' => $name_order,
                    'email_order' => $email_order,
                    'address_order' => $address_order,
                    'phone_number_order' => $phone_number_order,
                    'note_order' => $note_order,
                    'code_order' => $code_order,
                    'BankCode_order' => $BankCode_order,
                );
                Session::put('order_customer',$count_order);

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => env('VNP_TMN_CODE'),
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => route('cart-address-vnpay.index'),
                    "vnp_TxnRef" => $checkout_code,
                    "vnp_ExpireDate"=>time().rand(0,100),
                );

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = env('VNP_URL') . "?" . $query;
                if (env('VNP_HASH_SECRET')) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, env('VNP_HASH_SECRET'));
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                return redirect()->to($vnp_Url);
            }else{
                $order = new Order;
                $order->user_id  = Auth::id();
                $order->order_status = 1;
                $order->order_review = 0;
                $order->order_code = $checkout_code;
                $order->save();

                $customer = new Customer();
                $customer->customer_name = $request->checkout_name;
                $customer->customer_address = $request->checkout_address.','.Wards::find($request->checkout_wards)->name_wards.','.District::find($request->checkout_district)->name_district.','.City::find($request->checkout_city)->name_city;
                $customer->customer_phone = $request->checkout_phone;
                $customer->customer_note = $request->checkout_note;
                $customer->customer_pay = 'ATM-PAYPAL';
                $customer->customer_code = $checkout_code;
                $customer->save();

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

                return response()->json([
                    'status'=>200,
                    'message'=> 'Order Successfully'
                ]);
            }
        }else{
            $order = new Order;
            $order->user_id  = Auth::id();
            $order->order_status = 1;
            $order->order_review = 0;
            $order->order_code = $checkout_code;
            $order->save();

            $customer = new Customer();
            $customer->customer_name = $request->checkout_name;
            $customer->customer_address = $request->checkout_address.','.Wards::find($request->checkout_wards)->name_wards.','.District::find($request->checkout_district)->name_district.','.City::find($request->checkout_city)->name_city;
            $customer->customer_phone = $request->checkout_phone;
            $customer->customer_note = $request->checkout_note;
            $customer->customer_pay = $request->checkout_payment;
            $customer->customer_code = $checkout_code;
            $customer->save();

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

            return redirect()->route('home')->with('message','Order Successfully');
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
