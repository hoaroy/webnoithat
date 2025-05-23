@extends('Layout_admin')
@section('title')
    Products
@endsection
@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
        <h2>Sản phẩm bàn</h2>
             <ol class="breadcrumb">
                 <li class="breadcrumb-item">
                     <a>Sản phẩm</a>
                 </li>
                 <li class="breadcrumb-item">
                     <a>Liệt kê sản phẩm</a>
                 </li>
                 <li class="breadcrumb-item active">
                     <strong>Thư viện danh sách</strong>
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
                        <h5>Product</h5>
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
                                        <li id="li_tab1"><a class="nav-link active" href="#tab-1" data-toggle="tab">List Product</a></li>
                                        <li id="li_tab2"><a class="nav-link" href="#tab-2" data-toggle="tab">Add Product</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    {{-- Tab 1 --}}
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="table-responsive">
                                            <table id="data_load" style="width: 100%;"
                                                class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr style="text-transform: capitalize;">
                                                        <th><input type="checkbox" id="checkAll"></th>
                                                        <th>Tên</th>
                                                         <th>thư viện ảnh</th>
                                                         <th>Hình ảnh</th>
                                                         <th>Số lượng</th>
                                                         <th>giá</th>
                                                         <th>xem</th>
                                                         <th>ngày giảm giá</th>
                                                         <th>trạng thái</th>
                                                         <th>Hành động</th>
                                                    </tr>
                                                </thead>

                                                <tfoot>
                                                    <tr style="text-transform: capitalize;">
                                                        <th><input type="checkbox" id="checkAll_footer"><button
                                                                id="deleteAllcheck" class="ladda-button btn btn-danger none"
                                                                data-style="expand-right">Delete</button></th>
                                                                <th>Tên</th>
                                                         <th>thư viện ảnh</th>
                                                         <th>Hình ảnh</th>
                                                         <th>Số lượng</th>
                                                         <th>giá</th>
                                                         <th>xem</th>
                                                         <th>ngày giảm giá</th>
                                                         <th>trạng thái</th>
                                                         <th>Hành động</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- Tab 2 --}}
                                    <div class="tab-pane" id="tab-2">
                                        <form method="post"
                                            enctype="multipart/form-data" role="form" id="formsample">
                                            <input type="hidden" name="hidden_id" id="hidden_id">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="ibox" id="ibox2" style="margin-top: 5%;">
                                                        <div
                                                            class="form-group row {{ $errors->has('product_name') ? 'has-error' : '' }}">
                                                            <label class="col-sm-2 col-form-label">Name <sup
                                                                    class="text-danger">*</sup></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    name="product_name" id="slug_name"
                                                                    onkeyup="ChangeToSlug();"
                                                                    value="">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="form-group row {{ $errors->has('product_slug') ? 'has-error' : '' }}">
                                                            <label class="col-sm-2 col-form-label">Slug <sup
                                                                    class="text-danger">*</sup></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    name="product_slug" id="slug"
                                                                    value="">
                                                            </div>
                                                        </div>
                                                        <div id="data_3"
                                                            class="form-group row {{ $errors->has('product_date_sale') ? 'has-error' : '' }}">
                                                            <label class="col-sm-2 col-form-label">Date Sale</label>
                                                            <div class="col-sm-10 input-group date">
                                                                <span class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></span>
                                                                        <input type="text"
                                                                    class="form-control" name="product_date_sale" id="product_date_sale"
                                                                    value="{{ now()->format('Y/m/d') }}">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="form-group row {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                                            <label class="col-sm-2 col-form-label">Category</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="category_id" id="category_id">
                                                                    @foreach ($categorys as $category)
                                                                        <option style="text-transform: capitalize;"
                                                                            value="{{ $category->category_id }}">
                                                                            {{ $category->category_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row"><label
                                                                class="col-sm-2 col-form-label">Status <sup
                                                                    class="text-danger">*</sup></label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control" name="product_status" id="product_status">
                                                                    <option value="">--- Choose ---</option>
                                                                    <option value="1">Hiển thị</option>
                                                                     <option value="2">Ẩn</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row"><label
                                                                class="col-sm-2 col-form-label">Image</label>
                                                            <div class="col-sm-10">
                                                                <input type="file" class="form-control file_image"
                                                                    name="product_image" accept="image/*" multiple=""
                                                                    id="product_image">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="form-group row {{ $errors->has('product_price') ? 'has-error' : '' }}">
                                                            <label class="col-sm-2 col-form-label">Price <sup
                                                                    class="text-danger">*</sup></label>
                                                            <div class="col-sm-10 input-group">
                                                                    <input type="text" class="form-control money"
                                                                    name="product_price"
                                                                    id="change_price" onkeyup="ChangeToPrice();"
                                                                    value="">
                                                                <input type="hidden" class="form-control"
                                                                    name="product_price_hidden"
                                                                    value=""
                                                                    id="pirce_hidden">
                                                                <span class="input-group-addon">
                                                                    <span>VNĐ</span>
                                                                </span>

                                                            </div>
                                                        </div>
                                                        <div
                                                            class="form-group row {{ $errors->has('promotion_price') || Session::get('message_err') ? 'has-error' : '' }}">
                                                            <label class="col-sm-2 col-form-label">Khuyến mãi</label>
                                                            <div class="col-sm-10 input-group">
                                                                <input type="text" class="form-control money"
                                                                    name="promotion_price"
                                                                    id="promotion_price" onkeyup="ChangeToPrice();"
                                                                    value="0">
                                                                <input type="hidden" class="form-control"
                                                                    name="promotion_price_hidden"
                                                                    id="promotion_price_hidden"
                                                                    value="0">
                                                                <span class="input-group-addon">
                                                                    <span>VNĐ</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="form-group row {{ $errors->has('product_quantity') ? 'has-error' : '' }}">
                                                            <label class="col-sm-2 col-form-label">Số lượng <sup
                                                                    class="text-danger">*</sup></label>
                                                            <div class="col-sm-10">
                                                                <input type="number" class="form-control"
                                                                    name="product_quantity" id="product_quantity" min="1"
                                                                    value=""
                                                                    oninput="this.value = Math.abs(this.value)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="ibox ">
                                                        <div
                                                            class="form-group {{ $errors->has('product_desc') ? 'has-error' : '' }}">
                                                            <label class="font-normal">Desc <sup
                                                                    class="text-danger">*</sup></label>
                                                            <textarea rows="5" name="product_desc" id="product_desc" required=""></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group row">
                                                <div class="col-sm-12 col-sm-offset-2">
                                                    <input type="hidden" name="action" id="action" value="Add">
                                                    <button class="btn btn-primary btn-lg ladda-button float-right"
                                                        data-style="expand-right" type="submit">Save
                                                        changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                    <button style="margin-top: -10%; margin-right: -5%;" type="button" class="close"
                        data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Đóng</span></button>
                     <h4 class="modal-title">Xóa</h4>
                     <small class="font-bold">Lorem Ipsum chỉ đơn giản là văn bản giả của quá trình in và sắp chữ
                         công nghiệp.</small>
                </div>
                <input type="hidden" name="hidden_id_product" id="hidden_id_product">
                <div class="modal-body">
                    <p>Are you sure delete "<span id="body_product"></span>"?</p>
                </div>
                <form method="POST" id="delete_product">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                        <button type="submit" class="ladda-button btn btn-danger" data-style="expand-right">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('backend/js/simple.money.format.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend/ckeditor/ckfinder/ckfinder.js') }}"></script>
    <script type="text/javascript">
        function CKupdate(){
            for(instance in CKEDITOR.instance){
                CKEDITOR.instances['product_desc'].updateElement();
            }
        }
        $('.money').simpleMoneyFormat();

        $(document).ready(function() {
            CKEDITOR.config.autoParagraph = false;
            CKEDITOR.replace('product_desc');
            // Load data
            $('#data_load').DataTable({
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
                        title: 'productFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'productFile'
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
                    url: "{{ route('product.index') }}",
                },
                columns: [{
                        data: null,
                        className: 'tdcheckbox',
                        render: function(data, type, full, meta) {
                            return '<input type="checkbox" name="ids" id="ids" class="checkboxclass" value="' +
                                data.product_id + '">';
                        },
                        orderable: false
                    },
                    {
                        data: 'product_name'
                    },
                    {
                        data: 'gallery_td'
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            return "<img src=uploads/product/" + data.product_image +
                                " width='80px' height='80px' class='img-thumbnail' />";
                        },
                        orderable: false
                    },
                    {
                        data: 'product_quantity'
                    },
                    {
                        data: 'price_td'
                    },
                    {
                        data: 'product_view'
                    },
                    {
                        data: 'date_pro'
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            if (data.product_status == 1) {
                                return '<div class="switch">\
                                                <div class="onoffswitch">\
                                                    <input type="checkbox" checked class="onoffswitch-checkbox click" id="example' +
                                    data.product_id + '" value="' + data.product_id + '">\
                                                    <label class="onoffswitch-label" for="example' + data.product_id + '">\
                                                        <span class="onoffswitch-inner"></span>\
                                                        <span class="onoffswitch-switch"></span>\
                                                    </label>\
                                                </div>\
                                            </div>'
                            } else {
                                return '<div class="switch">\
                                                <div class="onoffswitch">\
                                                    <input type="checkbox" class="onoffswitch-checkbox click" id="example' +
                                    data
                                    .product_id + '" value="' + data.product_id + '">\
                                                    <label class="onoffswitch-label" for="example' + data.product_id + '">\
                                                        <span class="onoffswitch-inner"></span>\
                                                        <span class="onoffswitch-switch"></span>\
                                                    </label>\
                                                </div>\
                                            </div>'
                            }
                        },
                    },
                    {
                        data: 'action',
                        orderable: false
                    },
                ]

            });
            // Status
            $(document).on('click', '.click', function(e) {
                e.preventDefault();
                var checked = $(this).is(':checked');
                var id = $(this).val();
                var action = 'product';
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
                        $('#data_load').DataTable().ajax.reload();
                    }
                });
            });
            // Show Delete
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id_product');
                $('#Modal_delete').modal('show');

                $.ajax({
                    type: "get",
                    url: "product/" + id + "/edit",
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            toastr.error(response.message, 'Notification');
                        } else {
                            $('#hidden_id_product').val(response.product.product_id);
                            $('#body_product').html('');
                            $('#body_product').append('' + response.product.product_name + '');
                        }
                    }
                });
            });
            // Delete
            $(document).on('submit', '#delete_product', function(e) {
                e.preventDefault();
                var product_id = $('#hidden_id_product').val();
                let Editform = new FormData($('#delete_product')[0]);
                $.ajax({
                    type: "delete",
                    url: "product/" + product_id,
                    data: Editform,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            toastr.error(response.message, 'Notification');
                        } else {
                            $('#data_load').DataTable().ajax.reload();
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 4000
                                };
                                toastr.success(response.message, 'Notification');
                                $('#Modal_delete').modal('hide');
                            }, 2000);
                        }
                    }
                });
            });
            // Delete All
            $(document).on('click', '#deleteAllcheck', function(e) {
                e.preventDefault();
                var allids = [];
                var action = 'product';
                $('input:checkbox[name=ids]:checked').each(function() {
                    allids.push($(this).val());
                });

                $.ajax({
                    type: 'post',
                    url: '{{ route('remove.store') }}',
                    data: {
                        allids: allids,
                        action: action
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#data_load').DataTable().ajax.reload();
                            $('#deleteAllcheck').addClass('none');
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 4000
                                };
                                toastr.success(response.message, 'Notification');
                            }, 2000);
                        } else {
                            setTimeout(function() {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: 'slideDown',
                                    timeOut: 4000
                                };
                                toastr.error(response.message, 'Notification');
                            }, 2000);
                            $('#deleteAllcheck').addClass('none');
                        }
                    }
                });
            });
            // Click Tab 1
            $(document).on('click','#li_tab1 a,#li_tab2 a',function(e){
                e.preventDefault();
                $('#formsample')[0].reset();
                $('#li_tab2 a').text('Add Product');
                $('#action').val('Add');
                if($('#action').val() == 'Add')
                {
                    CKupdate();
                    $('#product_desc').text('');
                    CKEDITOR.instances['product_desc'].setData(product_desc);
                }
            });
            // Edit
            $(document).on('click','.editpro',function(e){
                e.preventDefault();
                var id = $(this).data('id_product');
                $('#tab-1').removeClass('active');
                $('#li_tab1 a').removeClass('active');
                $('#tab-2').addClass('active show');
                $('#li_tab2 a').addClass('active');

                $.ajax({
                    type: 'get',
                    url: 'product/'+id+'/edit',
                    dataType: 'json',
                    success:function(response){
                        $('#hidden_id').val(id);
                        $('#action').val('Edit');
                        $('#li_tab2 a').text('Edit "'+response.product.product_name+'"');

                        $('#slug_name').val(response.product.product_name);
                        $('#slug').val(response.product.product_slug);
                        $('#product_date_sale').val(response.date);
                        $('#category_id').val(response.product.category_id);
                        $('#product_status').val(response.product.product_status);
                        $('#change_price').val(response.product.product_price);
                        $('#pirce_hidden').val(response.product.product_price);
                        $('#promotion_price').val(response.product.product_price_sale);
                        $('#promotion_price_hidden').val(response.product.product_price_sale);
                        $('#product_quantity').val(response.product.product_quantity);
                        CKupdate();
                        $('#product_desc').text(response.product.product_desc);
                        CKEDITOR.instances['product_desc'].setData(product_desc);
                    }
                });

            });
            // Add & Update Product
            $(document).on('submit','#formsample',function(e){
                e.preventDefault();
                var id = $('#hidden_id').val();
                var action_url = '';

                var product_image = $('#product_image')[0].files[0];
                var product_name = $('#slug_name').val();
                var product_slug = $('#slug').val();
                var product_date_sale = $('#product_date_sale').val();
                var category_id = $('#category_id').val();
                var product_status = $('#product_status').val();
                var product_price_hidden = $('#pirce_hidden').val();
                var promotion_price_hidden = $('#promotion_price_hidden').val();
                var product_quantity = $('#product_quantity').val();
                var product_desc = $('#product_desc').val();

                var data = new FormData(this);
                data.append('product_image', product_image);
                data.append('product_name', product_name);
                data.append('product_slug', product_slug);
                data.append('product_date_sale', product_date_sale);
                data.append('category_id', category_id);
                data.append('product_status', product_status);
                data.append('product_price_hidden', product_price_hidden);
                data.append('promotion_price_hidden', promotion_price_hidden);
                data.append('product_quantity', product_quantity);
                data.append('product_desc', product_desc);

                if($('#action').val() == 'Add')
                {
                    action_url = "{{ route('product.store') }}";
                    data.append('_method', 'POST');
                }

                if($('#action').val() == 'Edit')
                {
                    action_url = "product/"+id;
                    data.append('_method', 'PUT');
                }

                $.ajax({
                    type: 'post',
                    url: action_url,
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    success:function(response){
                        if (response.status == 400) {
                            $.each(response.errors, function(key, err_values){
                                toastr.error(err_values,'Notification');
                            });
                        }else if(response.status == 404){
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.error(response.message,'Notification');
                            }, 2000);
                        }else{
                            $('#formsample')[0].reset();
                            if($('#action').val() == 'Add'){
                                CKupdate();
                                $('#product_desc').text('');
                                CKEDITOR.instances['product_desc'].setData(product_desc);
                            }else{
                                CKupdate();
                                $('#product_desc').text('');
                                CKEDITOR.instances['product_desc'].setData(product_desc);
                                $('#formsample')[0].reset();
                                $('#li_tab2 a').text('Add Product');

                                setTimeout(function() {
                                    $('#li_tab2 a').removeClass('active show');
                                    $('#li_tab1 a').addClass('active show');
                                    $('#tab-2').removeClass('active');
                                    $('#tab-1').addClass('active');
                                }, 2000);
                            }
                            $('#action').val('Add');
                            $('#data_load').DataTable().ajax.reload();
                            setTimeout(function() {
                                toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 4000
                                };
                                toastr.success(response.message,'Notification');
                            }, 2000);
                        }
                    }
                });
            });



        });
    </script>
@endsection
