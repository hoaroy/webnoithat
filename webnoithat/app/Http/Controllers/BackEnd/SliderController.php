<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Slider;
use Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Slider::orderBy('slider_sorting','ASC')->get())
            ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="edit" data-slider_url_update="'.route('slider.update',$data->slider_id).'" data-slider_id="'.$data->slider_id.'" class="btn btn-outline btn-primary"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->slider_id.'" data-slider_id="'.$data->slider_id.'" class="btn  btn-outline btn-danger delete"><i class="fa fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])->make(true);
        }
        return view('BackEnd.Slider.list');
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'name_slider'=>'required',
                'desc'=>'required',
                'status'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }
            else{
                $slider = new Slider();
                $slider->slider_name = $request->input('name_slider');
                $slider->slider_desc = $request->input('desc');
                $slider->slider_url = $request->input('link');
                $slider->slider_status = $request->input('status');
                $slider->slider_content = $request->input('content');
                $slider->slider_change = $request->input('slider_change');
                $slider->slider_sorting = count(Slider::all())+1;

                if ($request->file('select_image')) {

                    $image = $request->file('select_image');
                    $name = time().'_'.$image->getClientOriginalName();

                    $image->move(public_path('uploads/slider'),$name);
                    $slider->slider_image = $name;
                }else{
                    $slider->slider_image = 'default.jpg';
                }
                $slider->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Update Slider Successfully',
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
    public function show($id){
        if (request()->ajax()) {
            $slider = Slider::findOrFail($id);
            if ($slider) {
                return response()->json([
                    'status'=>200,
                    'slider'=>$slider,
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Slider Not Found',
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
    public function edit($id)
    {
        if (request()->ajax()) {
            $slider = Slider::findOrFail($id);
            if ($slider) {
                return response()->json([
                    'status'=>200,
                    'slider'=>$slider,
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Slider Not Found',
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

    public function update($id, Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'name_slider'=>'required',
                'desc'=>'required',
                'status'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }
            else{
                $slider = Slider::findOrFail($id);
                if ($slider) {
                    $slider->slider_name = $request->input('name_slider');
                    $slider->slider_desc = $request->input('desc');
                    $slider->slider_url = $request->input('link');
                    $slider->slider_status = $request->input('status');
                    $slider->slider_change = $request->input('slider_change');
                    $slider->slider_content = $request->input('content');

                    if ($request->file('select_image')) {
                        if ($slider->slider_image == 'default.jpg') {

                            $image = $request->file('select_image');
                            $name = time().'_'.$image->getClientOriginalName();

                            $image->move(public_path('uploads/slider'),$name);
                            $slider->slider_image = $name;
                        }else{

                            unlink(public_path('uploads/slider/').$slider->slider_image);
                            $image = $request->file('select_image');
                            $name = time().'_'.$image->getClientOriginalName();

                            $image->move(public_path('uploads/slider'),$name);
                            $slider->slider_image = $name;
                        }
                    }
                    $slider->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Update Slider Successfully',
                    ]);
                }
                else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Slider Not Found',
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
    public function destroy($id, Request $request)
    {
        $slider = Slider::findOrFail($id);
        if ($slider) {
            if ($slider->slider_image == 'default.jpg') {
                    $slider->delete();
            }else{
                unlink(public_path('uploads/slider/').$slider->slider_image);
                $slider->delete();
            }
            return response()->json([
                'status'=>200,
                'message'=>'Delete Successfully',
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Slider Not Found',
            ]);
        }
    }
}
