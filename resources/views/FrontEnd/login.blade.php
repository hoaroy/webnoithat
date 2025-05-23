@extends('Layout_user')
@section('title')
  Login
@endsection
@section('content')
<!-- Main Container -->
<div class="main-container col1-layout">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <article class="col-main">
          <div class="account-login">
            <div class="page-title">
            <h2>Đăng nhập hoặc tạo tài khoản</h2>
             </div>
             <fieldset class="col2-set">
               <div class="col-1 new-users"><strong>Khách hàng mới</strong>
                 <div class="content">
                   <p>Bằng cách tạo tài khoản với cửa hàng của chúng tôi, bạn sẽ có thể thực hiện quy trình thanh toán nhanh hơn, lưu trữ nhiều địa chỉ giao hàng, xem và theo dõi đơn đặt hàng trong tài khoản của mình, v.v.</p>
                   <div class="buttons-set">
                     <button onclick="window.location='{{ route('login.create') }}';" class="button create-account" type="button"><span>Tạo tài khoản</span></button>
                   </div>
                 </div>
               </div>
               <div class="col-2 register-users"><strong>Khách hàng đăng nhập</strong>
                 <form action="{{ route('login.store') }}" method="post">
                 @csrf
                     <div class="content">
                     <p>Nếu bạn có tài khoản với chúng tôi, vui lòng đăng nhập.</p>
                     <ul class="form-list">
                         <li>
                         <label for="email">Địa chỉ Email <span class="required">*</span></label>
                         <input type="text" title="Email Address" class="input-text required-entry" id="email" value="{{old('email_login')}}" name="email_login">
                         </li>
                         <li>
                         <label for="pass">Mật khẩu <span class="required">*</span></label>
                         <input type="password" title="Password" id="pass" class="input-text required-entry-valid-password" name="password_login">
                         </li>
                     </ul>
                     {{-- <p class="required">* Trường bắt buộc</p> --}}
                     <div class="buttons-set">
                         <button id="send2" name="send" type="submit" class="button login"><span>Đăng nhập</span></button>
                         <a class="forgot-word" href="#">Quên mật khẩu?</a> </div>
                     </div>
                 </form>
              </div>
            </fieldset>
          </div>
        </article>
        <!--	///*///======    End article  ========= //*/// -->
      </div>
    </div>
  </div>
</div>
<!-- Main Container End -->
@endsection
