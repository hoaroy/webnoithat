@extends('Layout_admin')
@section('title')
  Product Edit
@endsection
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Orders</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Orders</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce">

        <div class="ibox-content m-b-sm border-bottom">
            <div class="row" id="data_5">
                <div class="col-sm-8 input-daterange input-group">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label" for="date_added">Date added</label>
                            <div class="input-group date">
                                <span class="input-group-addon" style="width: 20%;"><i class="fa fa-calendar"></i></span>
                                <input id="start_date" name="start_date" type="text" class="form-control" value="{{Carbon\Carbon::yesterday()->format('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" style="margin-left: 19%;">
                        <div class="form-group">
                            <label class="col-form-label" for="date_modified">Date modified</label>
                            <div class="input-group date">
                                <span class="input-group-addon" style="width: 20%;"><i class="fa fa-calendar"></i></span>
                                <input id="end_date" name="end_date" type="text" class="form-control" value="{{Carbon\Carbon::tomorrow()->format('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <label class="col-form-label" for="amount" style="color: #fff">Search</label>
                            <input type="button" class="btn btn-outline btn-primary" id="search" value="Search" style="width: 170px">
                        </div>
                        <div class="col-sm-2 col-sm-offset-2" style="margin-left: 31%;">
                            <label class="col-form-label" for="amount" style="color: #fff">Refresh</label>
                            <input type="button" class="btn btn-outline btn-success" id="refresh" value="Refresh" style="width: 170px">
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                <div class="ibox-content">
                    <form>
                    @csrf
                    <div class="table-responsive">
                        <table id="load_table" class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr style="text-transform: capitalize;">
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Code</th>
                                    <th>Payment</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr style="text-transform: capitalize;">
                                    <th><input type="checkbox" id="checkAll_footer"><button id="deleteAllcheck" class="ladda-button btn btn-danger none" data-style="expand-right">Delete</button></th>
                                    <th>Code</th>
                                    <th>Payment</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>

        {{-- View & Detail --}}
        <div class="modal inmodal" id="Modal_sample" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button style="margin-top: -5%" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <span id="image_show"></span>
                        <h4 class="modal-title"></h4>
                        <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                    </div>
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <form method="post" id="form_sub">
                        <div class="modal-body" style="background: #fff">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>Customer Information</h4>
                                    <table id="load_table" class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr style="text-transform: capitalize;">
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Payment</th>
                                                <th>Address</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vieworder_cus">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>List Order Details</h4>
                                    <input type="hidden" id="hidden_code">
                                    <table id="load_table" class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr style="text-transform: capitalize;">
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Qty Sold</th>
                                                <th>Coupon</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vieworder">

                                        </tbody>
                                        <tbody id="vieworder_2">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="change_value">
                            <div class="col-lg-12">
                                <div class="ibox-content">
                                    <div class="form-group">
                                        <select class="form-control" id="value">
                                            <option value="1">PROCESSING</option>
                                            <option value="2">BEING TRANSPORTED</option>
                                            <option class="check PAYMENT" value="3">COMPLETELY PAYMENT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" id="save" class="ladda-button btn btn-primary" data-style="expand-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Delete --}}
        <div class="modal inmodal" id="Modal_delete" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated flipInY">
                    <div class="modal-header">
                        <button style="margin-top: -10%; margin-right: -5%;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Delete</h4>
                        <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                    </div>
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <div class="modal-body">
                        <p>Are you sure delete "<span id="body"></span>"?</p>
                    </div>
                    <form method="POST" id="delete_form">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                            <button type="submit" class="ladda-button btn btn-danger" data-style="expand-right" id="del_button">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <style type="text/css">
        .save_change, .check{
            display: none;
        }
    </style>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){

        $('#data_5 .input-daterange').datepicker({
            format: 'yyyy-mm-dd',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        // Load Data Order
        fetch_data();
        function fetch_data(start_date='', end_date='')
        {
            $('#load_table').DataTable({
                destroy: true,
                processing : true,
                serverSide : true,
                pageLength: 10,
                responsive: true,
                order:[],
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'CouponFile'},
                    {extend: 'pdf', title: 'CouponFile'},

                    {extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                ajax:{
                    url: "{{ route('order.index') }}",
                    data: { start_date:start_date, end_date:end_date }
                },
                columns: [
                    {
                        data: null,
                        className: 'tdcheckbox',
                        render: function(data, type, full, meta){
                            if (data.order_status == 1) {
                                return '<input type="checkbox" name="ids" id="ids" class="checkboxclass" value="'+data.order_id +'">';
                            }else{
                                return '<input type="checkbox" disabled>';
                            }
                        },
                        orderable: false
                    },
                    {data: 'order_code'},
                    {
                        data: 'order_pay',
                        orderable: false
                    },
                    {data: 'name_order'},
                    {
                        data: null,
                        render: function(data, type, full, meta){
                            if (data.order_status == 1) {
                                return "<span class='expired tag-style'>Processing</span>";
                            }else if(data.order_status == 2){
                                return "<span class='still-term tag-style'>being transported</span>";
                            }else{
                                return "<span class='expiry tag-style'>COMPLETELY PAYMENT</span>";
                            }
                        }
                    },
                    {
                        data: 'action',
                        orderable: false
                    },
                ]
            });
        }
        // Check Submit
        $('#value').change(function(){
            $('#save').removeAttr('disabled');
        });
        // Search Date
        $('#search').click(function(){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if(start_date != '' && end_date !='')
            {
                $('#load_table').DataTable().destroy();
                fetch_data(start_date, end_date);
            }
            else
            {
                alert("Both Date is Required");
            }
        });
        // Refresh
        $('#refresh').click(function(){
            $('#order_table').DataTable().destroy();
            fetch_data();
        });
        // View
        $(document).on('click','.quickview', function(e){
            e.preventDefault();
            $('#Modal_sample').modal('show');
            $('#save').addClass('save_change');
            $('.modal-title').text('Quick View');
            $('#change_value').addClass('save_change');

            var order_code = $(this).data('order');
            var order_id = $(this).data('id');
            var action = '';

            $.ajax({
                type: "post",
                url: "{{ route('order.store') }}",
                data: {order_id:order_id,order_code:order_code,action:action},
                dataType: "json",
                success:function(response){
                    $('#vieworder').html(response.data);
                    $('#vieworder_2').html(response.data_2);
                    $('#vieworder_cus').html(response.data_3);
                }
            });
        });
        // Detail
        $(document).on('click','.detailorder', function(e){
            e.preventDefault();
            $('#Modal_sample').modal('show');
            $('.modal-title').text('Detail Order');
            $('#save').removeClass('save_change');
            $('#change_value').removeClass('save_change');
            $('#save').attr('disabled','disabled');

            var order_code = $(this).data('order');
            var order_id = $(this).data('id');
            var action = 'contenteditable';

            $.ajax({
                type: "post",
                url: "{{ route('order.store') }}",
                data: {order_id:order_id,order_code:order_code,action:action},
                dataType: "json",
                success:function(response){
                    $('#hidden_code').val(order_code);
                    $('#vieworder').html(response.data);
                    $('#vieworder_2').html(response.data_2);
                    $('#vieworder_cus').html(response.data_3);
                    $('#value').val(response.data_4);
                    $('#hidden_id').val(order_id);
                    if (response.data_4 == 2) {
                         $('.PAYMENT').removeClass('check');
                    }
                }
            });
        });
        // Change Qty
        $(document).on('blur','#qty_change',function(){
            var orderddd = $(this).data('id_order');
            var order_text = $(this).text();
            var order_id = $(this).data('id');
            var order_code = $('#hidden_code').val();

            $.ajax({
                url : '{{route('order.store')}}',
                method: 'POST',
                data:{orderddd:orderddd,order_text:order_text,order_code:order_code},
                success:function(response){
                    if (response.status == 200) {
                        setTimeout(function() {
                            toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000
                            };
                            toastr.success(response.message,'Notification');
                        }, 100);
                        $('.showSubtotal').html(response.Subtotal);
                        $('.showTotal').html(response.Total);
                    }else if (response.status == 400) {
                        $.each(response.errors, function(key, err_values){
                            toastr.error(err_values,'Notification');
                        });
                        $('#qty_change').text(response.data.order_de_qty);
                    }
                    else{
                        toastr.error(response.message,'Notification');
                        $('#qty_change').text(response.data.order_de_qty);
                    }
                }

            });
        });
        // Change Status
        $(document).on('submit','#form_sub',function(e){
            e.preventDefault();
            var value = $('#value').val();
            var id = $('#hidden_id').val();

            //lay so luong
              quantity = [];
              $("input[name='product_quantity_order']").each(function(){
                  quantity.push($(this).val());
              });

            //lay product id
              order_product_id = [];
              $("input[name='order_product_id']").each(function(){
                  order_product_id.push($(this).val());
              });

              j=0;
            for(i=0; i<order_product_id.length; i++){
                  var order_qty = $('.order_qty_' + order_product_id[i]).val();
                  var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();

                  if (parseInt(order_qty)>parseInt(order_qty_storage)) {
                      j += 1;
                      if (j==1) {
                          alert('Số lượng trong kho không đủ');
                      }
                      $('.color_qty_' + order_product_id[i]).css('color','#e74a3b').css('font-weight','bold');
                  }

            }
            if(j==0){

                $.ajax({
                    type: 'put',
                    url : 'order/'+id,
                    data: {value:value,order_product_id:order_product_id,quantity:quantity},
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            $('#load_table').DataTable().ajax.reload();
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.success(response.message,'Notification');
                                $('#Modal_sample').modal('hide');
                            }, 2000);
                        }
                    }

                });
            }
        });
        // Show Delete
        $(document).on('click','.delete', function(){
            var order_id = $(this).data('id');
            $('#Modal_delete').modal('show');

            $.ajax({
                type: "get",
                url: "order/"+order_id,
                dataType: "json",
                success:function(response){
                    if (response.status == 404) {
                        toastr.error(response.message,'Notification');
                    }else{
                        $('#hidden_id').val(order_id);
                        $('#body').html('');
                        $('#body').append(''+response.data.order_code+'');
                    }
                }
            });
        });
        // Delete
        $(document).on('submit','#delete_form', function(e){
            e.preventDefault();
            var order_id = $('#hidden_id').val();

            $.ajax({
                type: "delete",
                url: "order/"+order_id,
                dataType: "json",
                beforeSend:function(){
                    $('#del_button').attr('disabled', true);
                },
                success:function(response){
                    if (response.status == 404) {
                        toastr.error(response.message,'Notification');
                    }else{
                        $('#load_table').DataTable().ajax.reload();
                        setTimeout(function(){
                            toastr.success(response.message,'Notification');
                            $('#Modal_delete').modal('hide');
                        }, 1000);
                    }
                }
            });
        });
        // Delete All
        $(document).on('click','#deleteAllcheck', function(e){
            e.preventDefault();
            var allids = [];
            var action = 'order';
            $('input:checkbox[name=ids]:checked').each(function(){
                allids.push($(this).val());
            });

            $.ajax({
                type: 'post',
                url: '{{ route('remove.store') }}',
                data: {allids:allids,action:action},
                success:function(response){
                    if (response.status == 200) {
                        $('#load_table').DataTable().ajax.reload();
                        $('#deleteAllcheck').addClass('none');
                        $('#checkAll').removeAttr('checked');

                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                            };
                            toastr.success(response.message,'Notification');
                        }, 2000);
                    }else{
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                            };
                            toastr.error(response.message,'Notification');
                        }, 2000);
                        $('#deleteAllcheck').addClass('none');
                    }
                }
            });
        });
});
</script>
@endsection
