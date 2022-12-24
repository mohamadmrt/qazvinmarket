@extends('ocms.master')
@section('content')
    <!-- addCargoModal -->
    <div id="cargoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ویرایش کالا«<span id="cargo_name"></span>»</h4>
                </div>
                <div id="cargo_form">

                </div>

            </div>
        </div>
    </div>
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade" id="menuTab">
                </div>
                <div class="tab-pane fade in active" id="cargoTab">
                    <div class="panel panel-info panel-table radius2px">
                        <div class="panel-heading">
                            <div style="text-align: center;">نتایج یافت شده: <span id="total_result"></span></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: #969696;">
                                <tr>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">شناسه</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 100px">
                                        <div align="center">تصویر</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 300px">
                                        <div align="center">نام</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">قیمت</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 120px">
                                        <div align="center">قیمت با تخفیف</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">موجودی</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">دسته بندی</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">زیردسته</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">تعداد فروش</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">امتیاز</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 70px">
                                        <div align="center">تعداد امتیاز</div>
                                    </td>
                                    <td nowrap="nowrap" style="width: 160px">
                                        <div align="center">حداکثر تعداد قابل سفارش</div>
                                    </td>
                                    <td nowrap="nowrap">
                                        <div align="center">نمایش</div>
                                    </td>
                                    <td nowrap="nowrap">
                                        <div align="center">نمایش ت.تولید</div>
                                    </td>
                                    <td nowrap="nowrap">
                                        <div align="center">نمایش ت.انقضا</div>
                                    </td>
                                    <td nowrap="nowrap">
                                        <div align="center">جدیدترین</div>
                                    </td>
                                    <td nowrap="nowrap">
                                        <div align="center">عملیات</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"
                                               onkeyup="_searchCargos(1)"></td>
                                    <td>
                                        <select class="search_filter" style="width: 100%" onchange="_searchCargos(1)"
                                                id="search_by_image">
                                            <option value="">همه</option>
                                            <option value="1">دارد</option>
                                            <option value="0">ندارد</option>
                                        </select>
                                    </td>
                                    <td><input class="search_filter" style="width: 100%" type="text" id="search_by_name"
                                               onkeyup="_searchCargos(1)"></td>
                                    <td><input class="search_filter" style="width: 100%" type="text"
                                               id="search_by_price" onkeyup="_searchCargos(1)"></td>
                                    <td><input class="search_filter" style="width: 100%" type="text"
                                               id="search_by_price_discount" onkeyup="_searchCargos(1)"></td>
                                    <td><input class="search_filter" style="width: 100%" type="text"
                                               id="search_by_max_count" onkeyup="_searchCargos(1)"></td>
                                    <td><select class="search_filter" style="width: 100%" onchange="_searchCargos(1)"
                                                id="search_by_category">
                                            <option value="">همه</option>
                                            <option value="1">بله</option>
                                            <option value="0">خیر</option>
                                        </select>
                                    </td>
                                    <td><select class="search_filter" style="width: 100%" onchange="_searchCargos(1)"
                                                id="search_by_sub_category">
                                            <option value="">همه</option>
                                            <option value="1">بله</option>
                                            <option value="0">خیر</option>
                                        </select>
                                    </td>
                                    <td><input class="search_filter" style="width: 100%" type="text"
                                               id="search_by_buy_count" onkeyup="_searchCargos(1)"></td>
                                    <td><input class="search_filter" style="width: 100%" type="text"
                                               id="search_by_vote_average" onkeyup="_searchCargos(1)"></td>
                                    <td><input class="search_filter" style="width: 100%" type="text"
                                               id="search_by_vote_count" onkeyup="_searchCargos(1)"></td>
                                    <td><input class="search_filter" style="width: 100%" type="text"
                                               id="search_by_max_order" onkeyup="_searchCargos(1)"></td>
                                    <td><select class="search_filter" style="width: 100%" onchange="_searchCargos(1)"
                                                id="search_by_status">
                                            <option value="">همه</option>
                                            <option value="1">بله</option>
                                            <option value="0">خیر</option>
                                        </select>
                                    </td>
                                    <td><select class="search_filter" style="width: 100%" onchange="_searchCargos(1)"
                                                id="search_by_mfg_date_show">
                                            <option value="">همه</option>
                                            <option value="1">بله</option>
                                            <option value="0">خیر</option>
                                        </select>
                                    </td>
                                    <td><select class="s-earch_filter" style="width: 100%" onchange="_searchCargos(1)"
                                                id="search_by_exp_date_show">
                                            <option value="">همه</option>
                                            <option value="1">بله</option>
                                            <option value="0">خیر</option>
                                        </select>
                                    </td>
                                    <td><select class="search_filter" style="width: 100%" onchange="_searchCargos(1)"
                                                id="search_by_newest">
                                            <option value="">همه</option>
                                            <option value="1">بله</option>
                                            <option value="0">خیر</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody id="recordsTable">
                                <tr>
                                    <td colspan="9">در حال دریافت اطلاعات...</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class=" "
                                 style="text-align:center; direction:rtl; margin-top:35px ;margin-bottom: 35px;">
                                <a href="#1" id="first-page" class="btn paginate" style="float:none;margin: 1px">
                                    << </a>
                                <a href="#1" id="prev-page" class="btn paginate" style="float:none;margin: 1px"> < </a>
                                <a href="#1" id="page-number" class="btn btn-success" style="float:none;margin: 1px">
                                    1 </a>
                                <a href="#1" id="next-page" class="btn paginate" style="float:none;margin: 1px"> > </a>
                                <a href="#1" id="last-page" class="btn paginate" style="float:none;margin: 1px"> >> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#cargo_form').keypress((e) => {

            // Enter key corresponds to number 13
            if (e.which === 13) {
                $('.info').submit();
            }
        })
        _searchMenus = function (cargo_menus_selected) {
            $.ajax({
                method: 'GET',
                url: `/ocms/menuList`,
                data: {},
                success: function (result) {
                    if (result.menus.length < 1) {
                        swal({
                            type: 'error',
                            title: 'هیچ منویی یافت نشد'
                        })
                    } else {
                        let menus = result.menus;
                        let data = '<ul id="sortable">';
                        let sub_menu_parent = '';
                        let cargo_menus = '';
                        $.each(menus, function (key, item) {
                            sub_menu_parent += `<option value="${item.id}">${item.name}</option>`;
                            cargo_menus += `<option ${$.inArray(item.id, cargo_menus_selected) !== -1 ? "selected" : ''} value="${item.id}">${item.name}</option>`;
                            data += `<li class="ui-state-default" id="${item.id}"><div class="panel panel-info ui-state-default">`;
                            data += `<div class="panel-heading"><span title="مرتب سازی منو" class="fas fa-exchange-alt fa-rotate-90"></span><a class="btn" onclick="_edit_menu(${item.id},1)" title="ویرایش"><span class="fa fa-pencil" ></span><a class="btn text-danger" onclick="_delete_menu(${item.id})" title="حذف"><span class="fa fa-trash" ></span></a></a> ${item.name} - (تعداد کالاها ${item.cargos_count})  </div>`;
                            data += `<div class="panel-body">`;
                            data += `<div id="sub_menu_sortable" class="list-group">`;
                            $.each(item.sub_menu, function (key, submenu) {
                                data += `<div class="list-group-item" id="${submenu.id}"><span title="مرتب سازی زیر منو" class="text-success fas fa-exchange-alt fa-rotate-90"></span><a class="btn" onclick="_edit_menu(${submenu.id},0)" title="ویرایش"><span class="fa fa-pencil"></span></a><a class="btn text-danger" onclick="_delete_menu(${submenu.id})" title="حذف"><span class="fa fa-trash" ></span></a><a href="#" >${submenu.name}  - ( تعداد کالاها ${submenu.cargos_count})</a></div>`;
                                cargo_menus += `<option value="${submenu.id}" ${$.inArray(submenu.id, cargo_menus_selected) !== -1 ? "selected" : ''}>${submenu.name}</option>`;
                            });
                            data += `</div>`;
                            data += `</div>`;
                            data += `</div></li>`;
                        })
                        data += `</ul>`;
                        $('#menuTab').html(data);
                        $(" #sortable,#sub_menu_sortable").sortable({
                            cursor: "move",
                            tolerance: "pointer",
                            opacity: 0.7,
                            revert: 0,
                            delay: 150,
                            update: function () {
                                let menus = $('#sortable').sortable('toArray')
                                let sub_menus = $('#sub_menu_sortable').sortable('toArray')
                                $.ajax({
                                    type: "POST",
                                    url: `/ocms/sort_menu`,
                                    data: {menus, sub_menus, "_token": "{{csrf_token()}}"},
                                    success: function (response) {
                                    },
                                    error: function () {
                                        alert('مشکلی در ارتباط با سرور وجود دارد. لطفاً با پشتیبانی تماس بگیرید')
                                    }
                                });
                            },
                            appendTo: document.body
                        })
                        $("#sortable,#sub_menu_sortable").disableSelection();
                        $('#sub_menu_parent').html(sub_menu_parent);
                        $('#cargo_menu').html(cargo_menus);
                    }
                },
                error: function () {
                    $('#menuTab').html(`<a class="btn btn-warning" onclick="_searchMenus()">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            });
        };
        _delete_menu = function (id) {
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
                        url: "{{url('ocms/delete_menu')}}" + '/' + id,
                        success: function (data) {
                            swal({
                                title: 'حذف شد!',
                                text: 'سرفصل مورد نظر حذف شد',
                                type: 'success',
                                confirmButtonText: 'باشه'
                            }).then((ok) => {
                                if (ok.value) {
                                    _searchMenus();
                                }
                            });
                        },
                        error: function () {
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

        $(document).on("click", ".paginate", function () {
            _searchCargos($(this).attr('page'));
        })
        _searchCargos = function (page) {
            let params = {};
            params.search_by_id = $('#search_by_id').val() ? $('#search_by_id').val() : '';
            params.search_by_image = $('#search_by_image').val() ? $('#search_by_image').val() : '';
            params.search_by_name = $('#search_by_name').val() ? $('#search_by_name').val() : '';
            params.search_by_max_count = $('#search_by_max_count').val() ? $('#search_by_max_count').val() : '';
            params.search_by_price_discount = $('#search_by_price_discount').val() ? $('#search_by_price_discount').val() : '';
            params.search_by_buy_count = $('#search_by_buy_count').val() ? $('#search_by_buy_count').val() : '';
            params.search_by_vote_average = $('#search_by_vote_average').val() ? $('#search_by_vote_average').val() : '';
            params.search_by_vote_count = $('#search_by_vote_count').val() ? $('#search_by_vote_count').val() : '';
            params.search_by_max_order = $('#search_by_max_order').val() ? $('#search_by_max_order').val() : '';
            params.search_by_price = $('#search_by_price').val() ? $('#search_by_price').val() : '';
            params.search_by_status = $('#search_by_status').val() ? $('#search_by_status').val() : '';
            params.search_by_newest = $('#search_by_newest').val() ? $('#search_by_newest').val() : '';
            $.ajax({
                method: 'GET',
                url: `/ocms/cargoList/?page=${page}`,
                data: {params: params},
                success: function (result) {

                    if (result.cargos.length < 1) {
                        // swal({type: 'error',title: 'هیچ کالایی یافت نشد'})
                        $('#recordsTable').html('');
                        $("#total_result").text(result.paginate.total)
                    } else {
                        $("#total_result").text(result.paginate.total)
                        let cargos = result.cargos;
                        let paginate = result.paginate;
                        let data = '';
                        $.each(cargos, function (key, item) {
                            data += `<tr ${item.max_count === 0 ? 'title="اتمام موجودی شده"' : ''} ${item.max_count === 0 ? '' : ''}>`;
                            data += `<td>${item.id}</td>`;
                            data += `<td><img src="${item.image}" class="thumbnail" style="width: 100px" alt="تصویر" ></td>`;
                            data += `<td>${item.name}<hr>`;
                            $.each(item.menus, function (index, menu) {
                                data += `«${menu.name}»`
                            });
                            data += `</td>`;
                            data += `<td>${formatPrice(item.price)}</td>`;
                            data += `<td>${formatPrice(item.price_discount)}</td>`;
                            data += `<td>${formatPrice(item.max_count)}</td>`;
                            data += `<td>${formatPrice(item.max_count)}</td>`;
                            data += `<td>${formatPrice(item.max_count)}</td>`;
                            data += `<td>${formatPrice(item.buy_count)}</td>`;
                            data += `<td>${item.vote_average}</td>`;
                            data += `<td>${formatPrice(item.vote_count)}</td>`;
                            data += `<td>${formatPrice(item.max_order)}</td>`;
                            data += `<td>${item.status === "0" ? '<span class="label label-danger">خیر</span>' : '<span class="label label-success">بله</span>'}</td>`;
                            data += `<td>${item.newest === "0" ? '<span class="label label-danger">خیر</span>' : '<span class="label label-success">بله</span>'}</td>`;
                            data += `<td>${item.mfg_date_show === 0 ? '<span class="label label-danger">خیر</span>' : '<span class="label label-success">بله</span>'}</td>`;
                            data += `<td>${item.exp_date_show === 0 ? '<span class="label label-danger">خیر</span>' : '<span class="label label-success">بله</span>'}</td>`;
                            data += `<td>
<a class="btn btn-block btn-primary" title="ویرایش" onclick="_editCargo(${item.id})"><i class="fas fa-pencil"></i></a>
${item.status === "0" ? '<a class="btn btn-block btn-success" title="نمایش در سایت" onclick="_showCargo(' + item.id + ')"><i class="fas fa-eye"></i></a>' : '<a class="btn btn-block btn-danger" title="عدم نمایش" onclick="_showCargo(' + item.id + ')"><i class="fas fa-eye-slash"></i></a>'}
${item.newest === "0" ? '<a class="btn btn-block btn-success" title="جدیدترین باشد" onclick="_newestCargo(' + item.id + ')"><i class="fas fa-star"></i></a>' : '<a class="btn btn-block btn-danger" title="جدیدترین نباشد " onclick="_newestCargo(' + item.id + ')"><i class="far fa-star"></i></a>'}
</td>`;
                            data += `</tr>`;
                        })
                        $('#recordsTable').html(data);
                        $('#page-number').text(paginate.current_page).attr('page', paginate.current_page)
                        $('#last-page').attr('page', paginate.last_page)
                        if (paginate.current_page === 1)
                            $('#first-page, #prev-page').attr('disabled', 'disabled');
                        else {
                            $('#first-page, #prev-page').removeAttr('disabled');
                            $('#first-page').attr('page', 1);
                            $('#prev-page').attr('page', paginate.current_page + 1);
                        }
                        $('#prev-page').attr('page', paginate.current_page - 1);
                        if (paginate.current_page < paginate.last_page) {
                            $('#last-page, #next-page').removeAttr('disabled');
                            $('#last-page').attr('page', paginate.last_page);
                            $('#next-page').attr('page', paginate.current_page + 1);
                        } else {
                            $('#last-page, #next-page').attr('disabled', 'disabled');
                        }
                    }
                },
                error: function () {
                    $('#recordsTable').html(`<a class="btn btn-warning" onclick="_searchCargos(1)">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            });

        };
        _searchCargos(1);
        _showCargo = function (id) {
            $.ajax({
                method: 'POST',
                data: {id: id, "_token": "{{ csrf_token() }}"},
                url: "/ocms/show_cargo/" + id,
                success: function (result) {
                    _searchCargos(parseInt($('#page-number').attr('page')))
                },
                error: function (response) {
                    alert(response.responseJSON.responseText)
                }
            })
        };
        _newestCargo = function (id) {
            $.ajax({
                method: 'POST',
                data: {id: id, "_token": "{{ csrf_token() }}"},
                url: "/ocms/newest_cargo/" + id,
                success: function (result) {
                    _searchCargos(parseInt($('#page-number').attr('page')))
                },
                error: function (response) {
                    alert(response.responseJSON.responseText)
                }
            })
        };
        _editCargo = function (id) {
            $.ajax({
                method: 'POST',
                data: {"_token": "{{ csrf_token() }}"},
                url: "/ocms/edit_cargo/" + id,
                success: function (result) {
                    let cargo = result.data;
                    let cargo_menus = [];
                    cargo.menus.forEach(function (item) {
                        cargo_menus.push(item.id)
                    })
                    $("#cargo_name").text(cargo.name)
                    let data = `<div class="modal-body"><div class="form-group">`;
                    data += `<label for="menu">نام سرفصل:</label>`;
                    data += `<select style="width: 100%"  class="form-control select2 " dir="rtl" name="cargo_menu[]" id="cargo_menu" multiple="multiple"></select>`;
                    data += `</div>`;
                    data += `<div class="form-group">`;
                    data += `<label for="name">نام کالا:</label>`;
                    data += `<input name="name" readonly type="text" class="form-control" id="name" value="${cargo.name}" />`;
                    data += `</div>`;
                    data += `<div class="form-group">`;
                    data += `<label for="price">قیمت اصلی(تومان):</label>`;
                    data += `<input name="price" type="text" readonly class="form-control" id="price" value="${cargo.price}" />`;
                    data += `</div>`;
                    data += `<div class="form-group">`;
                    data += `<label for="priceDiscount">قیمت با تخفیف(تومان):</label>`;
                    data += `<input name="priceDiscount" type="text" class="form-control" id="priceDiscount" value="${cargo.price_discount}" />`;
                    data += `</div>`;
                    data += `<div class="form-group">`;
                    data += `<label for="description">توضیحات</label>`;
                    data += `<textarea id="description" class="form-control" name="description" rows="4" cols="50">${cargo.description}</textarea>`;
                    data += `</div>`;
                    data += `<div class="form-group col-md-6">`;
                    data += `<label for="mfg_date" >تاریخ تولید:</label>`;
                    data += `<input type="text" class="form-control"  data-mddatetimepicker="true"  data-enabletimepicker="true" id="mfg_date" placeholder="تاریخ تولید" autocomplete="off" value="${cargo.mfg_date}" />`;
                    data += `</div>`;
                    data += `<div class="form-group col-md-6">`;
                    data += `<label for="exp_date" >تاریخ انقضا:</label>`;
                    data += `<input type="text" class="form-control"  data-mddatetimepicker="true"  data-enabletimepicker="true" id="exp_date" placeholder="تاریخ انقضا" autocomplete="off" value="${cargo.exp_date}" />`;
                    data += `</div>`;
                    data += `<div class="form-group col-md-6">`;
                    data += `<label for="max_count">موجودی(${cargo.bazara_UnitName}):</label>`;
                    data += `<input name="max_count" type="text" class="form-control" id="max_count" value="${cargo.max_count}" />`;
                    data += `</div>`;
                    data += `<div class="form-group col-md-6">`;
                    data += `<label for="max_order">حداکثر سفارش(${cargo.bazara_UnitName}):</label>`;
                    data += `<input name="max_order" type="text" class="form-control" id="max_order" value="${cargo.max_order}" />`;
                    data += `</div>`;
                    data += `<div class="form-group">`;
                    data += `<label for="image">تصویر:</label>`;
                    data += `<img src="${cargo.image}" class="img-thumbnail" style="width: 250px" alt="تصویر یافت نشد">`;
                    data += `<input name="image" type="file" id="image"/>`;
                    data += `</div>`;
                    data += `<div class="form-group" title="نمایش در سایت">`;
                    data += `<label for="status">نمایش: &nbsp;</label>`;
                    data += `<input name="status" type="checkbox" class="checkbox-inline" id="status" ${cargo.status === "1" ? "checked" : ""} />`;
                    data += `</div>`;
                    data += `<div class="form-group" title="نمایش تاریخ تولید">`;
                    data += `<label for="mfg_date_show">نمایش تاریخ تولید: &nbsp;</label>`;
                    data += `<input name="mfg_date_show" type="checkbox" class="checkbox-inline" id="mfg_date_show" ${cargo.mfg_date_show === 1 ? "checked" : ""} />`;
                    data += `</div>`;
                    data += `<div class="form-group" title="نمایش تاریخ انقضا">`;
                    data += `<label for="exp_date_show">نمایش تاریخ انقضا: &nbsp;</label>`;
                    data += `<input name="exp_date_show" type="checkbox" class="checkbox-inline" id="exp_date_show" ${cargo.exp_date_show === 1 ? "checked" : ""} />`;
                    data += `</div>`;
                    data += `<div class="form-group" title="جدیدترین">`;
                    data += `<label for="newest">جدیدترین: &nbsp;</label>`;
                    data += `<input name="newest" type="checkbox" class="checkbox-inline" id="newest" ${cargo.newest === "1" ? "checked" : ""} />`;
                    data += `</div></div>`;
                    data += `<div class="modal-footer"><input type="submit" onclick="_update_cargo(${cargo.id})"  id="update_cargo" class="btn btn-success" value="ذخیره">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button> </div>`;
                    $("#cargo_form").html(data)
                    $("#cargoModal").modal("show");
                    _searchMenus(cargo_menus)
                    $(".select2").select2({
                        placeholder: "انتخاب",
                        maximumSelectionSize: 6,
                    });
                    $(document).ready(function () {
                        var $dateTimePickers = $('[data-MdDateTimePicker="true"]');
                        $dateTimePickers.each(function () {
                            var $this = $(this),
                                trigger = $this.attr('data-trigger'),
                                placement = $this.attr('data-Placement'),
                                enableTimePicker = $this.attr('data-EnableTimePicker'),
                                targetSelector = $this.attr('data-TargetSelector'),
                                groupId = $this.attr('data-GroupId'),
                                toDate = $this.attr('data-ToDate'),
                                fromDate = $this.attr('data-FromDate');
                            if (!$this.is(':input') && $this.css('cursor') == 'auto')
                                $this.css({cursor: 'pointer'});
                            $this.MdPersianDateTimePicker({
                                Placement: placement,
                                Trigger: trigger,
                                EnableTimePicker: enableTimePicker != undefined ? enableTimePicker : false,
                                TargetSelector: targetSelector != undefined ? targetSelector : '',
                                GroupId: groupId != undefined ? groupId : '',
                                ToDate: toDate != undefined ? toDate : '',
                                FromDate: fromDate != undefined ? fromDate : '',
                            });
                        });
                    });
                },
                error: function (response) {
                    alert(response.responseJSON.responseText)
                }
            })
        };
        _update_cargo = function (id) {
            let formdata = new FormData()
            formdata.append('max_order', $("#max_order").val())
            formdata.append('max_count', $("#max_count").val())
            formdata.append('image', $('#image')[0].files[0])
            formdata.append('newest', $("#newest").prop('checked'))
            formdata.append('status', $("#status").prop('checked'))
            formdata.append('price_discount', $("#priceDiscount").val())
            formdata.append('price', $("#price").val())
            formdata.append('description', $("#description").val())
            formdata.append('cargo_menu', $("#cargo_menu").val())
            formdata.append('mfg_date', $("#mfg_date").val())
            formdata.append('exp_date', $("#exp_date").val())
            formdata.append('mfg_date_show', $("#mfg_date_show").prop('checked'))
            formdata.append('exp_date_show', $("#exp_date_show").prop('checked'))

            if ($("#mfg_date_show").prop('checked') && $("#mfg_date").val() == '') {
                    alert('تاریخ تولید نباید خالی باشد');
                    return null;
            }
            if ($("#exp_date_show").prop('checked') && $("#exp_date").val() == '') {
                alert('تاریخ انقضا نباید خالی باشد');
                return null;
            }

            $.ajax({
                headers: {"X-CSRF-Token": "{{ csrf_token() }}"},
                method: 'POST',
                contentType: false,
                processData: false,
                data: formdata,
                url: "/ocms/update_cargo/" + id,
                success: function (result) {
                    swal({
                        title: 'پیغام سیستم!',
                        text: 'کالا با موفقیت ویرایش شد',
                        type: 'success',
                        confirmButtonText: 'باشه'
                    }).then((ok) => {
                        if (ok.value) {
                            $('#cargoModal').modal('hide');
                            _searchCargos(parseInt($('#page-number').text()));
                        }
                    });
                },
                error: function (response) {
                    alert(response.responseJSON.responseText)
                }
            })


        }

        function productEachSarfasl(parentId) {
            $.ajax({
                method: 'GET',
                url: "{{url('market/sessionParent')}}" + '/0/' + parentId
            }).done(function (data) {
                $.ajax({
                    method: 'GET',
                    url: "{{url('market/menuContent')}}"
                }).done(function (result) {
                    let dataToShow = parseResponse(result)
                    $("#menuContent").html("");
                    $("#menuContent:last").append(dataToShow).show().fadeIn("slow");
                    $('#search').show();
                    isScroll = 1;
                });
            });
        }

    </script>
@endsection
