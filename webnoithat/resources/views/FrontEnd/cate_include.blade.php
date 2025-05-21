<div class="toolbar">
    <div class="display-product-option">
        <div class="sorter">
            <div class="view-mode">
                <span title="Grid" class="button button-active button-grid">&nbsp;</span>
                <a href="#tablist" title="List" class="button-list">&nbsp;</a>
            </div>
        </div>
        <div class="pages">
            {!! $categoryProduct->render('FrontEnd.paginatoin') !!}
        </div>
        <div class="product-option-right">
            <div class="sort-by">
                <label class="left">Sắp xếp theo: </label>
                <ul>
                    <select style="width: 100px;height: 32px;" class="change_position">
                        <option value="">Vị trí</option>
                        <option value="name-az">Tên A-Z</option>
                        <option value="name-za">Tên Z-A</option>
                        <option value="price-az">Giá từ cao đến thấp</option>
                        <option value="price-za">Giá từ thấp đến cao</option>
                    </select>
                </ul>
                <a class="button-asc left" href="#" title="Đặt thứ tự giảm dần"><span
                        class="top_arrow"></span></a>
            </div>
            <div class="pager">
                <div class="limiter">
                    <label>Xem: </label>
                    <ul>
                        <select style="width: 50px;height: 32px;" class="change_view">
                            <option {{ $select == 8 ? 'selected' : '' }} value="8">8</option>
                            <option {{ $select == 20 ? 'selected' : '' }} value="20">20</option>
                            <option {{ $select == 25 ? 'selected' : '' }} value="25">25</option>
                            <option {{ $select == 30 ? 'selected' : '' }} value="30">30</option>
                        </select>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="category-products" id="load_view">
    @if (count($categoryProduct) > 0)
        <ul class="products-grid">
            @foreach ($categoryProduct as $cate_pro)
                <li class="item col-lg-3 col-md-4 col-sm-4 col-xs-6">
                    <div class="item-inner">
                        <div class="item-img">
                            <div class="item-img-info"><a
                                    href="{{ route('product-detail.show', $cate_pro->product_slug) }}"
                                    title="Retis lapen casen" class="product-image"><img
                                        src="{{ asset('uploads/product/' . $cate_pro->product_image) }}"
                                        width="193.88px" height="193.88px"
                                        alt="Retis lapen casen"></a>
                                @if ($cate_pro->product_price_sale != 0)
                                    <div class="sale-label sale-top-left">Sale
                                    </div>
                                @endif
                                @if (Carbon\Carbon::parse($cate_pro->created_at)->format('Y/m/d') >= $startOfWeek && Carbon\Carbon::parse($cate_pro->created_at)->format('Y/m/d') <= $endOfWeek)
                                    <div class="new-label new-top-right">New
                                    </div>
                                @endif
                                <div class="box-hover">
                                    <ul class="add-to-links">
                                        <li><a class="link-quickview" href="#" title="quick view" data-toggle="modal"
                                            data-target="#quickview_product{{ $cate_pro->product_id }}"></a>
                                        </li>
                                        <li>
                                            @if (Auth::user())
                                                @php
                                                    $check_wish = App\Wishlist::where('user_id', Auth::id())
                                                        ->where('pro_id', $cate_pro->product_id)
                                                        ->first();
                                                @endphp
                                                @if ($check_wish)
                                                    <a class="link-wishlist add_Wishlist wishcolor"
                                                        id="{{ $cate_pro->product_id }}"></a>
                                                @else
                                                    <a class="link-wishlist add_Wishlist"
                                                        id="{{ $cate_pro->product_id }}"></a>
                                                @endif
                                            @else
                                                <a class="link-wishlist"
                                                    href="{{ route('login.index') }}"></a>
                                            @endif
                                        </li>
                                        <li>
                                            <a class="link-compare add_compare"
                                                data-compare_id="{{ $cate_pro->product_id }}"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="item-info">
                            <div class="info-inner">
                                <div class="item-title"> <a title="Retis lapen casen"
                                        href="{{ route('product-detail.show', $cate_pro->product_slug) }}">
                                        {{ $cate_pro->product_name }} </a> </div>
                                <div class="item-content">
                                    <div class="rating">
                                    <div class="ratings">
                                            <div class="rating-box">
                                                <div class="rating width80"></div>
                                            </div>
                                            <p class="rating-links"> <a href="#">1 Đánh giá</a>
                                                <span class="separator">|</span> <a
                                                    href="#">Thêm
                                                    Đánh giá</a> </p>
                                        </div>
                                    </div>
                                    <div class="item-price">
                                        <div class="price-box">
                                            @if ($cate_pro->product_price_sale != 0)
                                                <p class="old-price"><span
                                                        class="price-label">Giá thường:</span> <span
                                                        class="price">{{ number_format($cate_pro->product_price) }}
                                                    </span> </p>
                                                <p class="special-price"><span
                                                        class="price-label">Giá đặc biệt</span> <span
                                                        class="price">{{ number_format($cate_pro->product_price_sale) }}</span>
                                                </p>
                                            @else
                                                <p class="special-price"><span
                                                        class="price-label">Giá đặc biệt</span> <span
                                                        class="price">{{ number_format($cate_pro->product_price) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="action">
                                        <button class="button btn-cart add_cart" type="button"
                                            title="" data-id_pro="{{ $cate_pro->product_id }}"
                                            data-original-title="Thêm vào giỏ hàng"><span>Thêm vào
                                                giỏ hàng</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <h3
            style="text-align: center; color: #eaeaea; font-weight: bold; text-shadow: 1px 1px #b3afaf, -1px -1px #cac6c6;">
            Product Not Found</h3>
    @endif
</div>
@if (count($categoryProduct) > 0)
    <div class="toolbar">
        <div class="display-product-option">
            <div class="pages">
                {!! $categoryProduct->render('FrontEnd.paginatoin') !!}
            </div>
            <div class="product-option-right">
                <div class="sort-by">
                    <label class="left">Sort By: </label>
                    <ul>
                        <select style="width: 100px;height: 32px;" class="change_position">
                        <option value="">Vị trí</option>
                            <option value="name-az">Tên A-Z</option>
                            <option value="name-za">Tên Z-A</option>
                            <option value="price-az">Giá từ cao đến thấp</option>
                            <option value="price-za">Giá từ thấp đến cao</option>
                        </select>
                    </ul>
                    <a class="button-asc left" href="#" title="Set Descending Direction"><span
                            class="top_arrow"></span></a>
                </div>
                <div class="pager">
                    <div class="limiter">
                        <label>View: </label>
                        <ul>
                            <select style="width: 50px;height: 32px;" class="change_view">
                                <option {{ $select == 8 ? 'selected' : '' }} value="8">8</option>
                                <option {{ $select == 20 ? 'selected' : '' }} value="20">20</option>
                                <option {{ $select == 25 ? 'selected' : '' }} value="25">25</option>
                                <option {{ $select == 30 ? 'selected' : '' }} value="30">30</option>
                            </select>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
