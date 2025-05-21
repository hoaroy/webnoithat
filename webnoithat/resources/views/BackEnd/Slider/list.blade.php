@extends('Layout_admin')
@section('title')
  Slider
@endsection
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Slider</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-product">
                        <li><a href="#" class="dropdown-item">Tùy chọn cấu hình 1</a>
                             </li>
                             <li><a href="#" class="dropdown-item">Tùy chọn cấu hình 2</a>
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
                        <table id="slider_table" class="table table-striped table-bordered table-hover dataTables-example" >
	                        <thead>
		                        <tr style="text-transform: capitalize;">
		                            <th>ID</th>
		                            <th>Name</th>
                                    <th>Image</th>
		                            <th>Status</th>
		                            <th>Action</th>
		                        </tr>
	                        </thead>
                            <tbody id="sorting_orderby">

                            </tbody>
	                        <tfoot>
		                        <tr style="text-transform: capitalize;">
		                            <th>ID</th>
		                            <th>Name</th>
		                            <th>Image</th>
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
    </div>

    {{-- Add & Edit --}}
    <div class="modal inmodal" id="Modal_sample" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button style="margin-top: -5%" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span id="image_show"></span>
                    <h4 class="modal-title">Edit Slider</h4>
                    <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                </div>
                <form id="sample_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="message_err"></div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" class="form-control" name="slider_id" id="slider_id">
                        <input type="hidden" class="form-control" name="slider_url" id="slider_url_update">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Link </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="link" id="link">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                {{-- <input type="text" class="form-control" name="name_slider" id="name_slider"> --}}
                                <textarea data-provide="markdown" rows="5" name="name_slider" id="name_slider"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Content <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <textarea data-provide="markdown"  rows="5" name="content" id="content"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Desc <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <textarea data-provide="markdown"  rows="5" name="desc" id="desc"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Color <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="slider_change" id="slider_change">
                                    <option value="1">Black</option>
                                    <option value="2">White</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status" id="status">
                                    <option value="">-----Choose--------</option>
                                    <option value="1">Show</option>
                                    <option value="2">Hidden</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Image </label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="select_image" id="select_image" accept="image/*" multiple="" onchange="ImagesFileAsURL_2()">
                                <div id="displayImg" class="displayImg"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Load Data Slider
            $('#slider_table').DataTable({
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
                	url: "{{ route('slider.index') }}",
                },
                columns: [
                	{
                		data: 'slider_sorting'
                	},
                	{
                		data: 'slider_name',
                        className: 'edit_write',
                	},
                	{
                		data: 'slider_image',
                		render: function(data, type, full, meta){
					     	return "<img src={{ URL::to('/') }}/uploads/slider/" + data + " width='70' class='img-thumbnail' />";
					    },
					    orderable: false
                	},
                    {
                        data: null,
                        render: function(data, type, full, meta){
                            if (data.slider_status == 1) {
                                return '<div class="switch">\
                                            <div class="onoffswitch">\
                                                <input type="checkbox" checked class="onoffswitch-checkbox click" id="example'+data.slider_id+'" value="'+data.slider_id+'">\
                                                <label class="onoffswitch-label" for="example'+data.slider_id+'">\
                                                    <span class="onoffswitch-inner"></span>\
                                                    <span class="onoffswitch-switch"></span>\
                                                </label>\
                                            </div>\
                                        </div>'
                            }else{
                                return '<div class="switch">\
                                            <div class="onoffswitch">\
                                                <input type="checkbox" class="onoffswitch-checkbox click" id="example'+data.slider_id+'" value="'+data.slider_id+'">\
                                                <label class="onoffswitch-label" for="example'+data.slider_id+'">\
                                                    <span class="onoffswitch-inner"></span>\
                                                    <span class="onoffswitch-switch"></span>\
                                                </label>\
                                            </div>\
                                        </div>'
                            }
                        },
                        orderable: false
                    },
                	{
                		data: 'action',
                		orderable: false
                	},
                ],
                createdRow: function (row, data, index) {
                    $(row).attr("id",data['slider_id']);
                }
            });
            // Status
            $(document).on('click','.click', function(e){
                e.preventDefault();
                var checked = $(this).is(':checked');
                var id = $(this).val();
                var action = 'slider';
                var statusss = '';

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
                        $('#slider_table').DataTable().ajax.reload();
                    }
                });
            });
            // Sorting
            $('#sorting_orderby').sortable({
                palceholder: 'ui-state-highlight',
                update: function(event, ui){
                    var slider_id_array = new Array();
                    $('#sorting_orderby tr').each(function(){
                        slider_id_array.push($(this).attr('id'));
                    });

                    $.ajax({
                        type: 'post',
                        url: '{{ route('sorting.store') }}',
                        data: {slider_id_array:slider_id_array},
                        success:function(data){
                            $('#slider_table').DataTable().ajax.reload();
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.success(data.message,'Notification');
                            }, 2000);
                        }
                    });
                }
            });
            // Show Add
            $('#add_slider').click(function(){
                $('#sample_form')[0].reset();
                $('#message_err').text("");
                $('#message_err').removeClass("alert alert-danger");
                $('#image_show').html('');
                $('#displayImg').html('');
                $("#desc").val("");
                $("#name_slider").val("");
                $('.modal-title').text("Add New Record");
                $('#action').val("Add");
                $('#Modal_sample').modal('show');
            });
            // Edit
            $(document).on('click','#edit', function(e){
                e.preventDefault();
                $('#sample_form')[0].reset();
                $('#message_err').text("");
                $('#displayImg').html('');
                $('#message_err').removeClass("alert alert-danger");
                var slider_id = $(this).data('slider_id');
                var slider_url_update = $(this).data('slider_url_update');

                $('#Modal_sample').modal('show');
                $.ajax({
                    type: "get",
                    url: "slider/"+slider_id+"/edit",
                    dataType: "json",
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            $('#slider_url_update').val(slider_url_update);
                            $('#slider_id').val(slider_id);
                            $('#name_slider').text(response.slider.slider_name);
                            $('#content').text(response.slider.slider_content);
                            $('#link').val(response.slider.slider_url);
                            $('#desc').text(response.slider.slider_desc);
                            $('#status').val(response.slider.slider_status);
                            $('#slider_change').val(response.slider.slider_change);
                            $('#image_show').html('');
                            $('#image_show').append('<img src="uploads/slider/'+response.slider.slider_image+'" alt="" class="modal-icon img-thumbnail" width="80px" height="80px">');
                            $('.modal-title').text("Edit Slider");
                            $('#action').val("Edit");
                        }
                    }
                });
            });
            // Add & Update
            $(document).on('submit','#sample_form', function(e){
                e.preventDefault();
                var slider_id = $('#slider_id').val();
                var slider_url_update = $('#slider_url_update').val();
                var action_url = '';

                var select_image = $('#select_image')[0].files[0];
                var name_slider = $('#name_slider').val();
                var link = $('#link').val();
                var desc = $('#desc').val();
                var status = $('#status').val();
                var content = $('#content').val();
                var slider_change = $('#slider_change').val();

                var data = new FormData(this);
                data.append('select_image', select_image);
                data.append('name_slider', name_slider);
                data.append('link', link);
                data.append('desc', desc);
                data.append('status', status);
                data.append('content', content);
                data.append('slider_change', slider_change);

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('slider.store') }}";
                    data.append('_method', 'POST');
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "slider/"+slider_id;
                    data.append('_method', 'PUT');
                }

                $.ajax({
                    type: "post",
                    url: action_url,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    success:function(response){
                        if (response.status == 400) {
                            $('#message_err').html('');
                            $('#message_err').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values){
                                $('#message_err').append('\
                                    <li style="list-style-type: none;">'+err_values+'</li>')
                            });
                        }else{
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
                                $('#slider_table').DataTable().ajax.reload();
                            }, 2000);
                        }
                    }
                });
            });
            // Show Delete
            $(document).on('click','.delete', function(){
                var slider_id = $(this).data('slider_id');
                $('#Modal_delete').modal('show');

                $.ajax({
                    type: "get",
                    url: "slider/"+slider_id,
                    dataType: "json",
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            $('#hidden_id').val(slider_id);
                            $('#body').html('');
                            $('#body').append(''+response.slider.slider_name+'');
                        }
                    }
                });
            });
            // Delete
            $(document).on('submit','#delete_form', function(e){
                e.preventDefault();
                var slider_id = $('#hidden_id').val();

                $.ajax({
                    type: "delete",
                    url: "slider/"+slider_id,
                    dataType: "json",
                    beforeSend:function(){
                        $('#del_button').attr('disabled', true);
                    },
                    success:function(response){
                        if (response.status == 404) {
                            toastr.error(response.message,'Notification');
                        }else{
                            setTimeout(function(){
                                toastr.success(response.message,'Notification');
                                $('#Modal_delete').modal('hide');
                                $('#slider_table').DataTable().ajax.reload();
                            }, 2000);
                        }
                    }
                });
            });


        });
    </script>
@endsection
