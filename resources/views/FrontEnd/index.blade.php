@extends('Layout_user')
@section('title')
  Home
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 col-md-4 col-sm-3 hidden-xs">
            <div class="side-banner"><img src="{{ asset('frontend/images/noithat.jpg') }}"
                    alt="banner"></div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12 home-slider">
            <div id="magik-slideshow" class="magik-slideshow slider-block">
                <div id='rev_slider_4_wrapper' class='rev_slider_wrapper fullwidthbanner-container'>
                    <div id='rev_slider_4' class='rev_slider fullwidthabanner'>
                        <ul>
                            @foreach ($slider as $row)
                            <li data-transition="random">
                                <img src="{{ asset('uploads/slider/'.$row->slider_image ) }}" alt="Ocean" class="rev-slidebg" width="847.5px" height="433px">
                                <div class="info {{ $row->slider_change == 1 ? 'slide2' : ''}}">
                                    <div class='tp-caption ExtraLargeTitle sft tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'><span>{{ $row->slider_name }}</span> </div>
                                    <div class='tp-caption LargeTitle sfl  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'>{{ $row->slider_content }}</div>
                                    <div class='tp-caption Title sft  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1500' data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'>{{ $row->slider_desc }}</div>
                                    <div class='tp-caption sfb  tp-resizeme ' data-endspeed='500' data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'><a href='{{ $row->slider_url }}' class="buy-btn">Buy Now</a> </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="main-container col2-left-layout">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12 col-sm-push-4 col-md-push-3">

                <!-- promotion banner -->
                <div class="promotion-banner">
                    <div class="row">
                        <div class="col-lg-5 col-sm-5">
                            <a href="#"><img alt=""
                                    src="{{ asset('frontend/images/home1.jpg') }}"></a>
                        </div>
                        <div class="col-lg-7 col-sm-7">
                            <a href="#"><img alt=""
                                    src="{{ asset('frontend/images/home2.jpg') }}"></a>
                        </div>
                    </div>
                </div>
                <div class="content-page">

                    <!-- featured category -->
                    <div class="category-product">
                        <div class="navbar nav-menu">
                            <div class="navbar-collapse">
                                <div class="new_title">
                                    <h2>New Products</h2>
                                </div>
                                <ul class="nav navbar-nav">
                                    <li class="active"><a data-toggle="tab" href="#tab-0">All</a></li>
                                    @foreach($new_category as $new_cate)
                                    <li><a data-toggle="tab" href="#tab-{{$new_cate->category_id}}">{{$new_cate->category_name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.navbar-collapse -->
                        </div>
                        <div class="product-bestseller">
                            <div class="product-bestseller-content">
                                <div class="product-bestseller-list">
                                    <div class="tab-container">
                                        <!-- tab product -->
                                        <div class="tab-panel active" id="tab-0">
                                            @if (count($all_product) > 0)
                                            <div class="category-products">
                                                <ul class="products-grid">
                                                    @foreach ($all_product as $item)
                                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                        <div class="item-inner">
                                                            <div class="item-img">
                                                                <div class="item-img-info">
                                                                    <a class="product-image"
                                                                        title="Retis lapen casen"
                                                                        href="{{ route('product-detail.show',$item->product_slug) }}"> <img
                                                                            alt="Retis lapen casen" with="195px" height="195px"
                                                                            src="{{ asset('uploads/product/'.$item->product_image) }}">
                                                                    </a>
                                                                    @if ($item->product_price_sale != 0)
                                                                    <div class="sale-label sale-top-left">Sale
                                                                    </div>
                                                                    @endif
                                                                    @if (Carbon\Carbon::parse($item->created_at)->format('Y/m/d') >= $startOfWeek  &&  Carbon\Carbon::parse($item->created_at)->format('Y/m/d') <= $endOfWeek )
                                                                    <div class="new-label new-top-right">New
                                                                    </div>
                                                                    @endif
                                                                    <div class="box-hover">
                                                                        <ul class="add-to-links">
                                                                            <li>
                                                                                <a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                                                                data-target="#quickview_product{{ $item->product_id }}"></a>
                                                                            </li>
                                                                            <li>
                                                                                @if (Auth::user())
                                                                                @php
                                                                                    $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$item->product_id)->first();
                                                                                @endphp
                                                                                    @if ($check_wish)
                                                                                    <a class="link-wishlist add_Wishlist wishcolor"
                                                                                    id="{{ $item->product_id }}"></a>
                                                                                    @else
                                                                                    <a class="link-wishlist add_Wishlist"
                                                                                    id="{{ $item->product_id }}"></a>
                                                                                    @endif
                                                                                @else
                                                                                <a class="link-wishlist"
                                                                                    href="{{ route('login.index') }}"></a>
                                                                                @endif
                                                                            </li>
                                                                            <li>
                                                                                <a class="link-compare add_compare" data-compare_id="{{ $item->product_id }}"></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="item-info">
                                                                <div class="info-inner">
                                                                    <div class="item-title"> <a
                                                                            title="Retis lapen casen"
                                                                            href="{{ route('product-detail.show',$item->product_slug) }}"> {{$item->product_name}} </a> </div>
                                                                    <div class="item-content">
                                                                        <div class="rating">
                                                                            <div class="ratings">
                                                                                <div class="rating-box">
                                                                                    <div
                                                                                        class="rating width80">
                                                                                    </div>
                                                                                </div>
                                                                                <p class="rating-links"> <a
                                                                                        href="#">1 Review(s)</a>
                                                                                    <span
                                                                                        class="separator">|</span>
                                                                                    <a href="#">Add Review</a>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item-price">
                                                                            <div class="price-box"> <span
                                                                                    class="regular-price">
                                                                                    <span
                                                                                        class="price">
                                                                                        @if($item->product_price_sale != 0)
                                                                                        {{number_format($item->product_price_sale)}} vnđ
                                                                                        @else
                                                                                        {{number_format($item->product_price)}} vnđ
                                                                                        @endif
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="action">
                                                                            <button class="button btn-cart add_cart"
                                                                                type="button" title="" data-id_pro="{{ $item->product_id }}"
                                                                                data-original-title="Add to Cart"><span>Add
                                                                                    to Cart</span> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @else
                                            <h4 style="text-align: center; color: #777;">Product Not Found</h4>
                                            @endif
                                        </div>
                                        <!-- tab product -->
                                        @foreach($new_category as $new_cate)
                                        @php
                                            $new_product = App\Products::where('product_status',1)
                                            ->where('category_id',$new_cate->category_id)
                                            ->get();
                                        @endphp

                                        <div class="tab-panel" id="tab-{{$new_cate->category_id}}">
                                            @if(count($new_product) > 0)
                                            @foreach($new_product as $new_pro)
                                            <div class="category-products">
                                                <ul class="products-grid">
                                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                        <div class="item-inner">
                                                            <div class="item-img">
                                                                <div class="item-img-info">
                                                                    <a class="product-image"
                                                                        title="Retis lapen casen"
                                                                        href="{{ route('product-detail.show',$new_pro->product_slug) }}"> <img
                                                                            alt="Retis lapen casen" with="195px" height="195px"
                                                                            src="{{ asset('uploads/product/'.$new_pro->product_image) }}">
                                                                    </a>
                                                                    @if ($new_pro->product_price_sale != 0)
                                                                    <div class="sale-label sale-top-left">Sale
                                                                    </div>
                                                                    @endif
                                                                    @if (Carbon\Carbon::parse($new_pro->created_at)->format('Y/m/d') >= $startOfWeek  &&  Carbon\Carbon::parse($new_pro->created_at)->format('Y/m/d') <= $endOfWeek )
                                                                    <div class="new-label new-top-right">New
                                                                    </div>
                                                                    @endif
                                                                    <div class="box-hover">
                                                                        <ul class="add-to-links">
                                                                            <li>
                                                                                <a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                                                                data-target="#quickview_product{{ $new_pro->product_id }}"></a>
                                                                            </li>
                                                                            <li>
                                                                                @if (Auth::user())
                                                                                @php
                                                                                    $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$new_pro->product_id)->first();
                                                                                @endphp
                                                                                    @if ($check_wish)
                                                                                    <a class="link-wishlist add_Wishlist wishcolor"
                                                                                    id="{{ $new_pro->product_id }}"></a>
                                                                                    @else
                                                                                    <a class="link-wishlist add_Wishlist"
                                                                                    id="{{ $new_pro->product_id }}"></a>
                                                                                    @endif
                                                                                @else
                                                                                <a class="link-wishlist"
                                                                                    href="{{ route('login.index') }}"></a>
                                                                                @endif
                                                                            </li>
                                                                            <li>
                                                                                <a class="link-compare add_compare" data-compare_id="{{ $new_pro->product_id }}"></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="item-info">
                                                                <div class="info-inner">
                                                                    <div class="item-title"> <a
                                                                            title="Retis lapen casen"
                                                                            href="{{ route('product-detail.show',$new_pro->product_slug) }}">{{$new_pro->product_name}} </a> </div>
                                                                    <div class="item-content">
                                                                        <div class="rating">
                                                                            <div class="ratings">
                                                                                <div class="rating-box">
                                                                                    <div
                                                                                        class="rating width80">
                                                                                    </div>
                                                                                </div>
                                                                                <p class="rating-links"> <a
                                                                                        href="#">1 Review(s)</a>
                                                                                    <span
                                                                                        class="separator">|</span>
                                                                                    <a href="#">Add Review</a>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item-price">
                                                                            <div class="price-box">
                                                                                <span
                                                                                    class="regular-price">
                                                                                    <span
                                                                                        class="price">
                                                                                        @if($new_pro->product_price_sale != 0)
                                                                                        {{number_format($new_pro->product_price_sale)}} vnđ
                                                                                        @else
                                                                                        {{number_format($new_pro->product_price)}} vnđ
                                                                                        @endif
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="action">
                                                                            <button class="button btn-cart add_cart"
                                                                                type="button" title="" data-id_pro="{{ $new_pro->product_id }}"
                                                                                data-original-title="Add to Cart"><span>Add
                                                                                    to Cart</span> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            @endforeach
                                            @else
                                            <h4 style="text-align: center; color: #777;">Product Not Found</h4>
                                            @endif
                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bestsell slider -->
                <div class="bestsell-pro">
                    <div>
                        <div class="slider-items-products">
                            <div class="bestsell-block">
                                <div class="block-title">
                                    <h2>Best Sellers</h2>
                                </div>
                                <div id="bestsell-slider" class="product-flexslider hidden-buttons">
                                    <div class="slider-items slider-width-col4 products-grid block-content">
                                        @foreach ($best_product as $row)
                                        <div class="item">
                                            <div class="item-inner">
                                                <div class="item-img">
                                                    <div class="item-img-info">
                                                        <a class="product-image" title="Retis lapen casen"
                                                            href="{{ route('product-detail.show',$row->product_slug) }}"> <img
                                                                alt="Retis lapen casen" width="269px" height="269px"
                                                                src="{{ asset('uploads/product/'.$row->product_image) }}">
                                                        </a>
                                                        @if ($row->product_price_sale != 0)
                                                        <div class="sale-label sale-top-left">Sale
                                                        </div>
                                                        @endif
                                                        @if (Carbon\Carbon::parse($row->created_at)->format('Y/m/d') >= $startOfWeek  &&  Carbon\Carbon::parse($row->created_at)->format('Y/m/d') <= $endOfWeek )
                                                        <div class="new-label new-top-right">New
                                                        </div>
                                                        @endif
                                                        <div class="box-hover">
                                                            <ul class="add-to-links">
                                                                <li>
                                                                    <a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                                                        data-target="#quickview_product{{ $row->product_id }}"></a>
                                                                </li>
                                                                <li>
                                                                    @if (Auth::user())
                                                                    @php
                                                                        $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$row->product_id)->first();
                                                                    @endphp
                                                                        @if ($check_wish)
                                                                        <a class="link-wishlist add_Wishlist wishcolor"
                                                                        id="{{ $row->product_id }}"></a>
                                                                        @else
                                                                        <a class="link-wishlist add_Wishlist"
                                                                        id="{{ $row->product_id }}"></a>
                                                                        @endif
                                                                    @else
                                                                    <a class="link-wishlist"
                                                                        href="{{ route('login.index') }}"></a>
                                                                    @endif
                                                                </li>
                                                                <li>
                                                                    <a class="link-compare add_compare" data-compare_id="{{ $row->product_id }}"></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item-info">
                                                    <div class="info-inner">
                                                        <div class="item-title"> <a
                                                                title="Retis lapen casen"
                                                                href="{{ route('product-detail.show',$row->product_slug) }}"> {{ $row->product_name }}
                                                            </a> </div>
                                                        <div class="rating">
                                                            <div class="ratings">
                                                                <div class="rating-box">
                                                                    <div class="rating width80"></div>
                                                                </div>
                                                                <p class="rating-links"> <a href="#">1
                                                                        Review(s)</a> <span
                                                                        class="separator">|</span> <a
                                                                        href="#">Add Review</a> </p>
                                                            </div>
                                                        </div>
                                                        <div class="item-content">
                                                            <div class="item-price">
                                                                <div class="price-box"> <span
                                                                        class="regular-price">
                                                                        <span
                                                                            class="price">
                                                                            @if($row->product_price_sale != 0)
                                                                            {{number_format($row->product_price_sale)}} vnđ
                                                                            @else
                                                                            {{number_format($row->product_price)}} vnđ
                                                                            @endif
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="action">
                                                                <button class="button btn-cart add_cart" type="button"
                                                                    title="" data-id_pro="{{ $row->product_id }}"
                                                                    data-original-title="Add to Cart"><span>Add
                                                                        to Cart</span> </button>
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
                </div>
                <div class="featured-pro-block">
                    <div class="slider-items-products">
                        <div class="new-arrivals-block">
                            <div class="block-title">
                                <h2>Featured Product</h2>
                            </div>
                            <div id="new-arrivals-slider" class="product-flexslider hidden-buttons">
                                <div class="home-block-inner"> </div>
                                <div class="slider-items slider-width-col4 products-grid block-content">
                                    @foreach ($featured_product as $item)
                                    <div class="item">
                                        <div class="item-inner">
                                            <div class="item-img">
                                                <div class="item-img-info">
                                                    <a class="product-image" title="Retis lapen casen"
                                                        href="{{ route('product-detail.show',$item->product_slug) }}"> <img alt="Retis lapen casen" width="194px" height="194px"
                                                            src="{{ asset('uploads/product/'.$item->product_image) }}">
                                                    </a>
                                                    @if ($item->product_price_sale != 0)
                                                    <div class="sale-label sale-top-left">Sale
                                                    </div>
                                                    @endif
                                                    @if (Carbon\Carbon::parse($item->created_at)->format('Y/m/d') >= $startOfWeek  &&  Carbon\Carbon::parse($item->created_at)->format('Y/m/d') <= $endOfWeek )
                                                    <div class="new-label new-top-right">New
                                                    </div>
                                                    @endif
                                                    <div class="box-hover">
                                                        <ul class="add-to-links">
                                                            <li>
                                                                <a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                                        data-target="#quickview_product{{ $item->product_id }}"></a>
                                                            </li>
                                                            <li>
                                                                @if (Auth::user())
                                                                @php
                                                                    $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$item->product_id)->first();
                                                                @endphp
                                                                    @if ($check_wish)
                                                                    <a class="link-wishlist add_Wishlist wishcolor"
                                                                    id="{{ $item->product_id }}"></a>
                                                                    @else
                                                                    <a class="link-wishlist add_Wishlist"
                                                                    id="{{ $item->product_id }}"></a>
                                                                    @endif
                                                                @else
                                                                <a class="link-wishlist"
                                                                    href="{{ route('login.index') }}"></a>
                                                                @endif
                                                            </li>
                                                            <li>
                                                                <a class="link-compare add_compare" data-compare_id="{{ $item->product_id }}"></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-info">
                                                <div class="info-inner">
                                                    <div class="item-title"> <a title="Retis lapen casen"
                                                            href="{{ route('product-detail.show',$item->product_slug) }}">{{$item->product_name}} </a>
                                                    </div>
                                                    <div class="rating">
                                                        <div class="ratings">
                                                            <div class="rating-box">
                                                                <div class="rating width80"></div>
                                                            </div>
                                                            <p class="rating-links"> <a href="#">1
                                                                    Review(s)</a> <span
                                                                    class="separator">|</span> <a
                                                                    href="#">Add Review</a> </p>
                                                        </div>
                                                    </div>
                                                    <div class="item-content">
                                                        <div class="item-price">
                                                            <div class="price-box"> <span
                                                                    class="regular-price">
                                                                    <span
                                                                        class="price">
                                                                        @if($item->product_price_sale != 0)
                                                                        {{number_format($item->product_price_sale)}} vnđ
                                                                        @else
                                                                        {{number_format($item->product_price)}} vnđ
                                                                        @endif
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="action">
                                                            <button class="button btn-cart add_cart" type="button"
                                                                title="" data-id_pro="{{ $item->product_id }}"
                                                                data-original-title="Add to Cart"><span>Add to
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
            </div>
            <aside class="col-left sidebar col-md-3 col-sm-4 col-xs-12 col-sm-pull-8 col-md-pull-9">
                <div class="custom-slider-wrap">
                    <div class="custom-slider-inner">
                        <div class="home-custom-slider">
                            <div>
                                <div id="carousel-example-generic" class="carousel slide"
                                    data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li class="active" data-target="#carousel-example-generic"
                                            data-slide-to="0"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                    <div class="item active"> 
    <img src="{{ asset('frontend/images/hotsale1.jpg') }}" alt="slide3">
    <div class="carousel-caption"> 
        <span>Ưu đãi lớn</span>
        <p>Giảm giá lên đến <strong>20% OFF</strong> cho Nội thất bếp</p>
    </div>
