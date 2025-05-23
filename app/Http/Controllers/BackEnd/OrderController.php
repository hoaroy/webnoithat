<?php

namespace App\Http\Controllers\BackEnd;

use App\User;
use App\Order;
use Validator;
use App\Coupon;
use App\Customer;
use App\Products;
use Carbon\Carbon;
use App\OrderDetail;
use App\Statistical;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $order = Order::whereBetween('created_at',[request()->start_date,request()->end_date])
                                ->orwhere('created_at','like','%'.request()->end_date.'%')
                                ->orwhere('created_at','like','%'.request()->start_date.'%')
                                ->get();
            }else{
                $order = Order::orderBy('order_id','DESC')->get();
            }
            return datatables()->of($order)
                ->addColumn('action', function($data){
                        $button = '<button type="button" data-order="'.$data->order_code .'" data-id="'.$data->order_id .'" class="btn btn-outline btn-success quickview"><i class="fa fa-eye"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        if ($data->order_status == 3) {
                            $button .= '<button type="button"  data-order="'.$data->order_code .'" data-id="'.$data->order_id .'" disabled class="btn btn-outline btn-primary detailorder"><i class="fa fa-info-circle"></i></button>';
                        }else{
                            $button .= '<button type="button"  data-order="'.$data->order_code .'" data-id="'.$data->order_id .'"  class="btn btn-outline btn-primary detailorder"><i class="fa fa-info-circle"></i></button>';
                        }
                        $button .= '&nbsp;&nbsp;';
                        if ($data->order_status == 1) {
                            $button .= '<button type="button" data-order="'.$data->order_code .'" data-id="'.$data->order_id .'" class="btn btn-outline btn-danger delete"><i class="fa fa-trash"></i></button>';
                        }
                        return $button;
                })
                ->addColumn('name_order', function($data){
                    $customer = Customer::where('customer_code', $data->order_code)->first();
                    return $customer->customer_name;
                })
                ->addColumn('order_pay', function($data){
                    $customer = Customer::where('customer_code', $data->order_code)->first();
                    return $customer->customer_pay;
                })
                ->rawColumns(['action','name_order','order_pay'])
                ->make(true);
        }

        return view('BackEnd.Order.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->ajax()) {
            if ($request->order_text) {
                $order_de = OrderDetail::where('orderdetail_id',$request->orderddd)->first();

                $validator = Validator::make($request->all(),[
                    'order_text'=>'integer',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status'=>400,
                        'errors'=>$validator->messages(),
                        'data'=>$order_de,
                    ]);
                }else{
                    $product = Products::where('product_id',$order_de->pro_id)->get();
                    foreach($product as $proqty){
                        if ($request->order_text > $proqty->product_quantity) {
                            return response()->json([
                                'data'=>$order_de,
                                'message'=>'Error Quantity Big'
                            ]);
                        }else{
                            $order_de->order_de_qty = $request->order_text;
                            $order_de->save();

                            $showSubtotal = 0;
                            $showTotal = 0;
                            $price_sum = 0;
                            $order_detail = OrderDetail::where('order_code',$request->order_code)->get();
                            foreach ($order_detail as $row) {
                                $price = $row->order_de_price*$row->order_de_qty;
                                $price_sum += $price;
                                
                                if ($row->order_de_coupon != 'no') {
                                    $coupon = Coupon::where('coupon_code',$row->order_de_coupon)->first();
                                    if($coupon->coupon_condition == 1){
                                       $showTotal = number_format($price_sum+$coupon->coupon_sale_number);
                                    }else{
                                        $showTotal = number_format($price_sum - ($price_sum*$coupon->coupon_sale_number / 100));
                                    }
                                }else{
                                    $showSubtotal = number_format($price_sum);
                                    $showTotal = number_format($price_sum);
                                }
                            }


                            return response()->json([
                                'status'=>200,
                                'Subtotal'=>$showSubtotal,
                                'Total'=>$showTotal,
                                'message'=>'Update Successfully'
                            ]);
                        }
                    }
                }

            }else{


                $order = Order::where('order_code',$request->order_code)->first();

                $price_sum = 0;
                $output = '';
                $output_2 = '';
                $output_3 = '';
                $order_detail = OrderDetail::where('order_code',$request->order_code)->get();
                foreach ($order_detail as $row) {
                    $price = $row->order_de_price*$row->order_de_qty;
                    $price_sum += $price;
                    $coupon = Coupon::where('coupon_code',$row->order_de_coupon)->first();
                    $product = Products::where('product_id',$row->pro_id)->get();
                    foreach($product as $pro){
                        $output .='
                        <tr>
                            <td>'.$pro->product_name.'<input type="hidden" name="order_product_id" class="order_product_id" value="'.$pro->product_id.'"></td>';
                            if ($order->order_status != 1) {
                                $output .='
                                <td id="qty_change" data-id_order="'.$row->orderdetail_id .'">'.$row->order_de_qty.' <input type="hidden" name="product_quantity_order" value="'.$row->order_de_qty.'"></td>';
                            }else{
                                $output .='
                                <td '.$request->action.' id="qty_change" data-id_order="'.$row->orderdetail_id.'">'.$row->order_de_qty.' <input type="hidden" name="product_quantity_order" value="'.$row->order_de_qty.'"></td>';
                            }
                            $output .='
                            <td>'.$pro->product_quantity.'</td>
                            <td>'.$row->order_de_coupon.'</td>
                            <td>'.number_format($row->order_de_price).'</td>
                        </tr>
                        ';
                    }
                }

                $output_2 .='
                <tr>
                    <td style="text-align: center;" colspan="3">Subtotal</td>';
                    if ($coupon) {
                        if ($coupon->coupon_condition == 1) {
                            $output_2 .='<td id="subtotal_coupon">'.number_format($coupon->coupon_sale_number).'</td>';
                        }else{
                            $output_2 .='<td id="subtotal_coupon">'.$coupon->coupon_sale_number.'%</td>';
                        }

                    }else{
                        $output_2 .='<td id="subtotal_coupon">0</td>';
                    }

                    $output_2 .='<td class="showSubtotal" style="text-align: center;" colspan="2">'.number_format($price_sum).'</td>';
                    $output_2 .='
                </tr>
                <tr>
                    <td style="text-align: center;font-weight: bold;" colspan="3">Total</td>';
                    if ($order->order_pay == 'ATM') {
                        $output_2 .='<td style="text-align: center;font-weight: bold;" colspan="3">0 vnđ</td>';
                    }else{
                        if ($coupon) {
                            if ($coupon->coupon_condition == 1) {
                                $output_2 .='<td style="text-align: center;" colspan="3">'.number_format($price_sum+$coupon->coupon_sale_number).' vnđ</td>';
                            }else{
                                $output_2 .='
                                <td style="text-align: center;" colspan="3">'.number_format($price_sum - ($price_sum*$coupon->coupon_sale_number / 100)).' vnđ</td>';
                            }
                        }else{
                            $output_2 .='<td class="showTotal" style="text-align: center;font-weight: bold;" colspan="3">'.number_format($price_sum).' vnđ</td>';
                        }
                    }

                    $output_2 .='
                </tr>
                ';
                $customer = Customer::where('customer_code',$request->order_code)->first();
                $or_de = Order::where('order_code',$request->order_code)->first();
                $user_email = User::where('id',$or_de->user_id)->first();
                $output_3 .='
                <tr>
                    <td>'.$customer->customer_name.'</td>
                    <td>'.$user_email->email.'</td>
                    <td>'.$customer->customer_phone.'</td>
                    <td style="color: #1ab394;">'.$customer->customer_pay.'</td>
                    <td>'.$customer->customer_address.'</td>';
                    if ($customer->customer_note != null) {
                        $output_3 .='<td>'.$customer->customer_note.'</td>';
                    }
                    $output_3 .='
                </tr>
                ';
                return response()->json([
                    'data'=> $output,
                    'data_2'=> $output_2,
                    'data_3'=> $output_3,
                    'data_4'=> $order->order_status,
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
        if (request()->ajax()) {
            $order = Order::findOrFail($id);
            if ($order) {
                return response()->json([
                    'status'=>200,
                    'data'=>$order,
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Order Not Found',
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
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
        $order = Order::findOrfail($id);
        if ($order) {
            $order->order_status = $request->value;
            $order->save();

            //order date
            $data = $request->all();
            $order_date  = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $statistic = Statistical::where('order_date',$order_date)->get();
            if($statistic){
                $statistic_count = $statistic->count();
            }else{
                $statistic_count = 0;
            }

            //Add
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;

            if ($order->order_status == 2) {

                foreach ($data['order_product_id'] as $key => $product_id) {
                    $product = Products::find($product_id);
                    $product_qty = $product->product_quantity;
                    $product_sold = $product->product_sold;

                    $product_price = $product->product_price;
                    $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

                    foreach ($data['quantity'] as $key2 => $qty) {
                        if ($key==$key2) {
                            $pro_remain = $product_qty - $qty;
                            $product->product_quantity = $pro_remain;
                            $product->product_sold = $product_sold + $qty;
                            $product->save();
                        }
                    }
                }

            }else if($order->order_status == 3){
                foreach ($data['order_product_id'] as $key => $product_id) {
                    $product = Products::find($product_id);

                    $product_price = $product->product_price;
                    $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

                    foreach ($data['quantity'] as $key2 => $qty) {
                        if ($key==$key2) {
                            //update doanh thu
                            $quantity       += $qty;
                            $total_order    += 1;
                            $sales          += $product_price*$qty;
                            $profit         =  $sales - 1000;
                        }
                    }
                }
                //update doanh so db
                if($statistic_count > 0){
                    $statistic_update = Statistical::where('order_date',$order_date)->first();
                    $statistic_update->sales = $statistic_update->sales + $sales;
                    $statistic_update->profit =  $statistic_update->profit + $profit;
                    $statistic_update->quantity =  $statistic_update->quantity + $quantity;
                    $statistic_update->total_order = $statistic_update->total_order + $total_order;
                    $statistic_update->save();

                }else{

                    $statistic_new = new Statistical();
                    $statistic_new->order_date = $order_date;
                    $statistic_new->sales = $sales;
                    $statistic_new->profit =  $profit;
                    $statistic_new->quantity =  $quantity;
                    $statistic_new->total_order = $total_order;
                    $statistic_new->save();
                }
            }
            else if ($order->order_status == 1 && $order->order_status != $request->value) {
                foreach ($data['order_product_id'] as $key => $product_id) {
                    $product = Products::find($product_id);
                    $product_qty = $product->product_quantity;
                    $product_sold = $product->product_sold;

                    if ($product->product_sold !=0) {
                        foreach ($data['quantity'] as $key2 => $qty) {
                            if ($key==$key2) {
                                $pro_remain = $product_qty + $qty;
                                $product->product_quantity = $pro_remain;
                                $product->product_sold = $product_sold - $qty;
                                $product->save();
                            }
                        }
                    }
                }
            }

            return response()->json([
                'status'=>200,
                'message'=>'Update Successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Order Not Found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            $order = Order::findOrFail($id);
            if ($order) {
                Customer::where('customer_id',$order->customer_order_id)->delete();
                $order->delete();
                return response()->json([
                    'status'=>200,
                    'message'=>'Delete Successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Order Not Found',
                ]);
            }
        }
    }
}
