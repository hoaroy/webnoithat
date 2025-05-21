<?php

namespace App\Http\Controllers\FrontEnd;

use Cart;
use App\Category;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->page = 8;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = request()->all();
            $header = Category::where('category_id',$data['id'])->first();
            $categoryProduct = Products::where('product_status',1)->where('category_id',$header->category_id)->paginate($data['show']);
            $select = $data['show'];
            $header_name = $header->category_name;
            $header_id= $header->category_id;

            return view('FrontEnd.cate_include',compact('categoryProduct','header_id','header_name','select'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $data = request()->all();
            $select = $this->page;
            $header = Category::where('category_id',$data['id'])->first();
            $header_name = $header->category_name;
            $header_id= $header->category_id;
            $categoryProduct = Products::where('product_status',1)->where('category_id',$header->category_id)->paginate($select);

            return view('FrontEnd.cate_include',compact('categoryProduct','header_id','header_name','select'))->render();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(request()->ajax()){
            $output = '';
            $total = 0;
            foreach(Cart::content() as $cart)
            {
                $total += $cart->qty * $cart->price;
                $output .='
                    <div class="summary">
                        <p class="amount">There are <a href="'.route('cart.index') .'">'.Cart::content()->count().' items</a> in your cart.
                        </p>
                        <p class="subtotal"> <span class="label">Cart Subtotal:</span> <span
                                class="price">'.number_format($total).' vnđ</span> </p>
                    </div>
                    <div class="">';
                        if(Auth::user()){
                            $output .='
                        <a style="
                                font-size: 11px; font-weight: bold; letter-spacing: 1px; line-height: normal;
                                padding: 8px 12px; text-transform: uppercase; border: 1px #e5e5e5 solid;
                                height: 33px; font-family: "Poppins", sans-serif;"
                            href="'. route('cart-address.index') .'" class="button button-checkout"
                            type="submit"><span>Checkout</span></a>';
                        }else{
                        $output .='
                        <a style="
                            font-size: 11px; font-weight: bold; letter-spacing: 1px; line-height: normal;
                            padding: 8px 12px; text-transform: uppercase; border: 1px #e5e5e5 solid;
                            height: 33px; font-family: "Poppins", sans-serif;"
                        href="'. route('login.index') .'" class="button button-checkout"
                        type="submit"><span>Checkout</span></a>';
                        }
                        $output .='
                    </div>
                    <p class="block-subtitle">Recently added item(s) </p>
                    <ul>
                        <li class="item"> <a href="shopping_cart.html" title="Fisher-Price Bubble Mower"
                                class="product-image"><img src="'.url('uploads/product/'.$cart->options->image).'"
                                    alt="Fisher-Price Bubble Mower"></a>
                            <div class="product-details">
                                <strong>'.$cart->qty.'</strong> x <span class="price">'.number_format($cart->price).' vnđ</span>
                                <p class="product-name"> <a href="'.route('product-detail.show',$cart->id).'">'.substr($cart->name, 0, 100).'...</a> </p>
                            </div>
                        </li>
                    </ul>
                ';

                return response()->json([
                    'output'=>$output
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
        $select = $this->page;
        $header = Category::where('category_slug',$id)->orWhere('category_id',$id)->first();
        $header_name = $header->category_name;
        $header_id= $header->category_id;
        $categoryProduct = Products::where('product_status',1)->where('category_id',$header->category_id)->paginate($select);

        return view('FrontEnd.category',compact('categoryProduct','header_id','header_name','select'));
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