</div>
<div class="item"> 
    <img src="{{ asset('frontend/images/hotsale2.jpg') }}" alt="slide2">
    <div class="carousel-caption"> 
        <span>Giảm giá <strong>sốc</strong></span>
        <p>Giảm giá lên đến <strong>40% OFF</strong> cho Nội thất văn phòng</p>
    </div>
</div>
<div class="item"> 
    <img src="{{ asset('frontend/images/hotsale1.jpg') }}" alt="slide1">
    <div class="carousel-caption"> 
        <span>Sự kiện <strong>ưu đãi</strong></span>
        <p>Giảm giá lên đến <strong>50% OFF</strong> cho Nội thất phòng khách</p>
    </div>
</div>
<a class="left carousel-control" href="#" data-slide="prev"> 
    <span class="sr-only">Previous</span> 
</a>
<a class="right carousel-control" href="#" data-slide="next"> 
    <span class="sr-only">Next</span> 
</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hot-deal">
                    <ul class="products-grid">
                        <li class="right-space two-height item">
                            <div class="item-inner">
                                @foreach ($hotdeal as $item)
                                @if (Carbon\Carbon::parse($item->updated_at)->format('Y/m/d') > Carbon\Carbon::now()->format('Y/m/d'))
                                <div class="item-img">
                                    <div class="item-img-info">
                                        <a href="{{ route('product-detail.show',$item->product_slug) }}" title="Retis lapen casen" class="product-image">
                                            <img src="{{ asset('uploads/product/'.$item->product_image) }}"
                                                alt="Retis lapen casen" width="260.5px" height="260.5px">
                                        </a>
                                        <div class="hot-label hot-top-left">Hot Deal</div>
                                        <div class="box-hover">
                                            <ul class="add-to-links">
                                                <li>
                                                    <a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                                        data-target="#quickview_product{{ $item->product_id }}"></a>
                                                </li>
                                                <li>
                                                    @if (Auth::user())
                                                    @php
                                                        $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$item->product_id)->first();
                                                    @endphp
                                                        @if ($check_wish)
                                                        <a class="link-wishlist add_Wishlist wishcolor"
                                                        id="{{ $item->product_id }}"></a>
                                                        @else
                                                        <a class="link-wishlist add_Wishlist"
                                                        id="{{ $item->product_id }}"></a>
                                                        @endif
                                                    @else
                                                    <a class="link-wishlist"
                                                        href="{{ route('login.index') }}"></a>
                                                    @endif
                                                </li>
                                                <li>
                                                    <a class="link-compare add_compare" data-compare_id="{{ $item->product_id }}"></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="box-timer">
                                            <div class="timer-grid countbox_1" data-time="{{ $item->updated_at }}"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-info">
                                    <div class="info-inner">
                                        <div class="item-title"> <a href="{{ route('product-detail.show',$item->product_slug) }}"
                                                title="Retis lapen casen"> {{ $item->product_name }} </a> </div>
                                        <div class="item-content">
                                            <div class="rating">
                                                <div class="ratings">
                                                    <div class="rating-box">
                                                        <div class="rating width80"></div>
                                                    </div>
                                                    <p class="rating-links"> <a href="#">1 Review(s)</a>
                                                        <span class="separator">|</span> <a href="#">Add
                                                            Review</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="item-price">
                                                <div class="price-box">
                                                    <span class="regular-price">
                                                        <span class="price">{{ number_format($item->product_price_sale)}} vnđ</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="action">
                                                <button data-original-title="Add to Cart" title="" type="button" data-id_pro="{{ $item->product_id }}"
                                                    class="button btn-cart add_cart"><span>Add to Cart</span> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="testimonials">
                    <div class="ts-testimonial-widget">
                        <div class="slider-items-products">
                            <div id="testimonials-slider"
                                class="product-flexslider hidden-buttons home-testimonials">
                                <div class="slider-items slider-width-col4 fadeInUp">
                                    <div class="holder">
                                        <div class="thumb"> <img
                                                src="{{ asset('frontend/images/member1.jpg') }}"
                                                alt="testimonials img" width="100px" height="100px"> </div>
                                                <p>Wow, tôi không thể không khen ngợi shop nội thất này! Tôi đã có một trải nghiệm mua sắm tuyệt vời tại đây. Sự đa dạng và phong cách của các sản phẩm thật sự ấn tượng. Chất liệu cao cấp và thiết kế tinh tế khiến mỗi món đồ nội thất trở nên độc đáo và sang trọng.</p>
