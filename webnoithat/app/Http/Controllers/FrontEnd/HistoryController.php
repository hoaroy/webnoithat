<?php

namespace App\Http\Controllers\FrontEnd;

use App\Order;
use App\Review;
use App\Products;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
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
            $review_order = Order::where('user_id',Auth::id())
                                ->where('order_status',3)
                                ->orderBy('order_id','desc')
                                ->get();
            if (count($review_order) > 0) {
                foreach ($review_order as $row) {
                    $orderdetail = OrderDetail::where('order_code',$row->order_code)
                                                ->join('product','product.product_id','orderdetail.pro_id')
                                                ->get();
                    foreach ($orderdetail as $row_2) {
                        $output .='
                            <tr class="first odd">
                                <td class="wishlist-cell0 customer-wishlist-item-image">
                                    <a  title="'. $row_2->product_name .'" href="'. route('product-detail.show',$row_2->product_slug) .'"
                                        class="product-image">
                                        <img width="150px" height="150px"  alt="'. $row_2->product_name .'"
                                            src="'. asset("uploads/product/".$row_2->product_image) .'">
                                        <input type="hidden" name="id_hidden" id="id_hidden" value="'. $row_2->product_id .'">
                                    </a>
                                </td>
                                <td class="wishlist-cell1 customer-wishlist-item-info" style="width: 65%;">
                                    <h3 class="product-name">
                                        <a title="'. $row_2->product_name .'" href="'. route('product-detail.show',$row_2->product_slug) .'">'. $row_2->product_name .'</a>
                                    </h3>
                                    <div class="description std">
                                        <div class="inner" style="text-align: justify;">'. substr($row_2->product_desc, 0, 250) .'...</div>
                                    </div>
                                </td>
                                <td data-rwd-label="Price" class="wishlist-cell3 customer-wishlist-item-price">
                                    <div class="description std">
                                        <div class="inner" style="text-align: center;margin-top: 41%;">';
                                            if($row_2->order_review != 0){
                                                $output .='
                                                <a>Write Reviews</a>';
                                            }else{
                                                $output .='
                                                <a href="#" style="color: red;" data-toggle="modal" class="show-review" data-id="'.$row_2->orderdetail_id .'" data-id_order="'.$row->order_id .'">Write Reviews</a>';
                                            }
                                            $output .='
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        ';
                    }
                }
            }else{
                $output .='
                <tr class="first odd">
                    <td colspan="3" style="text-align: center;font-size: 17px; color: #cec5c5;"
                    >Product Not Found</td>
                </tr>';
            }


            return response()->json([
                'data'=>$output
            ]);
        }
        return view('FrontEnd.history');
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
                'text_review'=>'required',
                'star_count'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }else{
                $review = new Review();
                $review->review_rating = $request->star_count;
                $review->review_desc = $request->text_review;
                $review->pro_id  = $request->id_pro;
                $review->user_id  = Auth::id();
                $review->save();

                $order = OrderDetail::find($request->id_order);
                $order->order_review = 1;
                $order->save();


                return response()->json([
                    'status'=>200,
                    'message'=>'Successfully'
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
        $review = OrderDetail::where('orderdetail_id',$id)
                            ->join('product','product.product_id','orderdetail.pro_id')
                            ->first();
        if ($review) {
            $desc = substr($review->product_desc,0,100).'...';
            return response()->json([
                'status'=>200,
                'data'=>$review,
                'desc'=>$desc,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Not Found'
            ]);
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
