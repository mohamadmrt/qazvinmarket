@extends('user.master')
@section('content')
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form" id="AddressForm" role="form" >
                    <input type="hidden" id="id">
                    <div class="modal-header">
{{--                        <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                        <h4 class="modal-title" id="title">افزودن آدرس</h4>
                    </div>
                    <div id="ErrorMessage">
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="type">عنوان آدرس (مثلا منزل):</label>
                            <input type="text" class="form-control" name="type" id="label" >
                        </div>
                        <div class="form-group">
                            <label for="zonez">منطقه پیک:</label><br>
                            <select name="zones" id="zones" required="" style="width:80%; padding:5px; border:#999 1px solid;">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">آدرس دقیق:</label>
                            <input style="width: 80%;" type="text" class="form-control" name="address" id="address" value="">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="set_type" id="is_default">
                            <label for="set_type">آدرس پیش فرض </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" title="ذخیره" id="update" ><i class="far fa-save"></i> ذخیره</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" title="خروج"><i class="fas fa-window-close"></i> خروج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center">
    <div class="form-group">
        <a class="btn btn-danger btn-lg" data-toggle="modal" id="addAddress" data-target="#add">
            <span class="fas fa-map-marker-plus"></span> افزودن آدرس جدید
        </a>
    </div>
    </div>
    <div class="col-md" id="content"></div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            _getAddresses();
        });
        $("#add").on('hide.bs.modal', function(){
            _emptyVal()
        });
        function _emptyVal() {
            $('#id').val('');
            $('#label').val('');
            $('#zones').val('');
            $('#address').val('');
            $('#is_default').prop('checked',false)
        }
        function _getAddresses(){
            let token=localStorage.getItem('token');
            $.ajax({
                method: 'GET',
                url: "{{url('api/v1/address')}}",
                data: {'token':token}
            }).done(function (response) {
                let addresses=response.addresses;
                if(response.status==='ok'){
                    localStorage.setItem('addresses',JSON.stringify(addresses))
                    let data=``;
                    $.each(addresses,function(key,item){
                        data+=`<div id="${item.id}" class="panel  ${item.is_default==="1"?'panel-success':'panel-default'} text-center" title="${item.is_default==="1"?'آدرس پیشفرض':''}">`;
                        data+=`<div class="panel-heading">`;
                        data+=`<i class="fas fa-user"></i> عنوان آدرس: <strong>${item.label}</strong>${item.is_default==="1"?'<i class="fas fa-check pull-right" title="آدرس پیشفرض"></i>':''}`;
                        data+=`</div>`;
                        data+=`<div class="panel-body">`;
                        data+=`<ul>`;
                        data+=`<li style="list-style-type: none;"><i class="fas fa-map-marker"></i> آدرس: <strong>${item.address}</strong></li>`;
                        data+=`<li style="list-style-type: none;"><i class="fas fa-map-marked"></i> منطقه پستی: <span>${item.zones}</span></li>`;
                        data+=`</ul>`;
                        data+=`</div>`;
                        data+=`<div class="panel-footer text-left">`;
                        data+=`<a href="#" class="delete" title="حذف آدرس" ><i class="far fa-trash-alt text-danger" style="font-size: 16px"></i></a>`;
                        data+=`<a href="#" class="edit" title="ویرایش آدرس"  data-toggle="modal" data-target="#add"><i class="far fa-edit text-info" style="font-size: 16px"></i></a>`;
                        data+=`</div>`;
                        data+=`</div>`;
                    })
                    $('#content').html(data);
                }
            });
        }
        function _getZones(zones_id){
            $.ajax({
                method: 'GET',
                url: "{{url('api/v1/get_post_area')}}",
            }).done(function (response) {
                if(response.status==='ok'){
                    let zones=response.areas;
                    let data=``;
                    $.each(zones,function(key,item){
                        data+=`<option ${item.id===zones_id?'selected':''} value="${item.id}">${item.zones}</option>`;
                    })
                    $('#zones').html(data);
                }
            });
        }
        $(document).on('click','.delete',function(e) {
            e.preventDefault();
            swal({
                title: 'از حذف مطمئن هستید؟',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value){
                    let id = $(this).parent().parent().attr("id");
                    let token=localStorage.getItem('token');
                    $.ajax({
                        type: "POST",
                        url: "{{url('api/v1/address')}}" + '/' + id,
                        data:{"_method":"DELETE",'token':token},
                        success: function (response) {
                            if(response.status==='ok'){
                                _getAddresses();
                                swal({
                                    title: 'حذف شد!',
                                    text: 'آدرس مورد نظر حذف شد',
                                    type: 'success',
                                    confirmButtonText: 'باشه'
                                })
                            }

                        }
                    });

                }
            })
        });
        $(document).on('click','.edit',function(e) {
            e.preventDefault();
            let id = $(this).parent().parent().attr("id");
            let token=localStorage.getItem('token');
            $('#title').text('ویرایش آدرس')
            $.ajax({
                type: "GET",
                url: "{{url('api/v1/address')}}" + '/' + id+'/edit',
                data:{'token':token},
                success: function (response) {
                    if(response.status==='ok'){
                            $('#label').val(response.data.label)
                            $('#address').val(response.data.address)
                            $('#id').val(response.data.id)
                            $('#is_default').prop('checked',response.data.is_default === "1")
                      _getZones(response.data.zones_id);

                    }

                }
            });
        });
        $(document).on('click','#update',function(e) {
            e.preventDefault();
            let id = $('#id').val();
            let token=localStorage.getItem('token');
            let label=$('#label').val();
            let peyk_id=$('#zones').val();
            let address=$('#address').val();
            let is_default=$('#is_default').prop('checked')
            let url= "api/v1/address" ;
            let method="POST";
            if(id!==""){
                 url= "api/v1/address/"+id;
                 method="PUT";
            }
            $.ajax({
                type: "POST",
                url: url,
                data:{'token':token,"_method":method,'label':label,'peyk_id':peyk_id,'address':address,'is_default':is_default},
                success: function (response) {
                    if(response.status==='ok'){
                        _getAddresses();
                        _emptyVal();
                        $('#add').modal('hide');
                    }

                }
            });
        });
        $(document).on('click','#addAddress',function(e) {
            e.preventDefault();
           _getZones(0);
        });
    </script>
@endpush