<div class="line"></div>
<strong class="name">Minh Tâm</strong>
</div>
<div class="holder">
    <div class="thumb"> <img src="{{ asset('frontend/images/member2.jpg') }}" alt="Hình ảnh khách hàng"> </div>
    <p>Nhân viên rất tận tâm và nhiệt tình, họ đã giúp tôi chọn những món đồ nội thất phù hợp với phong cách trang trí nhà của mình. Đặc biệt, dịch vụ giao hàng nhanh chóng và đáng tin cậy.</p>
    <div class="line"></div>
    <strong class="name">Mai Linh</strong>
</div>
<div class="holder">
    <div class="thumb"> <img src="{{ asset('frontend/images/member3.jpg') }}" alt="Hình ảnh khách hàng"> </div>
    <p>Tôi muốn chia sẻ rằng tôi đã có một trải nghiệm tuyệt vời khi mua sắm tại shop nội thất này. Các sản phẩm không chỉ đa dạng về kiểu dáng mà còn rất tinh tế. Chất liệu bền đẹp và gia công tỉ mỉ làm cho không gian sống của tôi trở nên nổi bật và ấn tượng.</p>
    <div class="line"></div>
    <strong class="name">John Doe</strong>
</div>
<div class="holder">
    <div class="thumb"> <img src="{{ asset('frontend/images/member4.jpg') }}" alt="Hình ảnh khách hàng"> </div>
    <p>Nhân viên tư vấn rất chu đáo, giúp tôi chọn lựa những món đồ nội thất phù hợp với không gian và nhu cầu của mình. Điều này thực sự giúp tôi tạo ra một không gian sống thoải mái và ấm cúng.</p>
    <div class="line"></div>
    <strong class="name">Stephen Doe</strong>
