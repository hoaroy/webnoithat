@extends('Layout_admin')
@section('title')
    Category
@endsection
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Category</h5>
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
                        <div class="panel blank-panel">
                            <div class="panel-heading">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                    <li><a class="nav-link active" href="#tab-1" data-toggle="tab">Danh sách Cate</a>
                                         </li>
                                         <li><a class="nav-link" href="#tab-2" data-toggle="tab">Liệt kê danh mục con</a></li>
                                         <li><a class="nav-link" href="#tab-3" data-toggle="tab">Sắp xếp danh sách</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    {{--  Tab 1  --}}
                                    <div class="tab-pane active" id="tab-1">
                                        <form>
                                            @csrf
                                            <table id="load_table" style="width: 100%;"
                                                class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr style="text-transform: capitalize;">
                                                    <th>ID</th>
                                                         <th>Tên</th>
                                                         <th>Trạng thái</th>
                                                         <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sorting_orderby">

                                                </tbody>
                                                <tfoot>
                                                    <tr style="text-transform: capitalize;">
                                                    <th>ID</th>
                                                         <th>Tên</th>
                                                         <th>Trạng thái</th>
                                                         <th>Hành động</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </form>
                                    </div>
                                    {{--  Tab 2  --}}
                                    <div class="tab-pane" id="tab-2">
                                        <form>
                                            @csrf
                                            <table id="load_table_sub" style="width: 100%;"
                                                class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr style="text-transform: capitalize;">
                                                    <th>ID</th>
                                                         <th>Tên</th>
                                                         <th>thư mục mẹ</th>
                                                         <th>Trạng thái</th>
                                                         <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sorting_orderby_sub">

                                                </tbody>
                                                <tfoot>
                                                    <tr style="text-transform: capitalize;">
                                                    <th>ID</th>
                                                         <th>Tên</th>
                                                         <th>thư mục mẹ</th>
                                                         <th>Trạng thái</th>
                                                         <th>Hành động</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </form>
                                    </div>
                                    {{--  Tab 3  --}}
                                    <div class="tab-pane" id="tab-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="nestable-menu">
                                                    <button type="button" data-action="expand-all" class="btn btn-white btn-sm">Expand All</button>
                                                    <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">Collapse All</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ibox ">
                                            <div class="tabhover">
                                                <p class="m-b-lg">
                                                <strong>Là</strong> danh sách phân cấp tương tác. Bạn có thể kéo thả vào
                                                     sắp xếp lại thứ tự. Nó hoạt động tốt trên màn hình cảm ứng.
                                                 </p>

                                                <div class="dd" id="nestable2">
                                                    <input type="hidden" id="action" value="action_cate">
                                                </div>
                                                <div class="m-t-md" style="display: none;">
                                                    <h5>Serialised Output</h5>
                                                </div>
                                                <textarea style="display: none;" id="nestable-output" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                    <button style="margin-top: -5%" type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span id="image_show"></span>
                    <h4 class="modal-title">Edit</h4>
                    <small class="font-bold">Lorem Ipsum chỉ đơn giản là văn bản giả của quá trình in và sắp chữ
                         công nghiệp.</small>
                </div>
                <form id="sample_form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="hidden_sub" id="hidden_sub">
                    <div class="modal-body">
                        <div id="message_err"></div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" class="form-control" name="category_id" id="category_id">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="category_name" id="slug_name"
                                    onkeyup="ChangeToSlug();">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Icon <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="category_icon" id="category_icon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Slug <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="slug_category_product" id="slug">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Sub Cate</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="category_sub" id="category_sub">
                                    <option value="">NULL</option>
                                    @foreach ($categories as $subcate)
                                        <option class="child childCategory{{ $subcate->category_id }}"
                                            style="text-transform: capitalize;" value="{{ $subcate->category_id }}">
                                            {{ $subcate->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="category_status" id="category_status">
                                <option value="">-----Chọn--------</option>
                                     <option value="1">Hiển thị</option>
                                     <option value="2">Ẩn</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <input type="hidden" name="action" id="action" />
                        <button type="submit" name="action_button" id="action_button" class="ladda-button btn btn-primary"
                            data-style="expand-right">Save changes</button>
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
                    <button style="margin-top: -10%; margin-right: -5%;" type="button" class="close"
                        data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Đóng</span></button>
                     <h4 class="modal-title">Xóa</h4>
                     <small class="font-bold">Lorem Ipsum chỉ đơn giản là văn bản giả của quá trình in và sắp chữ
                         công nghiệp.</small>
                </div>
                <input type="hidden" name="hidden_id" id="hidden_id">
                <div class="modal-body">
                    <p>Are you sure delete "<span id="body"></span>"?</p>
                </div>
                <form method="POST" id="delete_form">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                        <button type="submit" class="ladda-button btn btn-danger" data-style="expand-right"
                            id="del_button">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .display {
            display: none;
        }
        .tabhover{
            max-height: 700px;
            overflow-y: scroll;
        }
        .tabhover::-webkit-scrollbar {
            width: 5px;
            background-color: #ffffff;
        }
        .tabhover::-webkit-scrollbar-track {
        border-radius: 5px;
        background: rgba(0,0,0,0.1);
        border: 1px solid #ccc;
        }

        .tabhover::-webkit-scrollbar-thumb {
        border-radius: 5px;
        background: linear-gradient(left, #fff, #e4e4e4);
        border: 1px solid #aaa;
        }

        .tabhover::-webkit-scrollbar-thumb:hover {
        background: #fff;
        }

        .tabhover::-webkit-scrollbar-thumb:active {
        background: linear-gradient(left, #22ADD4, #1E98BA);
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('backend/js/plugins/nestable/jquery.nestable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Load Data Category
            $('#load_table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                pageLength: 10,
                responsive: true,
                order: [],
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'CategoryFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'CategoryFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                ajax: {
                    url: "{{ route('category.index') }}",
                },
                columns: [{
                        data: 'category_sorting'
                    },
                    {
                        data: 'category_name',
                        className: 'edit_write'
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            if (data.category_status == 1) {
                                return '<div class="switch">\
                                                <div class="onoffswitch">\
                                                    <input type="checkbox" checked class="onoffswitch-checkbox click" id="example' +
                                    data.category_id + '" value="' + data.category_id + '">\
                                                    <label class="onoffswitch-label" for="example' + data.category_id + '">\
                                                        <span class="onoffswitch-inner"></span>\
                                                        <span class="onoffswitch-switch"></span>\
                                                    </label>\
                                                </div>\
                                            </div>'
                            } else {
                                return '<div class="switch">\
                                                <div class="onoffswitch">\
                                                    <input type="checkbox" class="onoffswitch-checkbox click" id="example' +
                                    data.category_id + '" value="' + data.category_id + '">\
                                                    <label class="onoffswitch-label" for="example' + data.category_id + '">\
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
                createdRow: function(row, data, index) {
                    $(row).attr("id", data['category_id']);
                }
            });
            // Load Data SubCategory
            $('#load_table_sub').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                pageLength: 10,
                responsive: true,
                order: [],
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'CategoryFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'CategoryFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                ajax: {
                    url: "{{ route('category.create') }}",
                },
                columns: [{
                        data: 'category_sorting'
                    },
                    {
                        data: 'category_name',
                        className: 'edit_write'
                    },
                    {
                        data: 'category_parent',
                        orderable: false
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            if (data.category_status == 1) {
                                return '<div class="switch">\
                                                <div class="onoffswitch">\
                                                    <input type="checkbox" checked class="onoffswitch-checkbox click" id="example' +
                                    data.category_id + '" value="' + data.category_id + '">\
                                                    <label class="onoffswitch-label" for="example' + data.category_id + '">\
                                                        <span class="onoffswitch-inner"></span>\
                                                        <span class="onoffswitch-switch"></span>\
                                                    </label>\
                                                </div>\
                                            </div>'
                            } else {
                                return '<div class="switch">\
                                                <div class="onoffswitch">\
                                                    <input type="checkbox" class="onoffswitch-checkbox click" id="example' +
                                    data.category_id + '" value="' + data.category_id + '">\
                                                    <label class="onoffswitch-label" for="example' + data.category_id + '">\
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
                createdRow: function(row, data, index) {
                    $(row).attr("id", data['category_id']);
                }
            });
            // Show Add
            $('#add_category').click(function() {
                $('#sample_form')[0].reset();
                $('#message_err').text("");
                $('#message_err').removeClass("alert alert-danger");
                $(".chosen-container").removeClass('display');
                $(".child").removeClass('display');
                $('.modal-title').text("Add New Category");
                $('#action').val("Add");
                $('#Modal_sample').modal('show');
            });
            // Edit
            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                $('#sample_form')[0].reset();
                $('#message_err').text("");
                $('#message_err').removeClass("alert alert-danger");
                var category_id = $(this).data('category_id');

                $('#Modal_sample').modal('show');
                $.ajax({
                    type: "get",
                    url: "category/" + category_id + "/edit",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            toastr.error(response.message, 'Notification');
                        } else {
                            $('#category_id').val(response.category.category_id);
                            $('#slug_name').val(response.category.category_name);
                            $('#slug').val(response.category.category_slug);
                            $('#category_icon').val(response.category.category_icon);
                            $(".child").removeClass('display');
                            if (response.category.category_id == $(".childCategory" +
                                    category_id).val()) {
                                $(".childCategory" + category_id).addClass('display');
                            }
                            $('#category_sub').val(response.category.category_sub);

                            $('#category_status').val(response.category.category_status);
                            $('#image_show').html('');
                            $('.modal-title').text("Edit Category");
                            $('#action').val("Edit");
                        }
                    }
                });
            });
            // Add & Update
            $(document).on('submit', '#sample_form', function(e) {
                e.preventDefault();
                var category_id = $('#category_id').val();
                var action_url = '';
                var action_type = '';

                if ($('#action').val() == 'Add') {
                    action_url = "{{ route('category.store') }}";
                    action_type = "POST";
                }

                if ($('#action').val() == 'Edit') {
                    action_url = "category/" + category_id;
                    action_type = "PUT";
                }

                $.ajax({
                    type: action_type,
                    url: action_url,
                    data: {
                        category_name: $('#slug_name').val(),
                        slug_category_product: $('#slug').val(),
                        category_status: $('#category_status').val(),
                        category_sub: $('#category_sub').val(),
                        category_icon: $('#category_icon').val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#message_err').html('');
                            $('#message_err').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#message_err').append('\
                                        <li style="list-style-type: none;">' + err_values + '</li>')
                            });
                        } else {
                            $('#load_table').DataTable().ajax.reload();
                            $('#load_table_sub').DataTable().ajax.reload();
                            loadDataCate();
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 4000
                                };
                                toastr.success(response.message, 'Notification');
                                $('#sample_form')[0].reset();
                                $('#Modal_sample').modal('hide');
                            }, 2000);
                        }
                    }
                });
            });
            // Show Delete
            $(document).on('click', '.delete', function() {
                var category_id = $(this).data('category_id');
                $('#Modal_delete').modal('show');

                $.ajax({
                    type: "get",
                    url: "category/" + category_id + "/edit",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            toastr.error(response.message, 'Notification');
                        } else {
                            $('#hidden_id').val(category_id);
                            $('#body').html('');
                            $('#body').append('' + response.category.category_name + '');
                        }
                    }
                });
            });
            // Delete
            $(document).on('submit', '#delete_form', function(e) {
                e.preventDefault();
                var category_id = $('#hidden_id').val();

                $.ajax({
                    type: "delete",
                    url: "category/" + category_id,
                    dataType: "json",
                    beforeSend: function() {
                        $('#del_button').attr('disabled', true);
                    },
                    success: function(response) {
                        if (response.status == 404) {
                            toastr.error(response.message, 'Notification');
                        } else {
                            loadDataCate();
                            $('#load_table').DataTable().ajax.reload();
                            $('#load_table_sub').DataTable().ajax.reload();
                            setTimeout(function() {
                                toastr.success(response.message, 'Notification');
                                $('#Modal_delete').modal('hide');
                            }, 2000);
                        }
                    }
                });
            });
            // Sorting
            $('#sorting_orderby').sortable({
                palceholder: 'ui-state-highlight',
                update: function(event, ui) {
                    var category_id_array = new Array();
                    $('#sorting_orderby tr').each(function() {
                        category_id_array.push($(this).attr('id'));
                    });

                    $.ajax({
                        type: 'post',
                        url: '{{ route('sorting.store') }}',
                        data: {
                            category_id_array: category_id_array
                        },
                        success: function(data) {
                            $('#load_table').DataTable().ajax.reload();
                            loadDataCate();
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 4000
                                };
                                toastr.success(data.message, 'Notification');
                            }, 2000);
                        }
                    });
                }
            });
            // Sorting sub
            $('#sorting_orderby_sub').sortable({
                palceholder: 'ui-state-highlight',
                update: function(event, ui) {
                    var category_id_array = new Array();
                    $('#sorting_orderby_sub tr').each(function() {
                        category_id_array.push($(this).attr('id'));
                    });

                    $.ajax({
                        type: 'post',
                        url: '{{ route('sorting.store') }}',
                        data: {
                            category_id_array: category_id_array
                        },
                        success: function(data) {
                            $('#load_table').DataTable().ajax.reload();
                            loadDataCate();
                            $('#load_table_sub').DataTable().ajax.reload();
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 4000
                                };
                                toastr.success(data.message, 'Notification');
                            }, 2000);
                        }
                    });
                }
            });
            // Status
            $(document).on('click', '.click', function(e) {
                e.preventDefault();
                var checked = $(this).is(':checked');
                var id = $(this).val();
                var action = 'category';
                var statusss = '';

                if (checked == true) {
                    statusss = 1;
                } else {
                    statusss = 2;
                }
                $.ajax({
                    type: 'post',
                    url: '{{ route('status.store') }}',
                    data: {
                        statusss: statusss,
                        id: id,
                        action: action
                    },
                    success: function(response) {
                        toastr.success(response.message, 'Notification');
                        $('#load_table').DataTable().ajax.reload();
                        $('#load_table_sub').DataTable().ajax.reload();
                        loadDataCate();
                    }
                });
            });
            // Load Data Sub
            loadDataCate();

            function loadDataCate() {
                $.ajax({
                    type: 'post',
                    url: '{{ route('list.store') }}',
                    dataType: 'json',
                    success: function(response) {
                        $('#nestable2').html(response.data);
                    }
                });
            }

            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                $.ajax({
                    type: 'post',
                    url: '{{ route('list.store') }}',
                    data: {
                        data: list.nestable('serialize')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            loadDataCate();
                            $('#load_table').DataTable().ajax.reload();
                            $('#load_table_sub').DataTable().ajax.reload();
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 4000
                                };
                                toastr.success(response.message, 'Notification');
                            }, 2000);
                        }
                    }
                });
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };
            // activate Nestable for list 1
            $('#nestable2').nestable({
                group: 1
            }).on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable2').data('output', $('#nestable-output')));

            $('#nestable-menu').on('click', function(e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });
    </script>
@endsection
