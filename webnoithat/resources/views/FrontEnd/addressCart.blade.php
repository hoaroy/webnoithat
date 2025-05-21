@extends('Layout_user')
@section('title')
    Address Cart
@endsection
@section('content')
    <div class="main-container col2-left-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12 col-sm-push-4 col-md-push-3">
                    <div class="col-sm-12 col-xs-12">
                        <article class="col-main">
                            <div class="multiple_addresses">
                                <div class="state_bar">

                                </div>
                                <div id="address">
                                    <form action="{{ route('cart-address.store') }}" method="post" id="checkout_multishipping_form">
                                        @csrf
                                        <div class="page-title_multi">
                                           
<h2>Gửi đến Nhiều Địa Chỉ</h2>
                                        </div><br>
                                        <!--title-buttons-->
                                        <div class="addresses">
                                            <div class="table-responsive">
                                                <fieldset class="multiple-checkout shipping">
                                                    <div class="form-group form-list">
                                                        <label class="required" for="name">Họ và Tên <em>*</em></label>
                                                        <input name="checkout_name" id="checkout_name" value="{{ Auth::user()->name }}" type="text" style="width: 100%;margin-bottom: 2%;" class="input-text required-entry" required placeholder="Tên">
                                                    </div>
                                                    <div class="form-group form-list">
                                                        <label class="required" for="phone">Số Điện Thoại <em>*</em></label>
                                                        <input name="checkout_phone" id="checkout_phone" type="tel" style="width: 100%;margin-bottom: 2%;" pattern="[0-9]{10}" required class="input-text required-entry" placeholder="Điện thoại">
                                                    </div>
                                                    <div class="form-group form-list">
                                                        <label class="required" for="address">Địa Chỉ <em>*</em></label>
                                                        <input name="checkout_address" id="checkout_address" type="text" style="width: 100%;margin-bottom: 2%;" class="input-text required-entry" required placeholder="Số căn hộ">
                                                    </div>
                                                    <div class="form-group form-list">
                                                        <label class="required" for="city">Thành Phố <em>*</em></label>
                                                        <select style="width: 100%; margin-bottom: 2%;" required class="choose" id="city" name="checkout_city">
                                                            <option value="">-- Chọn --</option>
                                                            @foreach ($city as $row)
                                                            <option value="{{ $row->matp  }}">{{ $row->name_city }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-list">
                                                        <label class="required" for="district">Quận/Huyện <em>*</em></label>
                                                        <select style="width: 100%; margin-bottom: 2%;" required class="choose" id="district" name="checkout_district">
                                                            <option value="">-- Chọn --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-list">
                                                        <label class="required" for="wards">Phường/Xã <em>*</em></label>
                                                        <select style="width: 100%; margin-bottom: 2%;" required id="wards" name="checkout_wards">
                                                            <option value="">-- Chọn --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-list">
                                                        <label class="required" for="payment">Phương Thức Thanh Toán <em>*</em></label>
                                                        <select style="width: 100%; margin-bottom: 2%;" required class="choose_card" name="checkout_payment" id="checkout_payment">
                                                            <option value="">-- Chọn --</option>
                                                            <option value="COD">Thanh toán khi giao hàng</option>
                                                            <option value="ATM">Thanh toán qua thẻ</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-list paycard display">
                                                        <label class="required" for="card">Thẻ <em>*</em></label>
                                                        <select style="width: 100%; margin-bottom: 2%;" class="choose_cardpay" name="checkout_type_payment" id="checkout_type_payment">
                                                            <option value="">-- Chọn --</option>
                                                            <option value="Paypal">Paypal</option>
                                                            <option value="Vnpay">Vnpay</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-list cartvnpay display">
                                                        <label class="required" for="card">Bank <em>*</em></label>
                                                        <select style="width: 100%; margin-bottom: 2%;" class="choose_cardpay" name="checkout_bank">
                                                            <option value="">-- Choose --</option>
                                                            <option value="NCB"> Ngan hang NCB</option>
                                                            <option value="AGRIBANK"> Ngan hang Agribank</option>
                                                            <option value="SCB"> Ngan hang SCB</option>
                                                            <option value="SACOMBANK">Ngan hang SacomBank</option>
                                                            <option value="EXIMBANK"> Ngan hang EximBank</option>
                                                            <option value="MSBANK"> Ngan hang MSBANK</option>
                                                            <option value="NAMABANK"> Ngan hang NamABank</option>
                                                            <option value="VNMART"> Vi dien tu VnMart</option>
                                                            <option value="VIETINBANK">Ngan hang Vietinbank</option>
                                                            <option value="VIETCOMBANK"> Ngan hang VCB</option>
                                                            <option value="HDBANK">Ngan hang HDBank</option>
                                                            <option value="DONGABANK"> Ngan hang Dong A</option>
                                                            <option value="TPBANK"> Ngân hàng TPBank</option>
                                                            <option value="OJB"> Ngân hàng OceanBank</option>
                                                            <option value="BIDV"> Ngân hàng BIDV</option>
                                                            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                                                            <option value="VPBANK"> Ngan hang VPBank</option>
                                                            <option value="MBBANK"> Ngan hang MBBank</option>
                                                            <option value="ACB"> Ngan hang ACB</option>
                                                            <option value="OCB"> Ngan hang OCB</option>
                                                            <option value="IVB"> Ngan hang IVB</option>
                                                            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group form-list">
                                                        <label class="required" for="note">Ghi chú</label>
                                                        <textarea name="checkout_note" id="checkout_note" rows="5" style="width: 100%;margin-bottom: 2%;" class="input-text required-entry" placeholder="Ghi chú"></textarea>
                                                    </div>
                                                    <div class="buttons-set">
                                                        <a href="{{ url()->previous() }}" class="back-link"><small>« </small>Quay lại Giỏ hàng</a>
                                                        <button class="button btn-continue" title="Tiếp tục Điền thông tin Giao hàng"
                                                            type="submit"><span>Tiếp tục Điền thông tin Giao hàng</span>
                                                        </button>
                                                        <div class="btnpaypal display" style="height:33px;overflow-y: hidden; float: right;" id="paypal-button-container"></div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <!--multiple-checkout-->
                                        </div>
                                    </form>
                                </div>
                                <!--addresses-->

                            </div>
                        </article>
                        <!--	///*///======    End article  ========= //*/// -->
                    </div>
                </div>
                @php
                    $total = 0;
                    $total_sub = 0;
                    foreach(Cart::content() as $cart){
                        $total_sub += ($cart->qty)*($cart->price);
                        if(Session::get('coupon')){
                            foreach(Session::get('coupon') as $copo){
                                if($copo['coupon_condition'] == 2){
                                    $sub = $total_sub*($copo['coupon_number']/100);
                                    $total = $total_sub + ($total_sub*0.02) - $sub;
                                }else{
                                    $total = $total_sub + ($total_sub*0.02) - $copo['coupon_number'];
                                }
                            }
                        }else{
                            $total = $total_sub + ($total_sub*0.02);
                        }
                    }
                @endphp
                <aside class="col-left sidebar col-md-3 col-sm-4 col-xs-12 col-sm-pull-8 col-md-pull-9">
                    <div class="side-banner"><img src="{{ asset('frontend/images/noithat.jpg') }}" alt="banner">
                    </div>
                    <div class="block block-progress">
                        <div class="block-title">Kiểm tra lại</div>
                        <div class="block-content" id="loadAddress">

                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <style>
        .display{
            display: none !important;
        }
    </style>
@endsection
@section('js')
<script src="https://www.paypal.com/sdk/js?client-id=AU1aqbLwuw2HGSIQujQRTEMJ-m5aRTR_bKYLggDV8MOcDbR6AEdRKw8WuW5oYsGOMAWoojM-BWZNtu7Q"></script>
<script>
    setInterval(function(){
        $.ajax({
            type: 'get',
            url: '{{ route('cart-address-vnpay.create') }}',
            data: {
                checkout_name : $('#checkout_name').val(),
                checkout_phone : $('#checkout_phone').val(),
                checkout_address : $('#checkout_address').val(),
                checkout_city : $('#city').val(),
                checkout_wards : $('#wards').val(),
                checkout_district : $('#district').val(),
                checkout_payment : $('#checkout_payment').val(),
                checkout_type_payment : $('#checkout_type_payment').val(),
                checkout_note : $('#checkout_note').val(),
                checkout_code: {{ mt_rand() }}
            },
            success:function(response){
                if(response.status == 200){
                    $('#loadAddress').html(response.data);
                }
            }
        });
    }, 1000);
    paypal.Buttons({
        createOrder: function(data, actions) {
          // This function sets up the details of the transaction, including the amount and line item details.
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '{{ round($total *  0.0000441966,2) }}'
              }
            }]
          });
        },
        onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                // alert('Transaction completed by ' + details.payer.name.given_name);
                var checkout_name = $('#checkout_name').val();
                var checkout_phone = $('#checkout_phone').val();
                var checkout_address = $('#checkout_address').val();
                var checkout_city = $('#city').val();
                var checkout_wards = $('#wards').val();
                var checkout_district = $('#district').val();
                var checkout_payment = $('#checkout_payment').val();
                var checkout_type_payment = $('#checkout_type_payment').val();
                var checkout_note = $('#checkout_note').val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('cart-address.store') }}',
                    data: {
                        checkout_name:checkout_name,
                        checkout_phone:checkout_phone,
                        checkout_address:checkout_address,
                        checkout_city:checkout_city,
                        checkout_wards:checkout_wards,
                        checkout_district:checkout_district,
                        checkout_payment:checkout_payment,
                        checkout_type_payment:checkout_type_payment,
                        checkout_note:checkout_note
                    },
                    dataType: 'json',
                    success:function(response){
                        if(response.status == 200){
                            loadSidebar();
                            toastr.success(response.message, 'Notification');
                            setTimeout(function() {
                                location.replace('/');
                            }, 2000);

                        }
                    }
                });
            });
        }
    }).render('#paypal-button-container');
    $(document).ready(function(){
        // Choose City
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var result = '';

            if(action=='city'){
                result = 'district';
            }else{
                result = 'wards';
            }

            $.ajax({
                type: 'get',
                url : '{{route('cart-address.create')}}',
                data:{action:action,ma_id:ma_id},
                success:function(data){
                   $('#'+result).html(data);
                }
            });

        });

        $('.choose_card, .choose_cardpay, .btnpaypal').on('change',function(){
            var action = $(this).val();
            var action_2 = $(this).val();

            if(action == 'ATM'){
                $('.paycard').removeClass('display');
            }
            if(action == 'COD' || action == ''){
                $('.paycard').addClass('display');
                $('.cartvnpay').addClass('display');
                $('.btnpaypal').addClass('display');
                $('.btn-continue').removeClass('display');
                $('#checkout_type_payment').val('');
            }
            if(action_2 == 'Vnpay'){
                $('.cartvnpay').removeClass('display');
            }
            if(action_2 == 'Paypal'){
                $('.btn-continue').addClass('display');
                $('.btnpaypal').removeClass('display');
                $('.cartvnpay').addClass('display');
            }

        });
    });
</script>
@endsection
