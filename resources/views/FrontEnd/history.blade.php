@extends('Layout_user')
@section('title')
    History Order
@endsection
@section('content')
    <div class="main-container col2-left-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12 col-sm-push-4 col-md-push-3">
                    <article class="col-main">
                        <div class="my-account">
                            <div class="page-title">
                                <h2>History</h2>
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
                                                    <th class="customer-wishlist-item-price" style="text-align: center;">Reviews</th>
                                                </tr>
                                            </thead>
                                            <tbody id="loadhistory">

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
    <div class="modal fade bd-example-modal-lg" id="review_order" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 0px !important;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="write_form">
                        <div class="col-sm-12 col-xs-12">
                            <article class="col-main">
                                <div class="product-view">
                                    <div class="product-essential">
                                        <input type="hidden" id="hidden_id" value="">
                                        <input type="hidden" id="hidden_id_order" value="">
                                        <input type="hidden" id="hidden_pro_id" value="">
                                        <input type="hidden" id="hidden_star_id" name="star_count">
                                        <div class="product-img-box col-lg-4 col-sm-5 col-xs-12">
                                            <div class="product-image">
                                                <div class="product-full" id="show_image">

                                                </div>
                                            </div>
                                            <!-- end: more-images -->
                                        </div>
                                        <div class="product-shop col-lg-8 col-sm-7 col-xs-12">
                                            <div class="product-name">
                                                <h1 id="history_name"></h1>
                                            </div>
                                            <div class="ratings">
                                                <p class="rating-links"> <a href="#">Đánh giá: </a>
                                                </p>
                                                <div class='starrr' id='star1'></div>
                                            </div>
                                            <div class="short-description">
                                                <h2>Quick Description</h2>
                                                <span style="text-align: justify;" id="history_desc"></span>
                                            </div>
                                            <div>
                                                <textarea rows="5" id="txt_review" name="txt_review" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" style="margin-top: 2%;margin-right: 2%;" class="btn btn-success">Submit</button>
                            {{--  <button type="button" style="margin-top: 2%;" class="btn btn-secondary" data-dismiss="modal">Close</button>  --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('frontend/dist/starrr.css') }}">
@endsection
@section('js')
<script src="{{ asset('frontend/dist/starrr.js') }}"></script>
<script src="//cdn.ckeditor.com/4.16.2/basic/ckeditor.js"></script>
<script>
    function loadHistory(){
        $.ajax({
            type: 'get',
            url: '{{ route('history.index') }}',
            dataType: 'json',
            success:function(response){
                $('#loadhistory').html(response.data);
            }
        });
    }
    $(document).ready(function(){
        CKEDITOR.config.autoParagraph = false;
        CKEDITOR.replace('txt_review');
        // Load History
        loadHistory();
        // Change Star
        $('#star1').starrr({
            change: function(e, value){
              if (value) {
                  $('.your-choice-was').show();
                  $('.choice').text(value);
                  $('#hidden_star_id').val(value);
              } else {
                  $('.your-choice-was').hide();
              }
            }
          });
        // Show Review
        $(document).on('click','.show-review',function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var id_order = $(this).data('id_order');

            $('#review_order').modal('show');
            $('#text_review').val('');
            $('#hidden_star_id').val('');

            $.ajax({
                type: 'get',
                url: 'history/'+id,
                dataType: 'json',
                success:function(response){
                    if (response.status == 200) {
                        $('#hidden_id').val(id);
                        $('#hidden_id_order').val(id_order);
                        $('#hidden_pro_id').val(response.data.product_id);
                        $('#show_image').html('\
                            <img id="product-zoom" src="uploads/product/'+response.data.product_image+'"  data-zoom-image="uploads/product/'+response.data.product_image+'" alt="'+response.data.product_name+'" style="width:284px;height:423px">');
                        $('#history_desc').html('<span>'+response.desc+'</span>');
                        $('#history_name').text(response.data.product_name);
                    }else{
                        toastr.error(response.message, 'Notification',{timeOut: 7000});
                    }
                }
            });
        });
        // Add Review
        $(document).on('submit','#write_form',function(e){
            e.preventDefault();
            var id_pro = $('#hidden_pro_id').val();
            var id_order = $('#hidden_id').val();
            var text_review = $('#txt_review').val();
            var star_count = $('#hidden_star_id').val();

            $.ajax({
                type: 'post',
                url: '{{ route('history.store') }}',
                data: {
                    id_pro:id_pro,
                    id_order:id_order,
                    text_review:text_review,
                    star_count:star_count
                },
                success:function(response){
                    if (response.status == 200) {
                        loadHistory();
                        $('#review_order').modal('hide');
                        setTimeout(function(){
                            toastr.success(response.message,'Notification');
                        }, 2000);
                    }else{
                        $.each(response.errors, function(key, err_values){
                                toastr.error(err_values, 'Notification',{timeOut: 7000});
                        });
                        $('#hidden_star_id').val('');
                    }
                }
            });
        });
    });
</script>
@endsection
