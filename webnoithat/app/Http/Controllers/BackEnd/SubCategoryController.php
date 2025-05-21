<?php

namespace App\Http\Controllers\BackEnd;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            if($request->data){

                foreach ($request->data as $key => $value) {
                    $isChildren = (isset($value['children'])) ? $value['children'] : false;
                    $sorting = Category::findOrfail($value['id']);
                    $sorting->category_sorting = $key+1;
                    if($isChildren){
                        foreach($isChildren as $child){
                            $isChild = (isset($child['children'])) ? $child['children'] : false;
                            if($isChild){
                                foreach($isChild as $chil){
                                    $chil = Category::where('category_id',$chil['id'])->first();
                                    $chil->category_sub  = $child['id'];
                                    $chil->category_icon  = $sorting->category_icon;
                                    $chil->save();
                                }
                            }
                            $checkChild = Category::where('category_id',$child['id'])->first();
                            $checkChild->category_sub  = $value['id'];
                            $checkChild->category_icon  = $sorting->category_icon;
                            $checkChild->save();

                        }
                    }else{
                        $sorting->category_sub  = null;
                    }
                    $sorting->save();
                }
                return response()->json([
                    'status'=>200,
                    'message'=>'Update Successfully'
                ]);
            }else{
                $output = '';
                $categories = Category::where('category_status',1)
                                        ->whereNull('category_sub')
                                        ->with('childrenCategories')
                                        ->orderBy('category_sorting','asc')
                                        ->get();

                $output .='
                    <ol class="dd-list">';
                    foreach ($categories as $cate ){
                        $childrencate = Category::where('category_sub',$cate->category_id)
                                                ->where('category_status',1)
                                                ->orderBy('category_sorting','asc')
                                                ->get();
                        $output .='
                        <li class="dd-item" data-id="'. $cate->category_id .'">';
                        if (count($childrencate) > 0){
                            $output .='
                            <button data-action="collapse" type="button">Collapse</button>
                            <button data-action="expand" type="button" style="display: none;">Expand</button>';
                        }
                        $output .='
                            <div class="dd-handle">';
                            if(count($childrencate) > 0 && $cate->category_sorting % 2 == 0){
                                $output .='<span class="label label-info"><i class="fa fa-cog"></i></span> ';
                            }elseif(count($childrencate) > 0){
                                $output .='<span class="label label-warning"><i class="fa fa-cog"></i></span> ';
                            }else{
                                $output .='<span class="label label-danger"><i class="fa fa-cog"></i></span> ';
                            }
                            $output .=' '. $cate->category_name .'
                            </div>';
                            if (count($childrencate) > 0){
                                $output .='
                                <ol class="dd-list">';
                                    foreach ($childrencate  as $subcate ){
                                        $childcate = Category::where('category_sub',$subcate->category_id)
                                                                ->where('category_status',1)
                                                                ->orderBy('category_sorting','asc')
                                                                ->get();
                                        $output .='
                                        <li class="dd-item" data-id="'. $subcate->category_id .'">
                                            <div class="dd-handle">
                                                <span class="float-right"> '.\Carbon\Carbon::parse($subcate->updated_at)->format('H:i A').' </span>';
                                                if(count($childrencate) > 0 && $cate->category_sorting % 2 == 0){
                                                    $output .='<span class="label label-info"><i class="fa fa-cog"></i></span> ';
                                                }elseif(count($childrencate) > 0){
                                                    $output .='<span class="label label-warning"><i class="fa fa-cog"></i></span> ';
                                                }else{
                                                    $output .='<span class="label label-danger"><i class="fa fa-cog"></i></span> ';
                                                }
                                                $output .=' '. $subcate->category_name .'
                                            </div>';
                                            foreach ($childcate  as $subdubcate ){
                                                if (count($childcate) > 0){
                                                $output .='
                                                    <ol class="dd-list">
                                                        <li class="dd-item" data-id="'. $subdubcate->category_id .'">
                                                            <div class="dd-handle">
                                                                <span class="float-right"> '.\Carbon\Carbon::parse($subdubcate->updated_at)->format('H:i A').' </span>';
                                                                if(count($childrencate) > 0 && $cate->category_sorting % 2 == 0){
                                                                    $output .='<span class="label label-info"><i class="fa fa-cog"></i></span> ';
                                                                }elseif(count($childrencate) > 0){
                                                                    $output .='<span class="label label-warning"><i class="fa fa-cog"></i></span> ';
                                                                }else{
                                                                    $output .='<span class="label label-danger"><i class="fa fa-cog"></i></span> ';
                                                                }
                                                                $output .=' '. $subdubcate->category_name .'
                                                            </div>
                                                        </li>
                                                    </ol>';
                                                }
                                            }
                                            $output .='
                                        </li>';
                                    }
                                    $output .='
                                </ol>';
                            }
                            $output .='
                        </li>';
                    }
                    $output .='
                </ol>';

                return response()->json([
                    'data'=>$output
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
