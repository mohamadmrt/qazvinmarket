@extends('ocms.master')
@section('content')
    <!-- Modal -->
    <div class="modal fade" id="advertise" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                     style="background-color: aqua;border-top-right-radius:5px;border-top-left-radius:5px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal_title">ایجاد تبلیغات</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" id="create_advertise_error" style="display: none"></div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div id="image_show"></div>
                            <div class="input-group">
                                <label for="image">تصویر بنر را نتخاب کنید(طول:800 - ارتفاع:200):</label>
                                <input type="file" id="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="title">عنوان آگهی:</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="عنوان آگهی"
                                       value=""/>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="url">آدرس url:</label>
                                <input type="text" id="url" name="url" class="form-control" placeholder="آدرس url"
                                       value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="start_date">تاریخ شروع:</label>
                                <input type="text" class="form-control" data-mddatetimepicker="true"
                                       data-enabletimepicker="true" id="start_date" placeholder="تاریخ شروع"
                                       autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <label for="start_date">تاریخ پایان:</label>
                                <input type="text" class="form-control" data-mddatetimepicker="true"
                                       data-enabletimepicker="true" id="end_date" autocomplete="off"
                                       placeholder="تاریخ پایان" value=""/>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status">فعال:</label>
                            <div class="input-group">
                                <input id="status" checked name="status" value="true" type="checkbox"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-success" value="ذخیره" name="submit" type="submit" data-id="0"
                           id="submit_advertise" size="40">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dell_dialog" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"
                     style="background-color: violet;border-top-right-radius:5px;border-top-left-radius:5px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel" style="color: white;"> حذف تبلیغات </h4>
                </div>

                <div class="modal-body">
                    <div id="error_register" class="row col-md-12 error-log"></div>
                    <div id="success_register" class="row col-md-12 success-log"></div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <h4 id="text_cancel">
                                آیا می خواهید فیلد حذف شود؟
                            </h4>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" name="del_id" id="del_id" value="">
                            <input type="hidden" name="state" id="state" value="">
                            <input class="btn btn-danger" value="بله" name="submit" type="button" id="del_advertise"
                                   size="40">
                            <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
                            <br><br>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div class="panel panel-default panel-table radius2px">
                <div style="height: 50px;padding-top: 10px;display: inline;
    margin: 6px;">
                    <a title="ایجاد تبلیغات" class="openFood btn btn-info btn-lg" data-id="0" data-check="0"
                       data-toggle="modal" data-target="#advertise" style="margin: 5px;">
                        <span class="fas fa-plus-circle"></span>ایجاد تبلیغات
                    </a>
                </div>
                <br>
            </div>
            <div class="panel panel-info panel-table radius2px">
                <div class="panel-heading">
                    <div>نتایج یافت شده: <span id="total"></span></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="background-color: #969696;">
                        <tr>
                            <td nowrap="nowrap" style="text-align: center;width: 50px">شناسه</td>
                            <td nowrap="nowrap" style="text-align: center">نام سوپر مارکت</td>
                            <td nowrap="nowrap" style="text-align: center">عنوان</td>
                            <td nowrap="nowrap" style="text-align: center">آدرس</td>
                            <td nowrap="nowrap" style="text-align: center">بنر</td>
                            <td nowrap="nowrap" style="text-align: center;width: 20px">وضعیت</td>
                            <td nowrap="nowrap" style="text-align: center">کاربر ایجاد کننده</td>
                            <td nowrap="nowrap" style="text-align: center">تاریخ شروع</td>
                            <td nowrap="nowrap" style="text-align: center">تاریخ پایان</td>
                            <td nowrap="nowrap" style="text-align: center">تاریخ ایجاد</td>
                            <td style="text-align: center">عملیات</td>
                        </tr>
                        <tr>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_id"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_peyk_name">
                            </td>
                            <td><input class="search_filter" style="width: 100%" type="text" id="search_by_amount"></td>
                            <td><select class="search_filter" style="width: 100%" onchange="_search(1)" type="text"
                                        id="search_by_is_confirmed">
                                    <option value="">همه</option>
                                    <option value="1">تایید شده</option>
                                    <option value="0">تایید نشده</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody id="recordsTable">
                        <tr>
                            <td colspan="14">در حال دریافت اطلاعات...</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class=" " style="text-align:center; direction:rtl; margin-top:35px ;margin-bottom: 35px;">
                        <button id="first-page" class="btn paginate" style="float:none;margin: 1px"> <<</button>
                        <button id="prev-page" class="btn paginate" style="float:none;margin: 1px"> <</button>
                        <button id="page-number" class="btn btn-success" style="float:none;margin: 1px"> 1</button>
                        <button id="next-page" class="btn paginate" style="float:none;margin: 1px"> ></button>
                        <button id="last-page" class="btn paginate" style="float:none;margin: 1px"> >></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on("click", "#submit_advertise", function () {
            $('#create_advertise_error').html('');
            let formData = new FormData()
            formData.append('id', $(this).data('id'))
            formData.append('title', $('#title').val())
            formData.append('url', $('#url').val())
            formData.append('image', $('#image')[0].files[0])
            formData.append('start_date', $('#start_date').val())
            formData.append('end_date', $('#end_date').val())
            formData.append('status', $("#status").prop('checked'))
            $.ajax({
                headers: {"X-CSRF-Token": "{{ csrf_token() }}"},
                method: 'POST',
                contentType: false,
                processData: false,
                url: `/ocms/advertise`,
                data: formData,
                success: function (response) {
                    if (response.status === 'ok') {
                        $("#selected_cargo").val('');
                        $("#price_old").val('')
                        $("#price").val('')
                        $('#start_date').val('')
                        $('#end_date').val('')
                        $('#advertise').modal('hide')
                        swal({
                            type: 'success',
                            title: response.message
                        }).then((res) => {
                            _search(1)
                        });
                    }
                },
                error: function (response) {
                    $('#create_advertise_error').html(response.responseJSON.message).show()

                }
            })
        });

        $(document).on("click", ".delete_modal", function () {
            let id = $(this).data('id');
            $(this).parent().parent().css('background-color', 'violet')
            $('#del_id').val(id);
            $('#dell_dialog').modal('show');
        });
        $(document).on("click", ".edit_advertise", function () {
            let id = $(this).data('id');
            $(this).parent().parent().css('background-color', 'aqua')
            $.ajax({
                method: 'GET',
                url: `/ocms/advertise/${id}`,
                success: function (response) {
                    let advertise = response.data;
                    $('#submit_advertise').data('id', id);
                    $('#title').val(advertise.title)
                    $('#url').val(advertise.url)
                    $('#start_date').val(advertise.start_at)
                    $('#end_date').val(advertise.end_at)
                    $('#image_show').html(`<img alt="تصویر یافت نشد" src="${advertise.image}" class="img-thumbnail" style="height:100px">`)
                    $('#modal_title').text("ویرایش تبلیغات")
                    $('#advertise').modal('show');

                },
                error: function (response) {
                    $('#create_advertise_error').text(response.responseJSON.message).show()

                }
            })

        });
        //when hidden
        $('#dell_dialog,#advertise').on('hidden.bs.modal', function (e) {
            $('tr').css('background-color', '');
            $('#error').hide()
            $('#title').val('')
            $('#image').val('')
            $('#url').val('')
            $('#price').val('')
            $('#start_date').val('')
            $('#end_date').val('')
            $('#submit_advertise').data('id', 0);
            $('#modal_title').text("ایجاد تبلیغات")
            $('#create_advertise_error').hide()
            $('#image_show').html('')
        });
        $("#del_advertise").click(function () {
            let id = $("#del_id").val();
            $.ajax({
                method: 'DELETE',
                url: `/ocms/advertise/${id}`,
                data: {_token: "{{csrf_token()}}"},
                success: function (data) {
                    if (data.status === 'ok') {
                        $('#dell_dialog').modal('hide');
                        swal({
                            type: 'success',
                            title: data.message
                        }).then((res) => {
                            _search(1);

                        });
                    } else {
                        swal({
                            type: 'error',
                            title: data.message
                        });
                        $('#dell_dialog').modal('hide');
                    }
                }

            });
        });
        _search = function (page) {
            $.ajax({
                method: 'POST',
                url: `/ocms/advertise_list?page=${page}`,
                data: {"_token": "{{ csrf_token() }}"},
                success: function (result) {
                    let advertises = result.data;
                    let paginate = result.paginate;
                    let data = '';
                    if (advertises.length < 1) {
                        $('#recordsTable').html("");
                    } else {
                        $.each(advertises, function (key, item) {
                            data += `<tr>`;
                            data += `<td>${item.id}</td>`;
                            data += `<td>${item.market_name}</td>`;
                            data += `<td>${item.title}</td>`;
                            data += `<td><a target="_blank" href="${item.url}">${item.url}</a></td>`;
                            data += `<td><img class="img-thumbnail" src="${item.image}" style="height:100px" alt=""></td>`;
                            data += `<td><div class="label ${item.status === 'فعال' ? "label-success" : "label-danger"}">${item.status}</div></td>`;
                            data += `<td>${item.user_name}`;
                            data += `<td>${item.start_at}`;
                            data += `<td>${item.end_at}`;
                            data += `<td>${item.created_at}`;
                            data += `<td>
                                    <button type="button" title=" ویرایش" data-id="${item.id}" class="btn btn-block btn-info edit_advertise" data-toggle="modal">
                                    <span class="fa fa-pencil"></span>
                                    </button>
                                    <button title="حذف" type="button" data-id=${item.id} class="btn btn-block delete_modal btn-danger"><span class="fas fa-trash-alt"></span></button></td>`;
                            data += `</tr>`;


                        })
                        $('#recordsTable').html(data);
                        $('#total').html(paginate.total);
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
                    $('#recordsTable').html(`<a class="btn btn-warning" onclick="_search(1)">تلاش مجدد<i class="fas fa-repeat"></i></a>`);
                }
            })
        };
        _search(1);
        $(document).on("keyup", ".search_filter", function () {
            _search(1);
        })
        $(document).on("click", ".paginate", function () {
            _search($(this).attr('page'));
        })

    </script>
@endsection
