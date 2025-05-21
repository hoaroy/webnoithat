<?php

namespace App\Http\Controllers\FrontEnd;

use App\Gallery;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;
use Illuminate\Support\Facades\Session;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()){
            if($request->id > 0){
                $data = Review::where('review_id', '<', $request->id)
                                ->where('pro_id',$request->detail_id)
                                ->join('users','users.id','reviews.user_id')
                                ->select('reviews.*', 'users.name')
                                ->orderByDesc('review_id')
                                ->limit(2)
                                ->get();
            }else{
                $data = Review::where('pro_id',$request->detail_id)
                                ->join('users','users.id','reviews.user_id')
                                ->select('reviews.*', 'users.name')
                                ->orderByDesc('review_id')
                                ->limit(2)
                                ->get();
            }
            $output = '';
            $last_id = '';

            if(!$data->isEmpty()){
                foreach($data as $rev){
                    $output .='
                        <li>
                            <table class="ratings-table">
                                <tbody>
                                    <tr>
                                        <th>Value</th>
                                        <td>';
                                            for ($i = 0; $i < $rev->review_rating; $i++){
                                                $output .='<i style="color: #ffd322;" class="fa fa-star"></i>';
                                            }
                                            for ($j = $rev->review_rating; $j < 5; $j++){
                                                $output .='<i  style="color: #dcdcdc;" class="fa fa-star"></i>';
                                            }
                                            $output .='
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="review">
                                <h6><a href="#">'. $rev->name .'</a></h6>
                                <small>Review by <span>Leslie Prichard </span>on
                                    '. \Carbon\Carbon::parse($rev->created_at)->format('d/m/Y') .'
                                </small>
                                <div class="review-txt">'. $rev->review_desc .'</div>
                            </div>
                        </li>
                    ';
                    $last_id = $rev->review_id;
                }
                $output .='
                    <div class="actions">
                        <a  data-id="'.$last_id.'" class="button view-all" id="revies-button" href="#"><span><span>Load More</span></span></a>
                    </div>
                ';
            }else{
                $output .='
                    <div class="actions">
                        <a class="button view-all disabled" id="revies-button" href="#"><span><span>No Data Found</span></span></a>
                    </div>
                ';
            }

            return response()->json($output);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $output = '';
        if(Session::get('compare')){
            $output .='
                <div class="block-title ">Compare Products ('.count(Session::get('compare')).')</div>
                <div class="block-content">
                    <ol id="compare-items">';
                        foreach (Session::get('compare') as $com){
                        $pro = Products::where('product_id',$com['id_pro'])->first();
                        $output .='
                        <li class="item odd">
                            <input type="hidden" value="'. $com['id_pro'] .'" class="compare-item-id">
                            <a class="btn-remove1" title="Remove This Item" href="'. route('wishlist.show',$pro->product_id) .'"></a>
                            <a href="'. route('product-detail.show',$pro->product_id) .'" class="product-name" style="text-transform: capitalize"> '. $pro->product_name .'</a>
                        </li>';
                        }
                        $output .='
                    </ol>
                    <div class="ajax-checkout">
                        <button type="button" title="Submit"
                            class="button button-compare click_compare"><span>Compare</span></button>
                        <button type="button" title="Submit"
                            class="button button-clear click_clear"><span>Clear</span></button>
                    </div>
                </div>
            ';
        }
        return response()->json([
            'data'=>$output
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::forget('compare');

        return response()->json(['status'=>200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_detail = Products::where('product_slug',$id)->orWhere('product_id',$id)->first();
        $product_related =Products::where('product_status',1)->where('category_id',$product_detail->category_id)->get();
        $gallery = Gallery::where('pro_id',$product_detail->product_id)->get();

        $review = Review::where('pro_id',$product_detail->product_id)
                        ->join('users','users.id','reviews.user_id')
                        ->select('reviews.*', 'users.name')
                        ->orderByDesc('review_id')
                        ->get();
        $rating_avg = Review::where('pro_id',$product_detail->product_id)->avg('review_rating');

        //update view
        $product_detail->product_view = $product_detail->product_view + 1;
        $product_detail->save();

        return view('FrontEnd.detail', compact('product_detail','gallery','product_related','review','rating_avg'));
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
