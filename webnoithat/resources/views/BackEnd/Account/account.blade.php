@extends('Layout_admin')
@section('title')
  Account
@endsection
@section('content')

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Tables Account</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a>Account</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>List Account</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Account</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
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

                        <div class="table-responsive">
                            <table id="account_table" class="table table-striped table-bordered table-hover dataTables-example tooltip-demo">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th><input type="checkbox" id="checkAll_footer"><button id="deleteAllcheck" class="ladda-button btn btn-danger none" data-style="expand-right">Delete</button></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
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
                    <input type="hidden" name="hidden_id_account" id="hidden_id_account">
                    <div class="modal-body">
                        <p>Are you sure delete "<span id="body_account"></span>"?</p>
                    </div>
                    <form method="POST" id="delete_account_user">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                        <button type="submit" class="ladda-button btn btn-danger" data-style="expand-right">Yes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add & Edit --}}
        <div class="modal inmodal" id="Modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button style="margin-top: -5%" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <span id="image_show_account"></span>
                        <h4 class="modal-title"></h4>
                        <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                    </div>
                    <form id="sample_profile_form" method="POST">
                        <div class="modal-body">
                            <div id="message_err"></div>
                            <div class="hr-line-dashed"></div>
                            <input type="hidden" class="form-control" name="account_user_id" id="account_user_id">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name <sup class="text-danger">*</sup></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">User Name <sup class="text-danger">*</sup></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="user_name" id="user_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email <sup class="text-danger">*</sup></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Password <sup class="text-danger">*</sup></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Level <sup class="text-danger">*</sup></label>
                                <div class="col-sm-10">
                                    <select name="level" id="level" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1">User</option>
                                        <option value="2">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <input type="hidden" name="action" id="action">
                            <button type="submit" class="ladda-button btn btn-primary update_profile" data-style="expand-right">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@section('script')
