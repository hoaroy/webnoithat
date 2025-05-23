@extends('Layout_user')
@section('title')
    Detail
@endsection
@section('content')
    <section class="main-container col1-layout">
        <div class="container">
            <div class="row">

                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}" title="Go to Home Page">Home</a><span>/</span></li>
                        @if ($product_detail->cate_product->category_sub != '')
                        @php
                            $cateparent = App\Category::where('category_id',$product_detail->cate_product->category_sub)->first();
                            $cateparent2 = App\Category::where('category_id',$cateparent->category_sub)->first();
                        @endphp
                        @if ($cateparent2)
                        <li><a href="#" title="" style="text-transform: lowercase;">{{ $cateparent2->category_name }}</a><span>/</span></li>
                        @endif
                        @if ($cateparent)
                        <li><a href="#" title="" style="text-transform: lowercase;">{{ $cateparent->category_name }}</a><span>/</span></li>
                        @endif
                        @endif
                        <li><a href="#" title="" style="text-transform: lowercase;">{{ $product_detail->cate_product->category_name }}</a><span>/</span></li>
                        <li><strong style="text-transform: lowercase;">{{ $product_detail->product_name }}</strong></li>
                    </ul>
                </div>
                <!-- Breadcrumbs End -->

                <div class="col-sm-12 col-xs-12">
                    <article class="col-main">
                        <div class="product-view">
                            <div class="product-essential">
                                <form method="post" id="formCart">
                                    <input type="hidden" name="id_hidden" id="id_hidden" value="{{ $product_detail->product_id }}">
                                    <div class="product-img-box col-lg-4 col-sm-5 col-xs-12">
                                        {{--  <div class="new-label new-top-left"> New </div>  --}}
                                        <div class="product-image">
                                            <div class="product-full">
                                                <img id="product-zoom"
                                                    src="{{ asset('uploads/product/' . $product_detail->product_image) }}"
                                                    data-zoom-image="{{ asset('uploads/product/' . $product_detail->product_image) }}"
                                                    alt="product-image" width="371px" height="371px" />
                                            </div>
                                            <div class="more-views">
                                                <div class="slider-items-products">
                                                    <div id="gallery_01"
                                                        class="product-flexslider hidden-buttons product-img-thumb">
                                                        <div class="slider-items slider-width-col4 block-content">
                                                            @foreach ($gallery as $gal)
                                                                <div class="more-views-items">
                                                                    <a href="#"
                                                                        data-image="{{ asset('uploads/gallery/' . $gal->gallery_image) }}"
                                                                        data-zoom-image="{{ asset('uploads/gallery/' . $gal->gallery_image) }}">
                                                                        <img id="product-zoom2"
                                                                            src="{{ asset('uploads/gallery/' . $gal->gallery_image) }}"
                                                                            alt="product-image-{{ $gal->gallery_id }}"
                                                                            width="73px" height="73px" />
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end: more-images -->
                                    </div>
                                    <div class="product-shop col-lg-8 col-sm-7 col-xs-12">
                                        <div class="product-next-prev"> <a class="product-next" href="#"><span></span></a>
                                            <a class="product-prev" href="#"><span></span></a> </div>
                                        <div class="product-name">
                                            <h1>{{ $product_detail->product_name }}</h1>
                                        </div>
                                        <div class="ratings">
                                            @if (round($rating_avg) > 0)
                                            @for ($i = 0; $i < round($rating_avg); $i++)
                                            <i style="color: #ffd322;" class="fa fa-star"></i>
                                            @endfor
                                            @for ($j = round($rating_avg); $j < 5; $j++)
                                            <i  style="color: #dcdcdc;" class="fa fa-star"></i>
                                            @endfor
                                            @else
                                             <span style="font-size: 12px;color: #a8acaf;">No Ranting</span>
                                            @endif
                                            <p class="rating-links"> <a href="#">{{ count($review) }} Review(s)</a> <span
                                                    class="separator">|</span> <a href="#">Add Your Review</a> </p>
                                        </div>
                                        <div class="price-block">
                                            <div class="price-box">
                                                @if ($product_detail->product_price_sale != 0)
                                                    <p class="special-price"> <span class="price-label">Special
                                                            Price</span>
                                                        <span class="price">
                                                            @if ($product_detail->product_price_sale != 0)
                                                                {{ number_format($product_detail->product_price_sale) }}
                                                                vnđ
                                                            @else
                                                                {{ number_format($product_detail->product_price) }} vnđ
                                                            @endif
                                                        </span>
                                                    </p>
                                                    <p class="old-price"> <span class="price-label">Regular
                                                            Price:</span>
                                                        <span class="price">
                                                            {{ number_format($product_detail->product_price) }} vnđ</span>
                                                    </p>
                                                @else
                                                    <p class="special-price"> <span class="price-label">Special
                                                            Price</span>
                                                        <span
                                                            class="price">{{ number_format($product_detail->product_price) }}
                                                            vnđ</span>
                                                    </p>
                                                @endif
                                                @if ($product_detail->product_quantity > 0)
                                                    <p class="availability in-stock pull-right"><span>Trong kho</span></p>
                                                @else
                                                    <p class="availability out-of-stock pull-right"><span>Hết hàng</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="add-to-box">
                                            <div class="add-to-cart">
                                                <div class="pull-left">
                                                    <div class="custom pull-left"> <span class="qty-label">QTY:</span>
                                                        <button
                                                            onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) result.value--;return false;"
                                                            class="reduced items-count" type="button"><i
                                                                class="fa fa-minus">&nbsp;</i></button>
                                                        <input type="number" class="input-text qty" title="Qty" value="1"
                                                            maxlength="12" id="qty" name="qty" min="1"
                                                            max="{{ $product_detail->product_quantity }}"
                                                            oninput="validity.valid||(value='');">
                                                        <button
                                                            onClick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;"
                                                            class="increase items-count" type="button"><i
                                                                class="fa fa-plus">&nbsp;</i></button>
                                                    </div>
                                                </div>
                                                <button class="button btn-cart"
                                                    {{ $product_detail->product_quantity > 0 ? '' : 'disabled' }}
                                                    title="Add to Cart" type="submit">Add to
                                                    Cart</button>
                                            </div>


                                        </div>
                                        <div class="short-description" style="text-align: justify;">
                                            <h2>Quick Overview</h2>
                                            {!! substr($product_detail->product_desc, 0, 450) !!}...
                                        </div>
                                        <div class="email-addto-box">
                                            <ul class="add-to-links">
                                                <li>
                                                    @if (Auth::user())
                                                    @php
                                                        $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$product_detail->product_id)->first();
                                                    @endphp
                                                        @if ($check_wish)
                                                        <a class="link-wishlist add_Wishlist wishcolor"
                                                        id="{{ $product_detail->product_id }}"><span>Thêm vào danh sách yêu thích</span></a>
                                                        @else
                                                        <a class="link-wishlist add_Wishlist"
                                                        id="{{ $product_detail->product_id }}"><span>Thêm vào danh sách yêu thích</span></a>
                                                        @endif
                                                    @else
                                                    <a class="link-wishlist"
                                                        href="{{ route('login.index') }}"><span>Thêm vào danh sách yêu thích</span></a>
                                                    @endif
                                                </li>
                                                <li>
                                                    <span class="separator">|</span>
                                                    <a class="link-compare add_compare" data-compare_id="{{ $product_detail->product_id }}">
                                                        <span>thêm vào để so sánh</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <p class="email-friend"><a href="#"><span>Email cho bạn bè</span></a></p>
                                        </div>
                                        <div class="social">
                                            <ul class="link">
                                                <li class="fb"><a href="#"></a></li>
                                                <li class="tw"><a href="#"></a></li>
                                                <li class="googleplus"><a href="#"></a></li>
                                                <li class="rss"><a href="#"></a></li>
                                                <li class="pintrest"><a href="#"></a></li>
                                                <li class="linkedin"><a href="#"></a></li>
                                                <li class="youtube"><a href="#"></a></li>
                                            </ul>
                                        </div>

                                        <ul class="shipping-pro">
                                        <li>Giao hàng miễn phí trên toàn thế giới</li>
                                            <li>30 ngày đổi trả</li>
                                            <li>Giảm giá thành viên</li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                            <div class="product-collateral">
                                <div class="add_info">
                                    <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                                    <li class="active"> <a href="#product_tabs_description" data-toggle="tab">
                                                 Mô tả sản phẩm </a></li>
                                         <li><a href="#product_tabs_tags" data-toggle="tab">Thẻ</a></li>
                                         <li><a href="#reviews_tabs" data-toggle="tab">Bài đánh giá ({{ count($review) }})</a></li>
                                     </ul>
                                     <div id="productTabContent" class="tab-content">
                                         <div class="tab-pane fade in active" id="product_tabs_description" style="text-align: justify;">
                                             <div class="std">
                                                 {!! $product_detail->product_desc!!}
                                             </div>
                                         </div>
                                         <div class="tab-pane fade" id="product_tabs_tags">
                                             <div class="box-collateral box-tags">
                                                 <div class="tags">
                                                     <form id="addTagForm" action="#" method="get">
                                                         <div class="form-add-tags">
                                                             <label for="productTagName">Thêm thẻ:</label>
                                                             <div class="input-box">
                                                                 <input class="input-text" name="productTagName"
                                                                     id="productTagName" type="text">
                                                                 <button type="button" title="Thêm thẻ"
                                                                     class="button btn-add" onClick="submitTagForm()">
                                                                     <span>Thêm thẻ</span> </button>
                                                             </div>
                                                             <!--hộp-nhập-->
                                                         </div>
                                                     </form>
                                                 </div>
                                                 <!--thẻ-->
                                                 <p class="note">Sử dụng số bước để phân tách các thẻ. Sử dụng dấu ngoặc kép ()
                                                     vì
                                                     cụm từ.</p>
                                             </div>
                                        </div>
                                        <div class="tab-pane fade" id="reviews_tabs">
                                            <div class="box-collateral box-reviews" id="customer-reviews">
                                                <div class="box-reviews2" >
                                                    <h3>Customer Reviews</h3>
                                                    <div class="box visible">
                                                        <ul id="loadReviews">
                                                            {{--  @if (count($review) > 0)
                                                            @foreach ($review as $rev)
                                                            <li>
                                                                <table class="ratings-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>Value</th>
                                                                            <td>
                                                                                @for ($i = 0; $i < $rev->review_rating; $i++)
                                                                                <i style="color: #ffd322;" class="fa fa-star"></i>
                                                                                @endfor
                                                                                @for ($j = $rev->review_rating; $j < 5; $j++)
                                                                                <i  style="color: #dcdcdc;" class="fa fa-star"></i>
                                                                                @endfor
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="review">
                                                                    <h6><a href="#">{{ $rev->name }}</a></h6>
                                                                    <small>Review by <span>Leslie Prichard </span>on
                                                                        {{ Carbon\Carbon::parse($rev->created_at)->format('d/m/Y') }}
                                                                    </small>
                                                                    <div class="review-txt">{!! $rev->review_desc !!}</div>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                            @else
                                                            <li style="font-size: 20px;
                                                            text-align: center;
                                                            color: #cecece;">No Review</li>
                                                            @endif  --}}
                                                            {{--  <div class="actions">
                                                                <a class="button view-all"
                                                                    id="revies-button" href="#"><span><span>View
                                                                            all</span></span></a>
                                                            </div>  --}}
                                                        </ul>

                                                    </div>

                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Related Slider -->
                            <div class="related-pro">
                                <div class="slider-items-products">
                                    <div class="related-block">
                                        <div class="home-block-inner">
                                            <div class="block-title">
                                            <h2>Sản phẩm liên quan</h2>
                                            </div>
                                        </div>
                                        <div id="related-products-slider" class="product-flexslider hidden-buttons">
                                            <div class="slider-items slider-width-col4 products-grid block-content">
                                                @foreach ($product_related as $pro_rel)
                                                    <div class="item">
                                                        <div class="item-inner">
                                                            <div class="item-img">
                                                                <div class="item-img-info">
                                                                    <a class="product-image" title="Retis lapen casen"
                                                                        href="{{ route('product-detail.show', $pro_rel->product_slug) }}">
                                                                        <img alt="Retis lapen casen" width="267px"
                                                                            height="267px"
                                                                            src="{{ asset('uploads/product/' . $pro_rel->product_image) }}">
                                                                    </a>
                                                                    @if ($pro_rel->product_price_sale != 0)
                                                                        <div class="sale-label sale-top-left" style="display: block !important;">Sale
                                                                        </div>
                                                                    @endif
                                                                    @if (Carbon\Carbon::parse($pro_rel->created_at)->format('Y/m/d') >= $startOfWeek && Carbon\Carbon::parse($pro_rel->created_at)->format('Y/m/d') <= $endOfWeek)
                                                                        <div class="new-label new-top-right" style="display: block !important;">New
                                                                        </div>
                                                                    @endif
                                                                    <div class="box-hover">
                                                                        <ul class="add-to-links">
                                                                            <li><a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                                                                data-target="#quickview_product{{ $pro_rel->product_id }}"></a></li>
                                                                            <li>
                                                                                @if (Auth::user())
                                                                                @php
                                                                                    $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$pro_rel->product_id)->first();
                                                                                @endphp
                                                                                    @if ($check_wish)
                                                                                    <a class="link-wishlist add_Wishlist wishcolor"
                                                                                    id="{{ $pro_rel->product_id }}"></a>
                                                                                    @else
                                                                                    <a class="link-wishlist add_Wishlist"
                                                                                    id="{{ $pro_rel->product_id }}"></a>
                                                                                    @endif
                                                                                @else
                                                                                <a class="link-wishlist"
                                                                                    href="{{ route('login.index') }}"></a>
                                                                                @endif
                                                                            </li>
                                                                            <li>
                                                                                <a class="link-compare add_compare" data-compare_id="{{ $pro_rel->product_id }}"></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="item-info">
                                                                <div class="info-inner">
                                                                    <div class="item-title"> <a
                                                                            title="Retis lapen casen"
                                                                            href="{{ route('product-detail.show', $pro_rel->product_slug) }}">
                                                                            {{ $pro_rel->product_name }} </a>
                                                                    </div>
                                                                    <div class="rating">
                                                                        <div class="ratings">
                                                                            <div class="rating-box">
                                                                                <div style="width:80%"
                                                                                    class="rating">
                                                                                </div>
                                                                            </div>
                                                                            <p class="rating-links"> <a href="#">1
                                                                                    Review(s)</a>
                                                                                <span class="separator">|</span> <a
                                                                                    href="#">Add Review</a>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-content">
                                                                        <div class="item-price">
                                                                            <div class="price-box">
                                                                                <span class="regular-price">
                                                                                    <span class="price">
                                                                                        @if ($pro_rel->product_price_sale != 0)
                                                                                            {{ number_format($pro_rel->product_price_sale) }}
                                                                                            vnđ
                                                                                        @else
                                                                                            {{ number_format($pro_rel->product_price) }}
                                                                                            vnđ
                                                                                        @endif
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="action">
                                                                            <button class="button btn-cart" type="button"
                                                                                title="" data-original-title="Add to Cart"
                                                                                {{ $pro_rel->product_quantity > 0 ? '' : 'disabled' }}><span>Add
                                                                                    to
                                                                                    Cart</span> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End related products Slider -->
                        </div>
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>

            </div>
        </div>
    </section>
    <input type="hidden" id="hiddendetal_id" value="{{ $product_detail->product_id }}">
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
          }
    </style>
@endsection
@section('js')
<script>
    function loadReview(id=""){
        $.ajax({
            type: 'get',
            url: '{{ route('product-detail.index') }}',
            data: {
                id:id,
                detail_id:$('#hiddendetal_id').val()
            },
            dataType: 'json',
            success:function(data){
                $('#revies-button').remove();
                $('#loadReviews').append(data);
            }
        });
    }
    $(document).ready(function(){
        // Load Review
        loadReview('');
        // Click Load More
        $(document).on('click', '#revies-button', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('#revies-button').html('<b>Loading...</b>');
            loadReview(id);
        });
        // Add Cart
        $(document).on('submit','#formCart', function(e){
            e.preventDefault();
            var qtycart = $('#qty').val();
            var id_pro = $('#id_hidden').val();

            $.ajax({
                type: 'post',
                url: '{{ route('cart.store') }}',
                data: {
                    qtycart:qtycart,
                    id_pro:id_pro
                },
                dataType: 'json',
                success:function(response){
                    loadSidebar();
                    toastr.success(response.message, 'Notification');
                }
            });
        });
    });
</script>
@endsection
