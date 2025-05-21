@extends('Layout_user')
@section('title')
    Shopping Cart
@endsection
@section('content')
    <div class="main-container col1-layout">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <article class="col-main">
                        <div class="cart">
                            <div class="page-title">
                                <h2>Giỏ hàng</h2>
                            </div>
                            <div class="table-responsive">
                                <form method="post" action="#updatePost/">
                                    <input type="hidden" value="Vwww7itR3zQFe86m" name="form_key">
                                    <fieldset>
                                        <table class="data-table cart-table" id="shopping-cart-table">
                                            <colgroup>
                                                <col>
                                                <col>
                                                <col>
                                                <col>
                                                <col>
                                                <col>
                                                <col>
                                            </colgroup>
                                            <thead>
                                                <tr class="first last">
                                                <th rowspan="1">&nbsp;</th>
                                                     <th rowspan="1"><span class="nobr">Tên sản phẩm</span></th>
                                                     <th rowspan="1"></th>
                                                     <th colspan="1" class="a-center"><span class="nobr">Đơn vị
                                                             Giá</span></th>
                                                     <th class="a-center" rowspan="1">Số lượng</th>
                                                     <th colspan="1" class="a-center">Tổng phụ</th>
                                                    <th class="a-center" rowspan="1">&nbsp;</th>
                                                </tr>
                                            </thead>

                                            <tbody id="loadShoppingcart">

                                            </tbody>
                                            <tfoot>
                                                <tr class="first last">
                                                    <td class="a-right last" colspan="7">
                                                        <button onclick="back()" class="button btn-continue"
                                                            title="Continue Shopping" type="button">
                                                            <span>Tiếp tục mua sắm</span>
                                                        </button>
                                                        <span id="delButtonall">

                                                        </span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </fieldset>
                                </form>
                            </div>
                            <!-- BEGIN CART COLLATERALS -->
                            <div class="cart-collaterals row">
                                <div class="col-sm-4">
                                    <div class="discount">
                                    <h3>Mã Giảm Giá</h3>
                                        <form method="post" action="{{ route('cart.store') }}" id="discount-coupon-form">
                                            <label for="coupon_code">Nhập mã phiếu giảm giá của bạn nếu bạn có.</label>
                                            @if (Session::get('coupon'))
                                                @foreach (Session::get('coupon') as $cou)
                                                <input type="text" value="{{ $cou['coupon_code'] }}" name="coupon_code" id="coupon_code"
                                                class="input-text fullwidth" disabled>
                                                @endforeach
                                            @else
                                            <input type="text" value="" name="coupon_code" id="coupon_code"
                                                class="input-text fullwidth">
                                            @endif

                                            <button value="Apply Coupon"
                                                class="button coupon dscoupon" {{ Session::get('coupon') ? 'disabled' : '' }} title="Apply Coupon" type="submit"><span>Apply
                                                    Coupon</span></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="totals col-sm-4">
                                <h3>Tổng số giỏ hàng</h3>
                                    <div class="inner">
                                        <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                            <colgroup>
                                                <col>
                                                <col>
                                            </colgroup>
                                            <tbody id="cartTotal">

                                            </tbody>
                                        </table>
                                        <ul class="checkout">
                                            <li>

                                                <button  class="button btn-proceed-checkout" title="Proceed to Checkout"
                                                    type="button">
                                                    @if(Auth::user())
                                                    <a style="color: #fff;text-decoration: none;" href="{{ route('cart-address.index') }}">
                                                    <span>Tiến hành Thanh toán</span>
                                                    </a>
                                                    @else
                                                    <a style="color: #fff;text-decoration: none;" href="{{ route('login.index') }}">
                                                    <span>Tiến hành Thanh toán</span>
                                                    </a>
                                                    @endif
                                                </button>
                                            </li>

                                            <li><a title="Checkout with Multiple Addresses"
                                            href="multiple_addresses.html">Thanh toán bằng nhiều địa chỉ</a></li>

                                        </ul>
                                    </div>
                                    <!--inner-->

                                </div>
                            </div>

                            <!--cart-collaterals-->
                            <div class="crosssel">
                                <div class="new_title">
                                <h2>bạn có thể quan tâm</h2>
                                </div>
                                <div class="category-products">
                                    <ul class="products-grid">
                                        @foreach (Cart::content() as $cont)
                                            @php
                                                $interested = App\Products::where('product_id',$cont->id)->inRandomOrder()->get();
                                            @endphp
                                            @foreach($interested as $inter)
                                                @php
                                                    $product_may = App\Products::inRandomOrder()->where('product_status',1)
                                                                            ->where('category_id','LIKE', '%' . $inter->category_id . '%')
                                                                            ->take(8)->get();
                                                @endphp
                                                @foreach ($product_may as $pro_may)
                                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="item-inner">
                                                        <div class="item-img">
                                                            <div class="item-img-info">
                                                                <a class="product-image"
                                                                    title="Retis lapen casen" href="{{ route('product-detail.show',$pro_may->product_id) }}">
                                                                    <img width="267px" height="267px"
                                                                        alt="{{ $pro_may->product_name }}" src="{{ asset('uploads/product/'.$pro_may->product_image) }}">
                                                                </a>
                                                                @if ($pro_may->product_price_sale != 0)
                                                                <div class="sale-label sale-top-left">Sale
                                                                </div>
                                                                @endif
                                                                @if (Carbon\Carbon::parse($pro_may->created_at)->format('Y/m/d') >= $startOfWeek  &&  Carbon\Carbon::parse($pro_may->created_at)->format('Y/m/d') <= $endOfWeek )
                                                                <div class="new-label new-top-right">New
                                                                </div>
                                                                @endif
                                                                <div class="box-hover">
                                                                    <ul class="add-to-links">
                                                                        <li><a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                                                            data-target="#quickview_product{{ $pro_may->product_id }}"></a>
                                                                        </li>
                                                                        <li>
                                                                            @if (Auth::user())
                                                                            @php
                                                                                $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$pro_may->product_id)->first();
                                                                            @endphp
                                                                                @if ($check_wish)
                                                                                <a class="link-wishlist add_Wishlist wishcolor"
                                                                                id="{{ $pro_may->product_id }}"></a>
                                                                                @else
                                                                                <a class="link-wishlist add_Wishlist"
                                                                                id="{{ $pro_may->product_id }}"></a>
                                                                                @endif
                                                                            @else
                                                                            <a class="link-wishlist"
                                                                                href="{{ route('login.index') }}"></a>
                                                                            @endif
                                                                        </li>
                                                                        <li>
                                                                            <a class="link-compare add_compare" data-compare_id="{{ $pro_may->product_id }}"></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="item-info">
                                                            <div class="info-inner">
                                                                <div class="item-title"> <a title="{{ $pro_may->product_name }}"
                                                                        href="{{ route('product-detail.show',$pro_may->product_id) }}"> {{ $pro_may->product_name }} </a> </div>
                                                                <div class="item-content">
                                                                    <div class="rating">
                                                                        <div class="ratings">
                                                                            <div class="rating-box">
                                                                                <div class="rating width80"></div>
                                                                            </div>
                                                                            <p class="rating-links"> <a href="#">1 Đánh giá</a>
                                                                                 <span class="separator">|</span> <a
                                                                                     href="#">Thêm đánh giá</a>
                                                                             </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item-price">
                                                                        <div class="price-box">
                                                                        @if ($pro_may->product_price_sale != 0)
                                                                             <p class="giá đặc biệt"><span
                                                                                     class="price-label">Giá đặc biệt</span>
                                                                                 <span class="price"> {{ number_format($pro_may->product_price_sale) }} </span>
                                                                             </p>
                                                                             <p class="old-price"><span
                                                                                     class="price-label">Giá thông thường:</span>
                                                                                 <span class="price"> {{ number_format($pro_may->product_price) }} </span>
                                                                             </p>
                                                                             @khác
                                                                             <p class="giá đặc biệt"><span
                                                                                 class="price-label">Giá đặc biệt</span>
                                                                                 <span class="price"> {{ number_format($pro_may->product_price) }} </span>
                                                                             </p>
                                                                             @endif
                                                                         </div>
                                                                    </div>
                                                                    <div class="action">
                                                                        <button class="button btn-cart add_cart" data-id_pro="{{ $pro_may->product_id }}" type="button" title=""
                                                                            data-original-title="Add to Cart"><span>Add to
                                                                                Cart</span> </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>

            </div>
        </div>
    </div>
    <style type="text/css">
        .disable{
            display: none;
        }
    </style>
