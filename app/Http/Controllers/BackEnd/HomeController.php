<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
use App\User;
use Session;
use Auth;
use Carbon\Carbon;
use App\Products;
use App\Statistical;
use App\Order;
use App\OrderDetail;
use App\Slider;
use App\Category;
use App\Wishlist;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $now_m = Carbon::now('Asia/Ho_Chi_Minh')->toFormattedDateString();
        $now_day = Carbon::now('Asia/Ho_Chi_Minh')->toDayDateTimeString();

        $dauthang_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();

        $doanhthu = Statistical::whereBetween('order_date', [$dauthang_nay,$now])->orderBy('order_date','ASC')->get();
        $sum_view = Products::all()->sum('product_view');

        $sp_count_dd = Products::where('product_status','!=',2)->get()->count();

        $tn_profit = 0;
        $tn_total = 0;
        $tn_sales = 0;
        foreach ($doanhthu as $key => $value) {
            $tn_profit += $value->profit;
            $tn_total += $value->total_order;
            $tn_sales += $value->sales;
        }

        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $thangtruoc = Statistical::whereBetween('order_date', [$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();
        $ttr_profit = 0;
        $ttr_total = 0;
        $ttr_sales = 0;
        foreach ($thangtruoc as $key1 => $value1) {
            $ttr_profit += $value1->profit;
            $ttr_total += $value1->total_order;
            $ttr_sales += $value1->sales;
        }

        $now_date = Carbon::now('Asia/Ho_Chi_Minh');
        $now_date_yesterday = Carbon::now('Asia/Ho_Chi_Minh')->yesterday();
        $now_sub = Carbon::now('Asia/Ho_Chi_Minh')->subHour(25);
        $user_login = User::where('id',Auth::id())->first();
        $users_hour = User::whereBetween('updated_at',[$now_sub,$now_date])->get()->take(6);

        if ($user_login->updated_at != $now_date) {
            $user_login->updated_at = $now_date;
            $user_login->save();
        }

        $user_count = User::all()->count();

        $dh_status = Order::where('order_status',2)->orwhere('order_status',3)->get()->count();
        $dh_status_1 = Order::all()->count();

        $dh_cd_count_today = OrderDetail::where('updated_at',$now_date)->get();
        $sum_dh_cd_count_today = 0;
        foreach ($dh_cd_count_today as $row1) {
            $sum_dh_cd_count_today += $row1->product_sales_quantity;
        }
        $dh_cd_count_yesterday = OrderDetail::where('updated_at',$now_date_yesterday)->get();
        $sum_dh_cd_count_yesterday = 0;
        foreach ($dh_cd_count_yesterday as $row2) {
            $sum_dh_cd_count_yesterday+= $row2->product_sales_quantity;
        }
        $sp_count = Products::all()->count();
        $dh_count = Order::all()->count();
        $kh_count = User::all()->count();
        $dm_count = Category::all()->count();
        $th_count = 0;
        $sl_count = Slider::all()->count();
        $wishlist_count = Wishlist::all()->count();


        return view('BackEnd.Dashboard.dashboard',compact('doanhthu','now_m','sp_count_dd','now_day','tn_profit','tn_total','tn_sales','ttr_profit','ttr_total','ttr_sales','users_hour','sum_view','user_count','dh_status','sum_dh_cd_count_yesterday','sum_dh_cd_count_today', 'sp_count','dh_count','kh_count','dm_count','th_count','sl_count','dh_status_1','wishlist_count' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->dashboard_value) {
            $data = $request->all();
            // echo $today = Carbon::now('Asia/Ho_Chi_Minh');
            $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
            $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
            $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

            $sub7ngay = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
            $sub365ngay = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

            $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

            if ($data['dashboard_value']=='7ngay') {
                $get = Statistical::whereBetween('order_date', [$sub7ngay,$now])->orderBy('order_date','ASC')->get();

            }elseif ($data['dashboard_value']=='thangtruoc') {
                $get = Statistical::whereBetween('order_date', [$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();

            }elseif ($data['dashboard_value']=='thangnay') {
                $get = Statistical::whereBetween('order_date', [$dauthangnay,$now])->orderBy('order_date','ASC')->get();

            }else{
                $get = Statistical::whereBetween('order_date', [$sub365ngay,$now])->orderBy('order_date','ASC')->get();

            }

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'profit' => $val->profit,
                    'quantity' => $val->quantity
                );
            }
            echo $data = json_encode($chart_data);
        }else{
            $sub40ngay = Carbon::now('Asia/Ho_Chi_Minh')->subdays(40)->toDateString();
            $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $get = Statistical::whereBetween('order_date', [$sub40ngay,$now])->orderBy('order_date','ASC')->get();

            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->order_date,
                    'order' => $val->total_order,
                    'sales' => $val->sales,
                    'profit' => $val->profit,
                    'quantity' => $val->quantity
                );
            }

            echo $data = json_encode($chart_data);
        }
    }

    public function store_table(){
        $now_date = Carbon::now('Asia/Ho_Chi_Minh');
        $now_sub = Carbon::now('Asia/Ho_Chi_Minh')->subHour(25);
        $users_hour = User::whereBetween('updated_at',[$now_sub,$now_date])->get()->take(6);
        $output = '';
        $i = 0;
        foreach ($users_hour as $key => $row) {
             $output .='
                <tr>
                    <td>';
                        if ($row->isOnline()) {
                            $i++;
                            $total = $i;
                            Session::put('sum_online',$total);
                            $output .='<span class="label label-primary">Online</span> ';
                        }else{
                            $output .='<span class="label label-danger">Offline</span>';
                        }
                    $output .='
                    </td>
                    <td><i class="fa fa-clock-o"></i> '.date_format($row->updated_at,'H:i A').'</td>
                    <td>'.$row->name.'</td>
                </tr>
             ';
        }
        // echo $output;
        return response()->json([
            'data' =>$output,
            'total' =>$total
        ]);
    }

    public function store_total(){

        $user_count = User::all()->count();
        $output = '';

        $output .='
            <div class="stat-percent font-bold text-danger">
                '.round((Session::get('sum_online')/$user_count)*100,0).' ';

                if (round((Session::get('sum_online')/$user_count)*100,0) < 50) {
                    $output .='<i class="fa fa-level-down"></i>';
                }else{
                    $output .='<i class="fa fa-level-up"></i>';
                }
            $output .='</div>
        ';
        echo $output;
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