<script src="//cdn.datatables.net/plug-ins/f2c75b7247b/api/fnFakeRowspan.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Load Data Account
            var table = $('#account_table').DataTable({
                destroy: true,
                processing : true,
                serverSide : true,
                pageLength: 10,
                responsive: true,
                order:[],rowsGroup : [2],
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'SliderFile'},
                    {extend: 'pdf', title: 'SliderFile'},

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
                    url: "{{ route('account.index') }}",
                },
                drawCallback: function( settings ) {
                    $('.hover_tooltip').tooltip({
                       title: fetchData,
                       html: true,
                       placement: 'right'
                    });
                },
                columns: [
                    {
                        data: null,
                        className: 'tdcheckbox',
                        render: function(data, type, full, meta){
                            return '<input type="checkbox" name="ids" id="ids" class="checkboxclass" value="'+data.id+'">';
                        },
                        orderable: false
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta){
                            return '<a class="hover_tooltip text-primary" href="#" data-toggle="tooltip" data-placement="right" title="" id="'+data.id+'">'+data.name+'</a>';
                        }
                    },
                    {data: 'email'},
                    {data: 'status'},
                    {
                        data: null,
                        render: function(data, type, full, meta){
                            if (data.level == 1) {
                                return '<a id="'+data.id+'" class="click"><i class="fa fa-user text-danger"></i></a>';
                            }else{
                                return '<a id="'+data.id+'" class="click"><i class="fa fa-user-secret text-success"></i></a>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        orderable: false
                    }
                ]

            });
            // Status
            $(document).on('click','.click', function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                var action = 'account';

                $.ajax({
                    type: 'post',
                    url: '{{ route('status.store') }}',
                    data: {id:id,action:action},
                    success:function(response){
                        toastr.success(response.message,'Notification');
                        $('#account_table').DataTable().ajax.reload();
                    }
                });
            });
            // Show Add
            $(document).on('click','#add_account', function(e){
                $('#sample_profile_form')[0].reset();
                $('#message_err').text("");
                $('#message_err').removeClass("alert alert-danger");
                $('#image_show_account').html('');
                $('#displayImg').html('');
                $('#Modal_edit').modal('show');
                $('.modal-title').text("Add New Account");
                $('#action').val("Add");
                $('#password').val('');
            });
            // Edit
            $(document).on('click','#edit_account', function(e){
                $('#message_err').text("");
                $('#message_err').removeClass("alert alert-danger");
                var account_id = $(this).data('account_id');
                $('#Modal_edit').modal('show');

                $.ajax({
                    type: "get",
                    url: "account/"+account_id+"/edit",
                    dataType: "json",
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            $('#action').val("Edit");
                            $('#name').val(response.profile_login.name);
                            $('#user_name').val(response.profile_login.username);
                            $('#email').val(response.profile_login.email);
                            $('#level').val(response.profile_login.level);
                            $('#account_user_id').val(account_id);
                            $('.modal-title').text("Edit Account");
                            $('#password').val('');
                        }
                    }
                });
            });
            // Add & Update
            $(document).on('submit','#sample_profile_form', function(e){
                e.preventDefault();
                var account_id = $('#account_user_id').val();
                var action_url = '';
                var action_type = '';

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('account.store') }}";
                    action_type = 'POST';
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "account/"+account_id;
                    action_type = 'PUT';
                }

                $.ajax({
                    type: action_type,
                    url: action_url,
                    data: {
                        name        : $('#name').val(),
                        user_name   : $('#user_name').val(),
                        password    : $('#password').val(),
                        email       : $('#email').val(),
                        level       : $('#level').val()
                    },
                    dataType: "json",
                    success:function(response){
                        if (response.status == 400) {
                            $('#message_err').html('');
                            $('#message_err').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values){
                                $('#message_err').append('\
                                    <li style="list-style-type: none;">'+err_values+'</li>')
                            });
                        }else if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.success(response.message,'Notification');
                                $('#Modal_edit').modal('hide');
                                $('#account_table').DataTable().ajax.reload();
                            }, 2000);
                        }
                    }
                });
            });
            // Show Delete
            $(document).on('click','#delete_account', function(e){
                e.preventDefault();
                var account_id = $(this).data('account_id');
                $('#Modal_delete').modal('show');

                // console.log(account_id)
                $.ajax({
                    type: "get",
                    url: "account/"+account_id+"/edit",
                    dataType: "json",
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            $('#hidden_id_account').val(response.profile_login.id);
                            $('#body_account').html('');
                            $('#body_account').append(''+response.profile_login.name+'');
                        }
                    }
                });
            });
            // Delete
            $(document).on('submit','#delete_account_user', function(e){
                e.preventDefault();
                var account_id = $('#hidden_id_account').val();
                let Editform = new FormData($('#delete_account_user')[0]);
                $.ajax({
                    type: "delete",
                    url: "account/"+account_id,
                    data: Editform,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.success(response.message,'Notification');
                                $('#Modal_delete').modal('hide');
                                $('#account_table').DataTable().ajax.reload();
                            }, 2000);
                        }
                    }
                });
            });
            // Tooltip
            function fetchData()
            {
                var fetch_data = '';
                var id = $(this).attr("id");

                $.ajax({
                    type: 'get',
                    url:"account/"+id,
                    async: false,
                    data:{id:id},
                    success:function(response)
                    {
                        if (status == 404) {
                            toastr.error(response.message,'Notification')
                        }else{
                            fetch_data = response.data;
                        }
                    }
                });
                return fetch_data;
            }
            // Delete All
            $(document).on('click','#deleteAllcheck', function(e){
                e.preventDefault();
                var allids = [];
                var action = 'account';
                $('input:checkbox[name=ids]:checked').each(function(){
                    allids.push($(this).val());
                });

                $.ajax({
                    type: 'post',
                    url: '{{ route('remove.store') }}',
                    data: {allids:allids,action:action},
                    success:function(response){
                        if (response.status == 200) {
                            $('#account_table').DataTable().ajax.reload();
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