</div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="featured-add-box">
                    <div class="featured-add-inner">
                        <a href="#"> <img src="{{ asset('frontend/images/img4.jpg') }}" alt="f-img"></a>
                        <div class="banner-content">
                        <div class="banner-text">Nội Thất</div>
<div class="banner-text1">Giảm giá 49%</div>
<p>cho các sản phẩm được chọn</p>
<a href="#" class="view-bnt">Mua ngay</a>

                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- Latest Blog -->
<div class="container">
    <div class="row">
        <div class="blog-outer-container">
            <div class="block-title">
                <h2>Bài viết</h2>
            </div>
            <div class="blog-inner">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="entry-thumb image-hover2">
                        <a href="https://tinhome.vn/thiet-ke-noi-that-biet-thu/"> <img alt="Blog"
                                src="{{ asset('frontend/images/img5.jpg') }}" width="550px" height="255.46px"> </a>
                    </div>
                    <div class="blog-preview_info">
                    <h4 class="blog-preview_title"><a href="https://tinhome.vn/thiet-ke-noi-that-biet-thu/">Bài đăng blog về nội thất với hình ảnh</a></h4>
<ul class="post-meta">
    <li><i class="fa fa-user"></i>được đăng bởi <a href="#">admin</a></li>
    <li><i class="fa fa-comments"></i><a href="#">8 nhận xét</a></li>
    <li><i class="fa fa-clock-o"></i><span class="day">12</span> <span class="tháng">Tháng Hai</span></li>
