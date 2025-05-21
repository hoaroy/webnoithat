@extends('Layout_user')
@section('title')
    My Wishlist
@endsection
@section('content')
    <div class="main-container col2-left-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12 col-sm-push-4 col-md-push-3">
                    <article class="col-main">
                        <div class="my-account">
                            <div class="page-title">
                                <h2>Yêu thích</h2>
                            </div>
                            <div class="my-wishlist">
                                <div class="table-responsive">
                                    <fieldset>
                                        <input type="hidden" value="ROBdJO5tIbODPZHZ" name="form_key">
                                        <table id="wishlist-table" class="clean-table linearize-table data-table">
                                            <thead>
                                                <tr class="first last">
                                                    <th class="customer-wishlist-item-image"></th>
                                                    <th class="customer-wishlist-item-info"></th>
                                                    <th class="customer-wishlist-item-quantity">Số lượng</th>
                                                     <th class="customer-wishlist-item-price">Giá</th>
                                                    <th class="customer-wishlist-item-cart"></th>
                                                    <th class="customer-wishlist-item-remove"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="loadwish">

                                            </tbody>
                                        </table><br>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="buttons-set">
                                <p class="back-link"><a href="{{ url()->previous() }}"><small>« </small>Back</a></p>
                            </div>
                        </div>
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>
                <aside class="col-left sidebar col-md-3 col-sm-4 col-xs-12 col-sm-pull-8 col-md-pull-9">
                    <div class="side-banner"><img src="{{ asset('frontend/images/noithat.jpg') }}" alt="banner"></div>
                    <div class="block block-account">
                    <div class="block-title">Tài khoản của tôi</div>
                         <div class="block-content">
                             <ul>
                                 <li><a href="#">Trang tổng quan tài khoản</a></li>
                                 <li><a href="#">Thông tin tài khoản</a></li>
                                 <li><a href="#">Sổ địa chỉ</a></li>
                                 <li><a href="#">Đơn hàng của tôi</a></li>
                                 <li><a href="#">Thỏa thuận thanh toán</a></li>
                                 <li><a href="#">Hồ sơ định kỳ</a></li>
                                 <li><a href="#">Đánh giá sản phẩm của tôi</a></li>
                                 <li><a href="#">Thẻ của tôi</a></li>
                                 <li class="current"><a href="#">Danh sách yêu thích của tôi</a></li>

                                 <li><a href="#">Có thể tải xuống của tôi</a></li>
                                 <li class="last"><a href="#">Đăng ký nhận bản tin</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="khối khối-so sánh">
                         <div class="block-title "><span>So sánh sản phẩm (2)</span></div>
                         <div class="block-content">
                             <ol id="compare-items">
                                 <li class="item lẻ">
                                     <input type="hidden" value="2173" class="compare-item-id">
                                     <a class="btn-remove1" title="Xóa mục này" href="#"></a> <a href="#"
                                         class="product-name"> Ghế sofa có đệm bọc Polyester viền mép</a>
                                 </li>
                                 <li class="item last even">
                                     <input type="hidden" value="2174" class="so-item-id">
                                     <a class="btn-remove1" title="Xóa mục này" href="#"></a> <a href="#"
                                         class="product-name"> Ghế sofa có đệm bọc Down-Blend Edge</a>
                                 </li>
                             </ol>
                             <div class="ajax-checkout">
                                 <button type="submit" title="Gửi"
                                     class="button button-compare"><span>So sánh</span></button>
                                 <button type="submit" title="Gửi"
                                     class="button button-clear"><span>Xóa</span></button>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    function loadWishlist(){
        $.ajax({
            type: 'get',
            url: '{{ route('wishlist.index') }}',
            dataType: 'json',
            success:function(response){
                $('#loadwish').html(response.data);
            }
        });
    }
    $(document).ready(function(){
        // Load Wishlist
        loadWishlist();
        // Add Cart
        $(document).on('click','.formCart', function(e){
            e.preventDefault();
            var id_pro = $(this).data('id');
            var qtycart = $('#qty'+id_pro).val();

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
        // Del Wishlist
        $(document).on('click','.delwishlist', function(e){
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: 'post',
                url: '{{ route('wishlist.store') }}',
                data: {id:id},
                dataType: 'json',
                success:function(response){
                    loadWishlist();
                }
            });
        });
    });
</script>
@endsection
