<?php

namespace App\Http\Controllers\BackEnd;

use File;
use Session;
use Storage;
use App\Gallery;
use App\Category;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Products::orderBy('product_id','desc')->get())
                ->addColumn('action', function($data){
                    $button = '<button type="button" data-id_product="'.$data->product_id.'"  class="btn btn-xs btn-outline btn-primary editpro"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" class="btn btn-xs btn-outline btn-danger delete" data-id_product="'.$data->product_id.'"><i class="fa fa-trash"></i>
                            </button>';
                    return $button;
                })
                ->addColumn('gallery_td', function($data){
                    $gallery = Gallery::where('pro_id',$data->product_id)->get()->count();
                    if ($gallery > 5) {
                        $gall = '<a href="'.route('product-gallery.show',[$data->product_id]).'" class="label label-primary">Add Gallery ('.$gallery.')</a>';
                    }else if ($gallery >= 1 && $gallery <= 3) {
                        $gall = '<a href="'.route('product-gallery.show',[$data->product_id]).'" class="label label-danger">Add Gallery ('.$gallery.')</a>';
                    }else{
                        $gall = '<a href="'.route('product-gallery.show',[$data->product_id]).'" class="label label-warning">Add Gallery ('.$gallery.')</a>';
                    }
                    return $gall;
                })
                ->addColumn('price_td', function($data){
                    if ($data->product_price_sale > 0) {
                        $price = '<span class="text-info">'.number_format($data->product_price_sale).'</span>';
                    }else{
                        $price = '<span>'.number_format($data->product_price).'</span>';
                    }
                    return $price;
                })
                ->addColumn('date_pro', function($data){
                    $date = ' '.Carbon::parse($data->updated_at)->format('d/m/Y').' ';
                    return $date;
                })
                ->rawColumns(['action','gallery_td','date_pro','price_td'])
                ->make(true);
        }
        $categorys = Category::where('category_status',1)->orderBy('category_id','desc')->get();
        return view('BackEnd.Product.list',compact('categorys'));
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

            $validator = Validator::make($request->all(),[
                'product_image'=>'required',
                'product_name'=>'required',
                'product_slug'=>'required',
                'product_slug'=>'required',
                'product_date_sale'=>'required',
                'product_status'=>'required',
                'product_price_hidden'=>'required',
                'product_quantity'=>'required',
                'product_desc'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }else{
                if($request->promotion_price_hidden < $request->product_price_hidden){
                    $products = new Products();
                    $gallery = new Gallery();

                    $products->product_name = $request->product_name;
                    $products->product_slug = $request->product_slug;
                    $products->product_quantity = $request->product_quantity;
                    $products->product_sold = 0;
                    $products->category_id = $request->category_id;
                    $products->product_desc = $request->product_desc;
                    $products->updated_at = $request->product_date_sale ." ". now()->format('H:i:s');

                    $products->product_price = $request->product_price_hidden;
                    if ($request->promotion_price_hidden == '') {
                        $products->product_price_sale = 0;
                    }else{
                        $products->product_price_sale = $request->promotion_price_hidden;
                    }
                    $products->product_status = $request->product_status;
                    $products->product_view = 0;

                    if ($request->file('product_image')) {
                        $image = $request->file('product_image');
                        $name = time().'_'.$image->getClientOriginalName();
                        Storage::disk('public')->put($name,File::get($image));
                        $image->move(public_path('uploads/gallery'),$name);
                        $products->product_image = $name;
                        $gallery->gallery_image = $name;
                    }else{
                        $products->product_image = 'default.jpg';
                        $gallery->gallery_image = 'default.jpg';
                    }
                    $products->save();

                    $gallery->pro_id = $products->product_id;
                    $gallery->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Add new Successfully'
                    ]);
                }else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Promotion Price To Big!'
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
        if (request()->ajax()) {
            $product = Products::findOrFail($id);
            if ($product) {
                $date = Carbon::parse($product->updated_at)->format('Y/m/d');
                return response()->json([
                    'status'=>200,
                    'product'=>$product,
                    'date'=>$date,
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found',
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
        if($request->ajax()){

            $validator = Validator::make($request->all(),[
                'product_image'=>'required',
                'product_name'=>'required',
                'product_slug'=>'required',
                'product_slug'=>'required',
                'product_date_sale'=>'required',
                'product_status'=>'required',
                'product_price_hidden'=>'required',
                'product_quantity'=>'required',
                'product_desc'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }else{
                if($request->promotion_price_hidden < $request->product_price_hidden){
                    $products = Products::findOrFail($id);

                    $products->product_name = $request->product_name;
                    $products->product_slug = $request->product_slug;
                    $products->product_quantity = $request->product_quantity;
                    $products->category_id = $request->category_id;
                    $products->product_desc = $request->product_desc;

                    $products->updated_at = $request->product_date_sale ." ". now()->format('H:i:s');

                    $products->product_price = $request->product_price_hidden;
                    if ($request->promotion_price_hidden == '') {
                        $products->product_price_sale = 0;
                    }else{
                        $products->product_price_sale = $request->promotion_price_hidden;
                    }
                    $products->product_status = $request->product_status;

                    if ($request->file('product_image')) {
                        if ($products->product_image == 'default.jpg') {

                            $image = $request->file('product_image');
                            $name = time().'_'.$image->getClientOriginalName();
                            Storage::disk('public')->put($name,File::get($image));
                            $products->product_image = $name;

                        }else{

                            unlink(public_path('uploads/product/').$products->product_image);
                            $image = $request['product_image'];
                            $name = time().'_'.$image->getClientOriginalName();
                            Storage::disk('public')->put($name,File::get($image));
                            $products->product_image = $name;
                        }
                    }
                    $products->save();

                    return response()->json([
                        'status'=>200,
                        'message'=>'Add new Successfully'
                    ]);
                }else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'Promotion Price To Big!'
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
        $product = Products::findOrFail($id);
        $gallery = Gallery::where('gallery_product_id',$id)->get();
        if ($product) {
            if ($product->product_image == 'default.jpg') {
                foreach ($gallery as $key => $value) {
                    $del_img = $value->gallery_image;
                    if ($del_img != 'default.jpg') {
                        unlink(public_path('uploads/gallery/').$del_img);
                    }

                }
                $product->delete();
            }else{
                unlink(public_path('uploads/product/').$product->product_image);
                foreach ($gallery as $key => $value) {
                    $del_img = $value->gallery_image;
                    unlink(public_path('uploads/gallery/').$del_img);
                }
                $product->delete();
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
}
