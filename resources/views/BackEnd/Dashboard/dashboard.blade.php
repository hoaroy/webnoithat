@extends('Layout_admin')
@section('title')
  Dashboard
@endsection
@section('content')

<div class="wrapper wrapper-content">
   <div class="row">
      <div class="col-lg-3">
         <div class="ibox ">
            <div class="ibox-title">
            <span class="label label-success float-right">Hàng tháng</span>
                <h5>Xem sản phẩm</h5>
            </div>
            <div class="ibox-content">
               <h1 class="no-margins">{{$sum_view}}</h1>
               <small>Total view</small>
            </div>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="ibox ">
            <div class="ibox-title">
               <h5>Wishlist</h5>
            </div>
            <div class="ibox-content">
               <h1 class="no-margins">{{$wishlist_count}}</h1>
               {{-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div> --}}
               <small>Danh sách yêu thích mới</small>
            </div>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="ibox ">
            <div class="ibox-title">
               <span class="label label-info float-right">New</span>
               <h5>Đơn đặt hàng đã được phê duyệt</h5>
            </div>
            <div class="ibox-content">
               <h1 class="no-margins">{{ $dh_status }}/{{ $dh_status_1 }}</h1>
               <div class="stat-percent font-bold text-info">
   {{--                {{ round($dh_status/$dh_status_1*100,0) }}
                  @if (round($dh_status/$dh_status_1*100,0) > 50)
                     <i class="fa fa-level-up"></i>
                  @else
                     <i class="fa fa-level-down"></i>
                  @endif --}}
               </div>

               <small>orders</small>
            </div>
         </div>
      </div>
      <div class="col-lg-3">
         <div class="ibox ">
            <div class="ibox-title">
               @if (round((Session::get('sum_online')/$user_count)*100,0) < 20)
                  <span class="label label-danger float-right">Today</span>
               @elseif(round((Session::get('sum_online')/$user_count)*100,0) < 50)
                  <span class="label label-warning float-right">Today</span>
               @else
                  <span class="label label-primary  float-right">Today</span>
               @endif
               <h5>User Online</h5>
            </div>
            <div class="ibox-content">
               <h1 class="no-margins" id="total_online"></h1>
               <div class="totaluser">
                  <div class="stat-percent font-bold text-danger">
                     {{ round((Session::get('sum_online')/$user_count)*100,0) }}
                     @if (round((Session::get('sum_online')/$user_count)*100,0) < 50)
                        <i class="fa fa-level-down"></i>
                     @else
                        <i class="fa fa-level-up"></i>
                     @endif
                  </div>
               </div>
               <small>Trong tháng đầu tiên</small>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <div class="ibox ">
            <div class="ibox-title">
               <h5>Orders</h5>
               <div class="float-right">
                  <div class="btn-group">
                   
                  </div>
               </div>
            </div>
            <div class="ibox-content">
               <div class="row">
                  <div class="col-lg-9">
                     <div class="flot-chart">
                        <div class="flot-chart-content" id="chart"></div>
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <ul class="stat-list">
                        <li>
                           <h2 class="no-margins">{{ number_format($tn_sales) }}</h2>
                           <small>Tổng số đơn đặt hàng trong doanh số</small>
                        
                        </li>
                       
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <div class="row">
            <div class="col-lg-6">
               <div class="ibox ">
                  <div class="ibox-title">
                  <h5>Người dùng trực tuyến gần đây</h5>
                     <div class="ibox-tools">
                        <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                        <i class="fa fa-times"></i>
                        </a>
                     </div>
                  </div>
                  <div class="ibox-content table-responsive" >
                     <table class="table table-hover no-margins">
                        <thead>
                           <tr>
                              <th>Status</th>
                              <th>Date</th>
                              <th>User</th>
                           </tr>
                        </thead>
                        <tbody id="auto_refresh_user_status">

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="col-lg-6">
               <div class="ibox ">
                  <div class="ibox-title">
                     <h5>Statistical</h5>
                     <div class="ibox-tools">
                        <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                        <i class="fa fa-times"></i>
                        </a>
                     </div>
                  </div>
                  <div class="ibox-content">
                     <div id="donut-chart"></div>
                  </div>
               </div>
            </div>
         </div>

      </div>
   </div>
</div>

@endsection

@section('script')

   <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <!-- Flot -->
    <script src="{{asset('backend/js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('backend/js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{asset('backend/js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('backend/js/plugins/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('backend/js/plugins/flot/jquery.flot.symbol.js')}}"></script>
    <script src="{{asset('backend/js/plugins/flot/curvedLines.js')}}"></script>

    <!-- Peity -->
    <script src="{{asset('backend/js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('backend/js/demo/peity-demo.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('backend/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Jvectormap -->
    <script src="{{asset('backend/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{asset('backend/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{asset('backend/js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{asset('backend/js/plugins/chartJs/Chart.min.js')}}"></script>

   <script>
   $(document).ready(function() {


      chart40daysorder()
      var colorDanger = "#FF1744";
         Morris.Donut({
           element: 'donut-chart',
           resize: true,
           colors: [
             '#9c27b0',
             '#2ca8ff',
             '#18ce0f',
             '#ffeb3b',
             '#f44336',
             '#e91e63'

           ],

           data: [
             {label:"Products", value:<?php echo $sp_count ?>},
             {label:"Order", value:<?php echo $dh_count ?>},
             {label:"Customer", value:<?php echo $kh_count ?>},
             {label:"Category", value:<?php echo $dm_count ?>},
             {label:"Brand", value:<?php echo $th_count ?>},
             {label:"Slider", value:<?php echo $sl_count ?>}
           ]
      });
      var chart = new Morris.Bar({

         element: 'chart',
         parseTime: false,
         hideHover:'auto',
         barColors: ['#17a084', '#1ab394', '#1C84C6', '#e74a3b'],

         xkey: 'period',
         ykeys: ['order', 'sales', 'profit', 'quantity'],
         labels: ['Order', 'Sales', 'Profit', 'Quantity']
      });
      function chart40daysorder(){

          $.ajax({
              url:"{{route('dashboard.store')}}",
              method: "POST",
              dataType: "JSON",
              success:function(data){
                  chart.setData(data);
              }
          });
      }

      $('.dashboard-filter').change(function(){
          var dashboard_value = $(this).val();
          // alert(dashboard_value);
          $.ajax({
              url:"{{route('dashboard.store')}}",
              method: "POST",
              dataType: "JSON",
              data: {dashboard_value:dashboard_value},
              success:function(data){
                  chart.setData(data);
              }
          });

      });

      $('#btn-dashboard').click(function(){
        var from_date = $('#form_date').val();
        var to_date = $('#to_date').val();

          $.ajax({
              url:"{{route('dashboard.store')}}",
              method: "POST",
              dataType: "JSON",
              data: {from_date:from_date, to_date:to_date},

              success:function(data){
                  chart.setData(data);
              }
          });
      });

      // auto refresh
      setInterval(function() {
         $.ajax({
            url : '{{route('store.table')}}',
            method: 'POST',
            success:function(data){
               $('#auto_refresh_user_status').html(data.data);
               $('#total_online').text(data.total);
            }
         });

      }, 1000);

      setInterval(function() {
         $.ajax({
            url : '{{route('store.total')}}',
            method: 'POST',
            success:function(data){
               $('.totaluser').html(data);
            }
         });

      }, 1000);


     });
    </script>

@endsection
