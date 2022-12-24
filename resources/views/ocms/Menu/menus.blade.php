@extends('ocms.master')
@section('content')
    @push('style')
        <style>
            .panel.with-nav-tabs .panel-heading{
                padding: 5px 5px 0 5px;
            }
            .panel.with-nav-tabs .nav-tabs{
                border-bottom: none;
            }
            .panel.with-nav-tabs .nav-justified{
                margin-bottom: -1px;
            }
            .with-nav-tabs.panel-primary .nav-tabs > li > a,
            .with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
            .with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
                color: #fff;
            }
            .with-nav-tabs.panel-primary .nav-tabs > .open > a,
            .with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
            .with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
            .with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
            .with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
                color: #fff;
                background-color: #3071a9;
                border-color: transparent;
            }
            .with-nav-tabs.panel-primary .nav-tabs > li.active > a,
            .with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
            .with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
                color: #428bca;
                background-color: #fff;
                border-color: #428bca;
                border-bottom-color: transparent;
            }
            .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
                background-color: #428bca;
                border-color: #3071a9;
            }
            .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
                color: #fff;
            }
            .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
            .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
                background-color: #3071a9;
            }
            .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
            .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
            .with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
                background-color: #4a9fe9;
            }
            #sortable { list-style-type: none;}
        </style>
    @endpush
    <!--addMenuModal Modal content-->
    <div id="addMenuModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="menu_form" class="form-inline" role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="menu_title">افزودن دسته بندی</h4>
                    </div>
                    <div id="error"></div>
                    <div class="modal-body">
                        <div class="form-group" >
                            <div id="image_show"></div>
                            <div class="input-group" >
                                <label for="image">تصویر دسته بندی را نتخاب کنید:</label>
                                <input type="file" id="image_menu" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="menu_name">نام سرفصل:</label>
                            <input type="text" class="form-control" name="menu_name" id="menu_name">
                            <input type="text" name="menu_id" id="menu_id" value="0" style="display: none">
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="active">نمایش:</label>
                            <input type="checkbox" name="menu_status" value="true" id="menu_status" checked>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="ذخیره">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--addSubMenuModal Modal content-->
    <div id="addSubMenuModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="sub_menu_form" class="form-inline" role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="sub_menu_title">افزودن زیر دسته بندی</h4>
                    </div>
                    <div id="sub_menu_error">
                    </div>
                    <div class="modal-body">
                        <input type="text" id="sub_menu_id" value="" style="display: none">
                        <div class="form-group">
                            <label for="sub_menu_parent">نام سرفصل:</label>
                            <select name="sub_menu_parent" class="form-control" id="sub_menu_parent">
                            </select>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label for="sub_menu_name">نام زیرفصل:</label>
                            <input type="text" class="form-control" name="sub_menu_name" id="sub_menu_name">
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="sub_menu_status">نمایش:</label>
                            <input type="checkbox" name="sub_menu_status" id="sub_menu_status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="ذخیره">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div class="panel with-nav-tabs panel-primary">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#menuTab" id="menu_managment" data-toggle="tab"><i class="fas fa-th-list"></i>  مدیریت دسته بندی </a></li>
                    <li><a href="#" class="modal_open" data-toggle="modal" data-target="#addMenuModal"><i class="fas fa-list-ol"></i>افزودن دسته بندی</a></li>
                    <li><a href="#" class="modal_open" data-toggle="modal" data-target="#addSubMenuModal"><i class="fas fa-folder-tree"></i>افزودن زیر دسته بندی</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="menuTab">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        _edit_menu=function(menu,main_menu){
            $.ajax({
                type : "POST",
                url : "/ocms/menu_edit_modal_content/"+menu ,
                data: {"_token": "{{ csrf_token() }}"},
                success: function(data) {

                    let menu=data.data
                    $("#menu_id").val(menu.id);
                    if (main_menu){
                        $("#menu_name").val(menu.name)
                        $("#menu_status").prop("checked",menu.status === "1");
                        $("#error").text('')
                        $("#menu_title").text('ویرایش منو');
                        $("#addMenuModal").modal("show");
                    }else{
                        $("#sub_menu_name").val(menu.name)
                        $("#sub_menu_status").prop("checked",menu.status === "1");
                        $("#sub_menu_error").text('');
                        $("#sub_menu_parent").val(menu.parent_id);
                        $("#sub_menu_title").text('ویرایش زیر منو');
                        $("#addSubMenuModal").modal("show");
                    }
                    $('#sub_menu_id').val(menu.id);
                }
            });

        }
        _delete_menu=function(id) {
            swal({
                title: 'از حذف مطمئن هستید؟',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "GET",
                        url: "{{url('ocms/delete_menu')}}" + '/' + id ,
                        success: function (data) {
                            swal({
                                title: 'حذف شد!',
                                text: 'سرفصل مورد نظر حذف شد',
                                type: 'success',
                                confirmButtonText: 'باشه'
                            }).then((ok)=>{
                                if (ok.value){
                                    _searchMenus();
                                }
                            });
                        },
                        error:function () {
                            swal({
                                title: 'خطا!',
                                text: 'سرفصل مورد نظر حذف نشد',
                                type: 'warning',
                                confirmButtonText: 'باشه'
                            })
                        }
                    });
                }
            });
        };
        //empty modal vals
        $(document).on("click", ".modal_open", function () {
            $('#sub_menu_error').html('');
            $('#sub_menu_name').val('');
            $('#menu_error').html('');
            $('#menu_name').val('');
        });
        $('#menu_form').on('submit',function (e) {
            e.preventDefault();
            let menu_name=$('#menu_name').val();
            if (menu_name === ''){
                $('#Error').html('<div class="alert alert-danger">نام را وارد کنید</div>');
            }else {
                let formData=new FormData()
                formData.append('menu_id',$('#menu_id').val())
                formData.append('menu_name',$('#menu_name').val())
                formData.append('status',$("#menu_status").prop('checked'))
                formData.append('image',$('#image_menu')[0].files[0])
                $.ajax({
                    headers:{"X-CSRF-Token": "{{ csrf_token() }}"},
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    url:`/ocms/add_menu` ,
                    data:formData,
                    success: function(result) {
                        console.log(result);
                        if (result.state === "invalid") {
                            $('#error').html('<div class="alert alert-danger"></div>');
                            for (var key in result.message) {
                                $('#error .alert').append('<li>' + result.message[key] + '</li>');
                            }
                        }
                        else if (result.state === "fail"){
                            $('#error').html('<div class="alert alert-danger"></div>');
                            $('#error .alert').append('<li>' + result.message + '</li>');
                        }
                        else {
                            $('#error').html('');
                            $('#addMenuModal').modal('hide');
                            _searchMenus();
                        }
                    },
                    error:function (result) {
                        $("#error").html("<div class=\"alert alert-danger\">"+result.message+"</div>");

                    }
                });
            }
        });
        $('#sub_menu_form').on('submit',function (e) {
            e.preventDefault();
            let sub_menu_name=$('#sub_menu_name').val();
            let sub_menu_parent=$('#sub_menu_parent').val();
            let sub_menu_status = $('#sub_menu_status').is(":checked");
            let sub_menu_id =$("#sub_menu_id").val();
            if (sub_menu_name === ''){
                $('#ErrorForSub').html('<div class="alert alert-danger">نام را وارد کنید</div>');

            }
            $.ajax({
                type: "POST",
                url: "{{url('ocms/add_sub_menu')}}",
                data: { sub_menu_parent,sub_menu_name, sub_menu_id , sub_menu_status ,"_token": "{{ csrf_token() }}"},
                success: function(result) {
                    if (result.status === "fails") {
                        $('#sub_menu_error').html('<div class="alert alert-danger"></div>');
                        for (var key in result.message) {
                            $('#sub_menu_error .alert').append('<li>' + result.message[key] + '</li>');
                        }
                    }
                    else if (result.status === "false"){
                        $('#sub_menu_error').html('<div class="alert alert-danger"></div>');
                        $('#sub_menu_error .alert').append('<li>' + result.message + '</li>');
                    }
                    else if(result.status==='ok') {
                        $('#sub_menu_error').html('');
                        $('#addSubMenuModal').modal('hide');
                        _searchMenus();
                    }
                },
                error:function (result) {
                    $('#sub_menu_error').html('<div class="alert alert-danger">خطای سیستمی رخ داد</div>');
                }
            });
        });
        // bind scrollstop event
        $(document).on("scrollstop",function(){
            if(isScroll){
                if( $(window).scrollTop() + window.innerHeight >= document.body.scrollHeight-2000) {
                    var scroll=0;
                    var search=1;
                    var remain_stock=-1;
                    if ($('#search').val()!=''){
                        scroll=1;
                        search=$('#search').val();
                        remain_stock=$('#remain_stock').val();
                    }

                    var row = Number($('#row').val());
                    var allcount = Number($('#all').val());
                    var rowperpage = 25;
                    row = row + rowperpage;
                    if(row <= allcount){
                        $('#row').val(row);
                        if(search.length>0 || search===1){
                            $.ajax({
                                method: 'GET',
                                url: "{{url('market/menuContent')}}" + '?search_text=' + search + '&scroll=' + scroll
                            }).done(function (result) {
                                $("#menuContent:last").append(result).show().fadeIn("slow");
                            });
                        }else if(remain_stock.length>0 && remain_stock!==-1 ){
                            $.ajax({
                                method: 'GET',
                                url: "{{url('market/menuContentStockReport')}}"+'?scroll='+scroll,
                                data: {'page_number' : $('#page-number').text(),remain_stock : remain_stock,"_token": "{{ csrf_token() }}"},
                            }).done(function (result) {
                                if (result == 'null'){
                                    swal({
                                        type: 'error',
                                        title: 'هیچ سفارشی یافت نشد'
                                    })
                                }
                                else{
                                    $("#menuContent").html("");
                                    $("#menuContent:last").append(result).show().fadeIn("slow");
                                }
                            });
                        }
                    }
                }
            }
        });
        _searchMenus = function (cargo_menus_selected) {
            $.ajax({
                method: 'GET',
                url: `/ocms/menuList`,
                data: {},
                success:function (result) {
                    if (result.menus.length<1){
                        swal({
                            type: 'error',
                            title: 'هیچ منویی یافت نشد'
                        })
                    }else{
                        let menus=result.menus;
                        let data='<ul id="sortable">';
                        let sub_menu_parent='';
                        let cargo_menus='';
                        $.each(menus,function (key,item) {
                            sub_menu_parent+=`<option value="${item.id}">${item.name}</option>`;
                            cargo_menus+=`<option ${$.inArray(item.id,cargo_menus_selected)!==-1?"selected":''} value="${item.id}">${item.name}</option>`;
                            data+=`<li class="ui-state-default" id="${item.id}"><div class="panel panel-info ui-state-default">`;
                            data+=`<div class="panel-heading"><span title="مرتب سازی منو" class="fas fa-exchange-alt fa-rotate-90"></span><a class="btn" onclick="_edit_menu(${item.id},1)" title="ویرایش"><span class="fa fa-pencil" ></span><a class="btn text-danger" onclick="_delete_menu(${item.id})" title="حذف"><span class="fa fa-trash" ></span></a></a> ${item.name} - (تعداد کالاها ${item.cargos_count})  </div>`;
                            data+=`<div class="panel-body">`;
                            data+=`<div id="sub_menu_sortable" class="list-group">`;
                            $.each(item.sub_menu,function (key,submenu) {
                                data+=`<div class="list-group-item" id="${submenu.id}"><span title="مرتب سازی زیر منو" class="text-success fas fa-exchange-alt fa-rotate-90"></span><a class="btn" onclick="_edit_menu(${submenu.id},0)" title="ویرایش"><span class="fa fa-pencil"></span></a><a class="btn text-danger" onclick="_delete_menu(${submenu.id})" title="حذف"><span class="fa fa-trash" ></span></a><a href="#" >${submenu.name}  - ( تعداد کالاها ${submenu.cargos_count})</a></div>`;
                                cargo_menus+=`<option value="${submenu.id}" ${$.inArray(submenu.id,cargo_menus_selected)!==-1?"selected":''}>${submenu.name}</option>`;
                            });
                            data+=`</div>`;
                            data+=`</div>`;
                            data+=`</div></li>`;
                        })
                        data+=`</ul>`;
                        $('#menuTab').html(data);
                        $( " #sortable,#sub_menu_sortable" ).sortable({
                            cursor: "move",
                            tolerance: "pointer",
                            opacity: 0.7,
                            revert: 0,
                            delay: 150,
                            update: function () {
                                let menus=$('#sortable').sortable('toArray')
                                let sub_menus=$(this).sortable('toArray')
                                $.ajax({
                                    type: "POST",
                                    url: `/ocms/sort_menu`,
                                    data:{menus,sub_menus,"_token":"{{csrf_token()}}"},
                                    success: function (response) {
                                    },
                                    error:function () {
                                        alert('مشکلی در ارتباط با سرور وجود دارد. لطفاً با پشتیبانی تماس بگیرید')
                                    }
                                });
                            },
                            appendTo: document.body
                        })
                        $( "#sortable,#sub_menu_sortable" ).disableSelection();
                        $('#sub_menu_parent').html(sub_menu_parent);
                        $('#cargo_menu').html(cargo_menus);
                    }
                },
                error:function () {
                    $('#menuTab').html(`<a class="btn btn-warning" onclick="_searchMenus()">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            });
        };
        function productEachSarfasl(parentId) {
            $.ajax({
                method: 'GET',
                url: "{{url('market/sessionParent')}}" + '/0/' + parentId
            }).done(function (data) {
                $.ajax({
                    method: 'GET',
                    url: "{{url('market/menuContent')}}"
                }).done(function (result) {
                    let dataToShow=parseResponse(result)
                    $("#menuContent").html("");
                    $("#menuContent:last").append(dataToShow).show().fadeIn("slow");
                    $('#search').show();
                    isScroll=1;
                });
            });
        }
            _searchMenus();
    </script>
@endsection
