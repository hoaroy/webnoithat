<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Coupon;
use App\Products;
use App\Gallery;
use App\Order;

class RemoveAllController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($request->action == 'account') {
            $sample = User::whereIn('id',$request->allids)->get();
            if ($sample) {
                foreach ($sample as $value) {
                    if ($value->social_id != '') {
                        $value->delete();
                    }else{
                        unlink(public_path('uploads/profile/').$value->image_user);
                        $value->delete();
                    }
                }

                return response()->json([
                    'status'=>200,
                    'message'=>'Delete Successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Account Not Found',
                ]);
            }
        }
        if ($request->action == 'coupon') {
            $sample = Coupon::whereIn('coupon_id',$request->allids)->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Delete Successfully',
            ]);
            
        }
        if ($request->action == 'product') {
            $sample = Products::whereIn('product_id',$request->allids)->get();
            if ($sample) {
                foreach ($sample as $value) {
                    $gallery = Gallery::where('gallery_product_id',$value->product_id)->get();
                    foreach ($gallery as $row) {
                        $del_img = $row->gallery_image;
                        if ($del_img != 'default.jpg') {
                            unlink(public_path('uploads/gallery/').$del_img);
                        }
                    }
                    if ($value->product_image == 'default.jpg') {
                        $value->delete();
                    }else{
                        unlink(public_path('uploads/product/').$value->product_image);
                        $value->delete();
                    }
                }
                return response()->json([
                    'status'=>200,
                    'message'=>'Delete Successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found',
                ]);
            }
            
        }
        if ($request->action == 'order') {
            $sample = Order::whereIn('order_id',$request->allids)->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Delete Successfully',
            ]);
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
