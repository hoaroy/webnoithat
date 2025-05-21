@extends('Layout_user')
@section('title')
    Compare
@endsection
@section('content')
    <section class="main-container col1-layout">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="cart">
                        <div class="page-title">
                            <h2>Compare Products</h2>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped compare-table">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col class="width50">
                                    <col class="width50">
                                </colgroup>
                                @if (Session::get('compare'))
                                <tbody>
                                    <tr class="product-shop-row first odd">
                                        <th>&nbsp;</th>
                                        @foreach(Session::get('compare') as $com)
                                        @php
                                            $product_compare = App\Products::where('product_id',$com['id_pro'])->get();
                                        @endphp
                                        @foreach ($product_compare as $compe)
                                        <td>
                                            <a href="{{ route('wishlist.show',$compe->product_id) }}" class="btn btn-cancel" title="Remove This Item">
                                                <i class="fa fa-remove"></i>
                                            </a>
                                            <a class="product-image" href="{{ route('product-detail.show',$compe->product_slug) }}" title="Azrouel Dress">
                                                <img src="{{ asset('uploads/product/'.$compe->product_image) }}"
                                                alt="{{ $compe->product_name }}" width="200px" height="200px">
                                            </a>
                                            <h2 class="product-name"><a href="{{ route('product-detail.show',$compe->product_slug) }}" title="{{ $compe->product_name }}">{{ $compe->product_name }}</a>
                                            </h2>
                                            <div class="price-box">
                                                @if ($compe->product_price_sale != 0)
                                                <p class="special-price"> <span class="price"> {{ number_format($compe->product_price_sale) }} vnđ</span> </p>
                                                <p class="old-price"> <span class="price-sep">-</span> <span
                                                        class="price"> {{ number_format($compe->product_price) }} vnđ</span> </p>
                                                @else
                                                <p class="special-price"> <span class="price"> {{ number_format($compe->product_price) }} vnđ</span> </p>
                                                @endif
                                            </div>
                                            <p>
                                                <button type="button" title="Add to Cart" class="button add_cart" data-id_pro="{{ $compe->product_id }}"><span><span>Thêm giỏ hàng</span></span></button>
                                            </p>
                                            @if (Auth::user())
                                            @php
                                                $check_wish = App\Wishlist::where('user_id',Auth::id())->where('pro_id',$compe->product_id)->first();
                                            @endphp
                                                @if ($check_wish)
                                                <a class="button wishlist add_Wishlist wishcolor"
                                                id="{{ $compe->product_id }}">Thêm vào danh sách yêu thích</a>
                                                @else
                                                <a class="button wishlist add_Wishlist"
                                                id="{{ $compe->product_id }}">Thêm vào danh sách yêu thích</a>
                                                @endif
                                            @else
                                            <a class="button wishlist"
                                                href="{{ route('login.index') }}">Thêm vào danh sách yêu thích</a>
                                            @endif
                                        </td>
                                        @endforeach
                                        @endforeach
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr class="even">
                                        <th>Description</th>
                                        @foreach(Session::get('compare') as $com)
                                        @php
                                            $product_compare = App\Products::where('product_id',$com['id_pro'])->get();
                                        @endphp
                                        @foreach ($product_compare as $compe)
                                        <td>
                                            <div style="text-align: justify;">{!! $compe->product_desc !!}</div>
                                        </td>
                                        @endforeach
                                        @endforeach
                                    </tr>
                                </tbody>
                                @else
                                <h3 style="text-align: center;
                                margin-top: 15%;
                                color: #c2c2c2;">Product Not Found</h3>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!--	///*///======    End article  ========= //*/// -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
@endsection
