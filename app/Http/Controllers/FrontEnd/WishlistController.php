<?php

namespace App\Http\Controllers\FrontEnd;

use App\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
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
            $wishlist = Wishlist::where('user_id',Auth::id())->join('product','product.product_id','wishlist.pro_id')->get();
            if(count($wishlist) > 0){
                foreach ($wishlist as $wish){
                    $output .='
                    <tr id="'. $wish->product_id .'" class="first odd">
                        <td class="wishlist-cell0 customer-wishlist-item-image">
                            <a  title="'. $wish->product_name .'" href="'. route('product-detail.show',$wish->product_slug) .'"
                                class="product-image">
                                <img width="150px" height="150px"  alt="'. $wish->product_name .'"
                                    src="'. asset("uploads/product/".$wish->product_image) .'">
                                <input type="hidden" name="id_hidden" id="id_hidden" value="'. $wish->product_id .'">
                            </a>
                        </td>
                        <td class="wishlist-cell1 customer-wishlist-item-info">
                            <h3 class="product-name">
                                <a title="'. $wish->product_name .'" href="'. route('product-detail.show',$wish->product_slug) .'">'. $wish->product_name .'</a>
                            </h3>
                            <div class="description std">
                                <div class="inner">'. substr($wish->product_desc, 0, 250) .'...</div>
                            </div>
                        </td>
                        <td data-rwd-label="Quantity"
                            class="wishlist-cell2 customer-wishlist-item-quantity">
                            <div class="cart-cell">
                                <div class="add-to-cart-alt">
                                    <input type="number" value="1"
                                        class="input-text qty validate-not-negative-number"
                                        pattern="\d*" maxlength="12" id="qty'. $wish->product_id .'" name="qty" min="1"
                                        max="'. $wish->product_quantity .'"
                                        oninput="this.value = Math.abs(this.value)">
                                </div>
                            </div>
                        </td>
                        <td data-rwd-label="Price"
                            class="wishlist-cell3 customer-wishlist-item-price">
                            <div class="cart-cell">
                                <div class="price-box">
                                    <span class="regular-price">';
                                        if ($wish->product_price_sale != 0)
                                            $output .='<span class="price">'. number_format($wish->product_price_sale) .' vnđ</span>';
                                        else{
                                            $output .='<span class="price">'. number_format($wish->product_price) .' vnđ</span>';
                                        }
                                        $output .='
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="wishlist-cell4 customer-wishlist-item-cart">
                            <div class="cart-cell">
                                <button class="button btn-cart formCart" title="Add to Cart" type="button" data-id="'. $wish->product_id .'">
                                    <span><span>Add to Cart</span></span>
                                </button>
                            </div>
                        </td>
                        <td class="wishlist-cell5 customer-wishlist-item-remove last">
                            <a class="remove-item delwishlist" data-id="'. $wish->product_id .'" title="Clear Cart"><span><span></span></span></a>
                        </td>
                    </tr>
                    ';
                }
            }else{
                $output .='
                <tr class="first odd">
                    <td colspan="6" style="text-align: center;font-size: 17px; color: #cec5c5;"
                    >Product Not Found</td>
                </tr>';
            }

            return response()->json([
                'data'=>$output
            ]);
        }
        return view('FrontEnd.wishlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $items = Session::get('compare');
            if($items == true){
                foreach($items as $key => $com){
                    if($com['id_pro'] == request()->id){
                        $action = 'Del';
                        $message = '';
                        unset($items[$key]);
                        Session::put('compare',$items);
                    }else{
                        $action = 'Add';
                        $message = 'Add Compare Successfully';
                        Session::push("compare",['key' => request()->id,'id_pro' => request()->id]);
                    }
                }
            }else{
                $action = 'Add';
                $message = 'Add Compare Successfully';
                $data[] = ['key' => request()->id, 'id_pro' => request()->id];
                Session::put('compare', $data);
            }

            return response()->json([
                'action'=>$action,
                'message'=>$message
            ]);
        }

        return view('FrontEnd.compare');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wish = Wishlist::where('user_id',Auth::id())->where('pro_id',$request->id)->first();
        if(!$wish){
            $action = 'Add';
            $wishlist = new Wishlist();
            $wishlist->user_id = Auth::id();
            $wishlist->pro_id = $request->id;
            $wishlist->save();
        }else{
            $action = 'Del';
            $wish->delete();
        }

        return response()->json([
            'action'=>$action,
            'message'=>'Add Wishlist Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = Session::get('compare');
        foreach($items as $key => $com){
            if($com['id_pro'] == $id){
                unset($items[$key]);
                Session::put('compare',$items);
            }
        }

        return redirect()->back();
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