</ul>
<div class="blog-preview_desc">Nội thất chất lượng cao không chỉ mang lại sự thoải mái mà còn thể hiện phong cách cá nhân của bạn. Khám phá các thiết kế và xu hướng mới nhất trong bài viết này.</div>
<a class="blog-preview_btn" href="https://tinhome.vn/thiet-ke-noi-that-biet-thu/">ĐỌC THÊM</a>

                     </div>
                 </div>
                 <div class="col-lg-6 col-md-6 col-sm-6">
    <div class="entry-thumb image-hover2">
        <a href="https://tinhome.vn/thiet-ke-noi-that-biet-thu/"> <img alt="Blog về nội thất"
        src="{{ asset('frontend/images/img6.jpg') }}" width="550px" height="255.46px"> </a>
    </div>
    <div class="blog-preview_info">
        <h4 class="blog-preview_title"><a href="https://tinhome.vn/thiet-ke-noi-that-biet-thu/">Khám phá xu hướng nội thất mới nhất</a></h4>
        <ul class="post-meta">
            <li><i class="fa fa-user"></i>được đăng bởi <a href="#">admin</a></li>
            <li><i class="fa fa-comments"></i><a href="#">4 nhận xét</a></li>
            <li><i class="fa fa-clock-o"></i><span class="day">25</span> <span class="tháng">Tháng 1</span></li>
        </ul>
        <div class="blog-preview_desc">Khám phá các xu hướng thiết kế nội thất hiện đại, từ chất liệu cho đến kiểu dáng, mang lại sự tiện nghi và phong cách cho ngôi nhà của bạn. Bài viết sẽ giúp bạn cập nhật các ý tưởng mới mẻ và độc đáo.</div>
        <a class="blog-preview_btn" href="https://tinhome.vn/thiet-ke-noi-that-biet-thu/">ĐỌC THÊM</a>
    </div>
</div>

            </div>
        </div>
    </div>
</div>
<!-- End Latest Blog -->

@endsection