@endsection
@section('js')
<script>
    function back(){
        history.back();
    }

    setInterval(function(){
        $.ajax({
            type: 'get',
            url: '{{ route('cart.create') }}',
            success:function(response){
                if(response.status == 200){
                    $('.dscoupon').attr('disabled',false);
                    $('#coupon_code').attr('disabled',false);
                }
            }
        });
    }, 2000);
    $(document).ready(function(){
        loadShopping();
        // Add Coupon
        $(document).on('submit','#discount-coupon-form',function(e){
            e.preventDefault();
            var coupon_code = $('#coupon_code').val();
            var action = $(this).attr('action');

            $.ajax({
                type: 'post',
                url: action,
                data: {coupon_code:coupon_code},
                success:function(response){
                    if (response.message) {
                        loadShopping();
                        $('.dscoupon').attr('disabled',true);
                        $('#coupon_code').attr('disabled',true);
                        toastr.success(response.message,'Notification',{timeOut: 7000});
                    }else if(response.error_login){
                        toastr.error(response.error_login, '<a style="color: #fff" href="'+response.url+'">Click Me Go Login</a>',{timeOut: 10000});
                        $('#coupon_code').val('');
                        loadShopping();
                    }else{
                        toastr.error(response.error,'Notification',{timeOut: 7000});
                        $('#coupon_code').val('');
                        loadShopping();
                    }

                }
            });
        });
        // Update Qty
        $(document).on('change','.updateqty',function(e){
            var id_pro = $(this).data('id');
            var rowid = $(this).data('rowid');
            var qty = $(this).val();

            $.ajax({
                type: 'get',
                url: 'cart/'+rowid,
                data: {qty:qty, id_pro:id_pro},
                success:function(response){
                    if(response.status == 200){
                        toastr.success(response.message, 'Notification');
                        loadShopping();
                        loadSidebar();
                    }else{
                        toastr.error(response.message, 'Notification');
                        loadShopping();
                    }
                }
            });
        });
        // Del All Cart
        $(document).on('click','#empty_cart_button',function(e){
            $.ajax({
                type: 'post',
                url: '{{ route('cart.store') }}',
                success:function(response){
                    loadShopping();
                    loadSidebar();
                }
            });
        });
        // Del Coupon
        $(document).on('click','#empty_coupon_button',function(e){
            $.ajax({
                type: 'get',
                url: '{{ route('cart.create') }}',
                data: {action:'del'},
                success:function(response){
                    loadShopping();
                    loadSidebar();
                    $('.dscoupon').attr('disabled',false);
                    $('#coupon_code').attr('disabled',false);
                    $('#coupon_code').val('');
                }
            });
        });
    });
</script>
@endsection
