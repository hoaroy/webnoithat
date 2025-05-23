<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Slider;
use App\Coupon;
use App\Products;
use App\Category;

class StatusController extends Controller
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
        if ($request->ajax()) {
            if ($request->action == 'slider') {
                $sample = Slider::where('slider_id',$request->id)->first();
                if ($request->statusss == 1) {
                    $sample->slider_status = 1;
                }
                else{
                    $sample->slider_status = 2;
                }
            }
            if ($request->action == 'coupon') {
                $sample = Coupon::where('coupon_id',$request->id)->first();
                if ($request->statusss == 1) {
                    $sample->coupon_status = 1;
                }
                else{
                    $sample->coupon_status = 2;
                }
            }
            if ($request->action == 'product') {
                $sample = Products::where('product_id',$request->id)->first();
                if ($request->statusss == 1) {
                    $sample->product_status = 1;
                }
                else{
                    $sample->product_status = 2;
                }
            }
            if ($request->action == 'category') {
                $sample = Category::where('category_id',$request->id)->first();
                if ($request->statusss == 1) {
                    $sample->category_status = 1;
                }
                else{
                    $sample->category_status = 2;
                }
            }
            if ($request->action == 'account') {
                $sample = User::where('id',$request->id)->first();
                if ($sample->level == 1) {
                    $sample->level = 2;
                }
                else{
                    $sample->level = 1;
                }
            }


            $sample->save();

            return response()->json([
                'message' => 'Update Successfully'
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
