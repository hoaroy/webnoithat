@extends('Layout_admin')
@section('title')
  Coupon
@endsection
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Coupon</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-product">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form>
                    @csrf
                    <div class="table-responsive">
                        <table id="load_table" class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr style="text-transform: capitalize;">
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>sale</th>
                                    <th>code</th>
                                    <th>condition</th>
                                    <th>Status</th>
                                    <th>expiry</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr style="text-transform: capitalize;">
                                    <th><input type="checkbox" id="checkAll_footer"><button id="deleteAllcheck" class="ladda-button btn btn-danger none" data-style="expand-right">Delete</button></th>
                                    <th>sale</th>
                                    <th>code</th>
                                    <th>condition</th>
                                    <th>Status</th>
                                    <th>expiry</th>
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
    </div>

    {{-- Add & Edit --}}
    <div class="modal inmodal" id="Modal_sample" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button style="margin-top: -5%" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span id="image_show"></span>
                    <h4 class="modal-title">Edit</h4>
                    <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                </div>
                <form id="sample_form" method="POST">
                    @method('PUT')
                    <div class="modal-body">
                        <div id="message_err"></div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" class="form-control" name="coupon_id" id="coupon_id">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Qty <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" name="coupon_qty" id="coupon_qty" oninput="this.value = Math.abs(this.value)" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control" name="coupon_date_start" id="coupon_date_start" value="{{Carbon\Carbon::now()->format('Y/m/d')}}"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control-sm form-control" name="coupon_date_end" id="coupon_date_end" value="{{Carbon\Carbon::tomorrow()->format('Y/m/d')}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Condition <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="coupon_condition" id="coupon_condition">
                                    <option value="">-----Choose--------</option>
                                    <option value="1">Money</option>
                                    <option value="2">Percent</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Sale Number </label>
                            <div class="col-sm-10" id="show_coupon_sale_number">
                                {{-- <input type="number" disabled="" name="coupon_sale_number" id="coupon_sale_number" class="form-control"> --}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="coupon_status" id="coupon_status">
                                    <option value="">-----Choose--------</option>
                                    <option value="1">Show</option>
                                    <option value="2">Hidden</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <input type="hidden" name="action" id="action" />
                        <button type="submit" name="action_button" id="action_button" class="ladda-button btn btn-primary" data-style="expand-right">Save changes</button>
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

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            var today   = new Date();
            var dd      = today.getDate();
            var mm      = today.getMonth()+1;
            var yyyy    = today.getFullYear();

            $('#data_5 .input-daterange').datepicker({
                format: 'yyyy/mm/dd',
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
            // Load Data Coupon
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
                    url: "{{ route('coupon.index') }}",
                },
                columns: [
                    {
                        data: null,
                        className: 'tdcheckbox',
                        render: function(data, type, full, meta){
                            return '<input type="checkbox" name="ids" id="ids" class="checkboxclass" value="'+data.coupon_id+'">';
                        },
                        orderable: false
                    },
                    {
                        data: 'coupon_sale_number',
                    },
                    {
                        data: 'coupon_code',
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta){
                            if (data.coupon_condition == 1) {
                                return "<span class='expiry tag-style'>Money</span>";
                            }else{
                                return "<span class='still-term tag-style'>Percent</span>";
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta){
                            if (data.coupon_status == 1) {
                                return '<div class="switch">\
                                            <div class="onoffswitch">\
                                                <input type="checkbox" checked class="onoffswitch-checkbox click" id="example'+data.coupon_id+'" value="'+data.coupon_id+'">\
                                                <label class="onoffswitch-label" for="example'+data.coupon_id+'">\
                                                    <span class="onoffswitch-inner"></span>\
                                                    <span class="onoffswitch-switch"></span>\
                                                </label>\
                                            </div>\
                                        </div>'
                            }else{
                                return '<div class="switch">\
                                            <div class="onoffswitch">\
                                                <input type="checkbox" class="onoffswitch-checkbox click" id="example'+data.coupon_id+'" value="'+data.coupon_id+'">\
                                                <label class="onoffswitch-label" for="example'+data.coupon_id+'">\
                                                    <span class="onoffswitch-inner"></span>\
                                                    <span class="onoffswitch-switch"></span>\
                                                </label>\
                                            </div>\
                                        </div>'
                            }
                        },
                    },
                    {
                        data: null,
                        render: function(data, type, row){
                            var date_end      = new Date(data.coupon_date_end);
                            var date_end_dd   = date_end.getDate();
                            var date_end_mm   = date_end.getMonth()+1;
                            var date_end_yyyy = date_end.getFullYear();

                            if (mm < date_end_mm && date_end_yyyy >= yyyy) {
                                return "<span class='expiry tag-style'>Expiry Date</span>";
                            }else if (mm == date_end_mm && date_end_yyyy == yyyy) {
                                if (date_end_dd >= dd) {
                                    return "<span class='expiry tag-style'>Expiry Date</span>";
                                }else{
                                    return "<span class='expired tag-style'>Out Of Date</span>";
                                }
                            }else{
                                return "<span class='expired tag-style'>Out Of Date</span>";
                            }
                        }
                    },
                    {
                        data: 'action',
                        orderable: false
                    },
                ]
            });
            // Status
            $(document).on('click','.click', function(e){
                e.preventDefault();
                var checked = $(this).is(':checked');
                var id = $(this).val();
                var statusss = '';
                var action = 'coupon';

                if (checked == true) {
                    statusss = 1;
                }else{
                    statusss = 2;
                }
                $.ajax({
                    type: 'post',
                    url: '{{ route('status.store') }}',
                    data: {statusss:statusss,id:id,action:action},
                    success:function(response){
                        toastr.success(response.message,'Notification');
                        $('#load_table').DataTable().ajax.reload();
                    }
                });
            });
           // Show Add
           $('#add_coupon').click(function(){
                if(dd<10)
                {
                    dd='0'+dd;
                }

                if(mm<10)
                {
                    mm='0'+mm;
                }
                today = yyyy+'/'+mm+'/'+dd;

                $('#sample_form')[0].reset();
                $('#show_coupon_sale_number').html('');
                $('#show_coupon_sale_number').append('<input disabled="" type="number" name="coupon_sale_number" id="coupon_sale_number" class="form-control">');
                // $('#coupon_date_start').val(today);
                // $('#coupon_date_end').val(today);
                $('.modal-title').text("Add New Coupon");
                $('#action').val("Add");
                $('#Modal_sample').modal('show');
           });
           // Edit
           $(document).on('click','#edit', function(e){
                e.preventDefault();
                $('#sample_form')[0].reset();
                $('#message_err').text("");
                $('#message_err').removeClass("alert alert-danger");
                var coupon_id = $(this).data('coupon_id');

                $('#Modal_sample').modal('show');
                $.ajax({
                    type: "get",
                    url: "coupon/"+coupon_id+"/edit",
                    dataType: "json",
                    success:function(response){
                        if (response.status == 404) {
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.error(response.message,'Notification');
                            }, 1300);
                        }else{
                            $('#coupon_id').val(coupon_id);
                            $('#coupon_qty').val(response.coupon.coupon_qty);
                            if (response.coupon.coupon_condition == 1) {
                                $('#show_coupon_sale_number').addClass('input-group');
                                $('#show_coupon_sale_number').html('');
                                $('#show_coupon_sale_number').append('\
                                    <input type="text" class="form-control" data-mask="999,999" id="change_price_coupon" onkeyup="ChangeToCoupon();" disabled="" value="'+response.coupon.coupon_sale_number+'">\
                                    <input type="hidden" class="form-control" name="coupon_sale_number" id="coupon_sale_number" value="'+response.coupon.coupon_sale_number+'">\
                                    <span class="input-group-addon">\
                                        <span>VNĐ</span>\
                                    </span>\
                                ');
                            }else{
                                $('#show_coupon_sale_number').addClass('input-group');
                                $('#show_coupon_sale_number').html('');
                                $('#show_coupon_sale_number').append('\
                                    <input type="number" name="coupon_sale_number" id="coupon_sale_number" class="form-control" disabled="" value="'+response.coupon.coupon_sale_number+'">\
                                    <span class="input-group-addon">\
                                        <span>%</span>\
                                    </span>\
                                ');
                            }
                            // $('#coupon_sale_number').val(response.coupon.coupon_sale_number);

                            $('#coupon_code').val(response.coupon.coupon_code);
                            $('#coupon_condition').val(response.coupon.coupon_condition);
                            $('#coupon_status').val(response.coupon.coupon_status);
                            $('#coupon_date_start').val(response.coupon.coupon_date_start);
                            $('#coupon_date_end').val(response.coupon.coupon_date_end);
                            $('#image_show').html('');
                            $('.modal-title').text("Edit Coupon");
                            $('#action').val("Edit");
                        }
                    }
                });
            });
           // Add & Update
           $(document).on('submit','#sample_form', function(e){
                e.preventDefault();
                var coupon_id = $('#coupon_id').val();
                var action_url = '';
                var action_type= '';

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('coupon.store') }}";
                    action_type = "POST";
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "coupon/"+coupon_id;
                    action_type = "PUT";
                }

                $.ajax({
                    type: action_type,
                    url: action_url,
                    data: {
                            coupon_qty:$('#coupon_qty').val(),
                            coupon_sale_number:$('#coupon_sale_number').val(),
                            coupon_code:$('#coupon_code').val(),
                            coupon_condition:$('#coupon_condition').val(),
                            coupon_status:$('#coupon_status').val(),
                            coupon_date_start:$('#coupon_date_start').val(),
                            coupon_date_end:$('#coupon_date_end').val(),
                    },
                    dataType:"json",
                    success:function(response){
                        if (response.status == 400) {
                            $('#message_err').html('');
                            $('#message_err').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values){
                                $('#message_err').append('\
                                    <li style="list-style-type: none;">'+err_values+'</li>')
                            });
                        }else if(response.message_erro){
                            $('#message_err').html('');
                            $('#message_err').addClass('alert alert-danger');
                            $('#message_err').append('\
                                <li style="list-style-type: none;">'+response.message_erro+'</li>')
                        }
                        else{
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.success(response.message,'Notification');
                                $('#sample_form')[0].reset();
                                $('#Modal_sample').modal('hide');
                                $('#load_table').DataTable().ajax.reload();
                            }, 2000);
                        }
                    }
                });
           });
           // Show Delete
            $(document).on('click','.delete', function(){
                var coupon_id = $(this).data('coupon_id');
                $('#Modal_delete').modal('show');

                $.ajax({
                    type: "get",
                    url: "coupon/"+coupon_id+"/edit",
                    dataType: "json",
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message);
                        }else{
                            $('#hidden_id').val(coupon_id);
                        }
                    }
                });
            });
            // Delete
            $(document).on('submit','#delete_form', function(e){
                e.preventDefault();
                var coupon_id = $('#hidden_id').val();

                $.ajax({
                    type: "delete",
                    url: "coupon/"+coupon_id,
                    dataType: "json",
                    beforeSend:function(){
                        $('#del_button').attr('disabled', true);
                    },
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            setTimeout(function(){
                                toastr.success(response.message);
                                $('#Modal_delete').modal('hide');
                                $('#load_table').DataTable().ajax.reload();
                            }, 2000);
                        }
                    }
                });
            });

            // Choose
            $('#coupon_condition').on('change',function(){
                var value = $(this).val();
                console.log(value);
                $.ajax({
                    url : 'coupon/'+value,
                    method: 'get',
                    dataType: 'json',
                    data:{value:value},
                    success:function(response){
                        if (response.data == 1) {
                            $('#show_coupon_sale_number').addClass('input-group');
                            $('#show_coupon_sale_number').html('');
                            $('#show_coupon_sale_number').append(`
                                <input type="text" class="form-control" data-mask="999,999" id="change_price_coupon" onkeyup="ChangeToCoupon();">
                                <input type="hidden" class="form-control" name="coupon_sale_number" id="coupon_sale_number">
                                <span class="input-group-addon">
                                    <span>VNĐ</span>
                                </span>
                            `);
                        }else if (response.data == 2) {
                            $('#show_coupon_sale_number').addClass('input-group');
                            $('#show_coupon_sale_number').html('');
                            $('#show_coupon_sale_number').append(`
                                <input type="number" name="coupon_sale_number" id="coupon_sale_number" class="form-control" oninput="this.value = Math.abs(this.value)">
                                <span class="input-group-addon">
                                    <span>%</span>
                                </span>
                            `);
                        }else{
                            $('#change_price_coupon').val('');
                            $('#show_coupon_sale_number').html('');
                            $('#show_coupon_sale_number').append('<input disabled="" type="number" name="coupon_sale_number" id="coupon_sale_number" class="form-control">');
                        }
                    }
                });

            });

            // Delete All
            $(document).on('click','#deleteAllcheck', function(e){
                e.preventDefault();
                var allids = [];
                var action = 'coupon';
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
