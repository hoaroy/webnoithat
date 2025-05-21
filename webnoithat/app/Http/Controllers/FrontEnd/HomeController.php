<?php

namespace App\Http\Controllers\FrontEnd;

use Cart;
use App\Slider;
use App\Category;
use App\Gallery;
use App\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = request()->all();

            $query = $data['query'];

            $filter_data = Products::select('product_name')->where('product_name', 'LIKE', '%'.$query.'%')
                            ->get();

            $data = array();
            foreach ($filter_data as $fil)
                {
                    $data[] = $fil->product_name;
                }

            return response()->json($data);
        }
        $hotdeal = Products::where('product_status',1)
                            ->where('product_price_sale','!=', 0)
                            ->inRandomOrder()
                            ->take(1)
                            ->get();
        $startWeek = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth();
        $endWeek = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth();

        $slider = Slider::where('slider_status',1)->orderBy('slider_sorting','asc')->get();
        $new_category = Category::whereNull('category_sub')->where('category_status',1)->take(4)->inRandomOrder()->get();
        $all_product = Products::whereBetween('created_at', [$startWeek,$endWeek])
                                ->where('product_status',1)
                                ->take(4)->inRandomOrder()
                                ->get();
        $best_product = Products::where('product_status',1)->where('product_sold','!=',0)->inRandomOrder()->get();
        $featured_product = Products::where('product_status',1)->orderBy('product_view','desc')->inRandomOrder()->get();

        return view('FrontEnd.index', compact('hotdeal','slider','new_category','all_product','best_product','featured_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $output_2 = '';
            $output = '';
            $output_2 .= ' '.Cart::content()->count().' Items/ '.Cart::subtotal().' ';
            foreach(Cart::content() as $cten){
                $output .='
                <li class="item first">
                    <div class="item-inner">
                        <a class="product-image" title="Retis lapen casen" href="#l"><img
                                alt="Retis lapen casen"
                                src="'.url('uploads/product/'.$cten->options->image).'">
                        </a>
                        <div class="product-details">
                            <div class="access">
                                <a class="btn-remove1 remove_cart_rowId" data-href_rowid="'.route('cart.show',$cten->rowId).'"
                                    title="Remove This Item">Remove</a>
                            </div>
                            <strong>'.$cten->qty.'</strong> x <span class="price">'.number_format($cten->price).' vnđ</span>
                            <p class="product-name"><a href="#">'.substr($cten->name, 0, 100).'...</a></p>
                        </div>
                    </div>
                </li>';
            }
            return response()->json([
                'data'=>$output,
                'countData'=>$output_2,
            ]);

        }
        $data = request()->search;
        $select = 30;
        $header_id = 'Search';
        $header_name = 'Search: "'.$data.'"';
        $categoryProduct = Products::where('product_status',1)->where('product_name','LIKE','%'.$data.'%')
                                    ->orWhere('product_price','LIKE','%'.$data.'%')
                                    ->orWhere('product_price_sale','LIKE','%'.$data.'%')
                                    ->take($select)->paginate($select);

        return view('FrontEnd.category',compact('categoryProduct','header_id','header_name','select'));

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
            $product_cart = Products::where('product_id',$request->id_procart)->first();
            if($product_cart){
                if ($product_cart->product_price_sale != 0) {
                    $price = $product_cart->product_price_sale;
                }else{
                    $price = $product_cart->product_price;
                }
                $data['id'] = $product_cart->product_id;
                $data['qty'] = 1;
                $data['name'] = $product_cart->product_name;
                $data['price'] = $price;
                $data['weight'] = $price;
                $data['options']['image'] = $product_cart->product_image;
                $data['options']['slug'] = $product_cart->product_slug;
                Cart::add($data);

                return response()->json([
                    'status'=>200,
                    'message'=>'Add Cart Successfully'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found'
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
