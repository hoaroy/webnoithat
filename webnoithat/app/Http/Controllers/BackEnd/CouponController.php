<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Carbon\Carbon;
use Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $coupon = Coupon::orderBy('coupon_id','DESC')->get();

            return datatables()->of(Coupon::orderBy('coupon_id','DESC')->get())
                ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="edit" data-coupon_id="'.$data->coupon_id.'" class="btn btn-outline btn-primary"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->coupon_id.'" data-coupon_id="'.$data->coupon_id.'" class="btn  btn-outline btn-danger delete"><i class="fa fa-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $check_coupon_date = Coupon::all();

        return view('BackEnd.Coupon.list');
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'coupon_qty'=>'required',
                'coupon_sale_number'=>'required',
                'coupon_code'=>'required',
                'coupon_condition'=>'required',
                'coupon_status'=>'required',
                'coupon_date_start'=>'required',
                'coupon_date_end'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }else if ($request->coupon_date_start > $request->coupon_date_end) {
                return response()->json([
                    'message_erro'=>'The Start Date Is Too Big',
                ]);
            }
            else{
                $coupon = new Coupon();
                if ($coupon) {
                    $coupon->coupon_qty = $request->coupon_qty;
                    $coupon->coupon_sale_number = $request->coupon_sale_number;
                    $coupon->coupon_code = $request->coupon_code;
                    $coupon->coupon_condition = $request->coupon_condition;
                    $coupon->coupon_status = $request->coupon_status;
                    $coupon->coupon_date_start = $request->coupon_date_start;
                    $coupon->coupon_date_end = $request->coupon_date_end;

                    $date_end = date_create($request->coupon_date_end);
                    $month_now = Carbon::now('Asia/Ho_Chi_Minh')->month;
                    $day_now = Carbon::now('Asia/Ho_Chi_Minh')->day;
                    $year_now = Carbon::now('Asia/Ho_Chi_Minh')->year;

                    $coupon->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Update Coupon Successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Coupon Not Found',
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        return response()->json(['data' => $request->value]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $coupon = Coupon::findOrFail($id);
            if ($coupon) {
                $day = date_create($coupon->coupon_date_start);
                $day_end = date_create($coupon->coupon_date_end);

                $format_from = date_format($day,'d');
                $format_to = date_format($day_end,'d');
                return response()->json([
                    'status'=>200,
                    'coupon'=>$coupon,
                    'from'=>$format_from,
                    'to'=>$format_to,
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Coupon Not Found',
                ]);
            }
        }
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'coupon_qty'=>'required',
                'coupon_sale_number'=>'required',
                'coupon_code'=>'required',
                'coupon_condition'=>'required',
                'coupon_status'=>'required',
                'coupon_date_start'=>'required',
                'coupon_date_end'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }else if ($request->coupon_date_start > $request->coupon_date_end) {
                return response()->json([
                    'message_erro'=>'The Start Date Is Too Big',
                ]);
            }
            else{
                $coupon = Coupon::findOrFail($id);
                if ($coupon) {
                    $coupon->coupon_qty = $request->coupon_qty;
                    $coupon->coupon_sale_number = $request->coupon_sale_number;
                    $coupon->coupon_code = $request->coupon_code;
                    $coupon->coupon_condition = $request->coupon_condition;
                    $coupon->coupon_status = $request->coupon_status;
                    $coupon->coupon_date_start = $request->coupon_date_start;
                    $coupon->coupon_date_end = $request->coupon_date_end;

                    $date_end = date_create($request->coupon_date_end);
                    $month_now = Carbon::now('Asia/Ho_Chi_Minh')->month;
                    $day_now = Carbon::now('Asia/Ho_Chi_Minh')->day;
                    $year_now = Carbon::now('Asia/Ho_Chi_Minh')->year;

                    $coupon->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Update Coupon Successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Coupon Not Found',
                    ]);
                }
            }
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
        $coupon = Coupon::findOrFail($id);
        if ($coupon) {
            $coupon->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Delete Successfully',
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Coupon Not Found',
            ]);
        }
    }
}
