@extends('layouts.app-master')

@section('admin-content')
<div class="bg-light p-5 rounded">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block"> 
                <strong>{{ $message }}</strong>
        </div> 
        @endif

        @if ($error = Session::get('error'))
        <div class="alert alert-error alert-danger"> 
                <strong>{{ $error }}</strong>
        </div> 
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger"> 
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- <div class="country-filter">
                <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Ölkə axtar...">
                </div>
        </div> -->
        <!-- <button type="button" class="btn btn-primary add-new-row" data-toggle="modal" data-target="#exampleModal">Yeni ölkə</button> -->
        <h3 style=" margin-bottom: 20px"> İSTİFADƏÇİLƏR </h3>  
        <hr/>
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">İstifadəçi</th> 
                                @if(auth()->user()->role_id === 3)
                                <th class="table-primary">Admin icazəsi</th>
                                @endif
                                <th class="table-primary">Müraciət icazəsi</th>
                                <th class="table-primary"></th>
                        </tr>
                </thead>
                <tbody>
                        @foreach($list as $index => $item)
                        <tr> 
                                <th class="">{{ $index+1 }}</th>
                                <td class=""> {{ $item->name }}  </td>
                                @if(auth()->user()->role_id === 3)
                                <td class=""> 
                                        <button class="btn btn-outline-secondary  add-admin-role" data-id="{{ $item->id }}"> {{ $item->role }} </button> 
                                </td> 
                                @endif
                                <td class=""> 
                                        @foreach($item->types as $type) 
                                                <span class="badge bg-primary" style="line-height: 25px">
                                                        {{ $type->name }}
                                                        <button type="button" class="btn-close" aria-label="Close" 
                                                        style="position: relative; top: 3px"onClick="removeRow({{ $type->id }}, '/admin/appeal-role-delete/')"></button>
                                                </span> 
                                        @endforeach
                                        <button type="button" class="btn btn-primary add-appeal-role" data-id="{{ $item->id }}" 
                                                style="height: 30px; line-height: 13px">Yeni+</button>
                                </td>
                                <td class="table-edit-field">
                                        <!-- <button type="button" class="btn btn-primary">düzəliş et</button> -->
                                        <button type="button" class="btn btn-danger" onClick="removeRow({{ $item->id }}, '/admin/delete-user/')">sil</button> 
                                </td>
                        </tr>
                        @endforeach
                </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">İcazə əlavəsi</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="/admin/country-add" enctype="multipart/form-data" id="my-form">
                                        <div class="modal-body">
                                                <div class="mb-3 user-role-selection">
                                                        <select class="form-select" name="admin_role" required id="admin-role">
                                                                @foreach($adminRoles as $item)
                                                                   <option value="{{ $item->id }}"> {{ $item->name }} </option> 
                                                                @endforeach
                                                        </select>      
                                                        <select class="form-select" name="appeal_role" required id="appeal-role">
                                                                @foreach($appealTypes as $item)
                                                                   <option value="{{ $item->id }}" > {{ $item->name }} </option> 
                                                                @endforeach
                                                        </select> 
                                                </div> 
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" id="selected-row" name="id" value="" />
                                        </div>
                                        <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Göndər</button>
                                        </div>
                                </form>
                        </div>
                </div>
        </div>
</div>


        <script>

                $(function(){

                        $(document).on("click", ".add-admin-role", function(){

                                let id = $(this).attr("data-id");

                                $("#my-form").attr("action", "/admin/admin-role-edit");
                                $("#selected-row").val(id);

                                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                                $("#admin-role").css("display", "block");
                                $("#appeal-role").css("display", "none");
                                myModal.show();

                        })

                        $(document).on("click", ".add-appeal-role", function(){

                                let id = $(this).attr("data-id");

                                $("#my-form").attr("action", "/admin/appeal-role-edit");
                                $("#selected-row").val(id);

                                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                                $("#admin-role").css("display", "none");
                                $("#appeal-role").css("display", "block");
                                myModal.show();

                        })

                        $(".country-filter input").keypress(function(event){
                            let val = $(this).val();
                            
                            var keycode = (event.keyCode ? event.keyCode : event.which);

                            if(val.length>0 && keycode == '13') {
                                        $.ajax({
                                                url: "/admin/country-search/"+val,
                                                method: "get",
                                                success: (res)=>{
                                                        console.log(res.data);


                                                        let str = "";

                                                        (res.data).forEach((item, index)=>{
                                                                str += `
                                                                        <tr style="background-color: ${ item.color }"> 
                                                                                <th class="">${index+1}</th>
                                                                                <td class=""> <a href="/country/${item.id}" target="_blank" style="color: black"> ${item.name} </a> </td>
                                                                                <td class="">
                                                                                        <img src="../public/assets/uploads/flags/${item.picture}" class="table-describe" />
                                                                                </td>
                                                                                <td class="">${item.color != null ? item.color : ""} - ${ item.type != null ? item.type : "" } </td>
                                                                                <td class="table-edit-field">
                                                                                        <button type="button" class="btn btn-danger" onClick="removeRow( ${ item.id }, '/admin/country-remove/')">sil</button> 
                                                                                </td>
                                                                        </tr>
                                                                `;
                                                        })

                                                        $(".table tbody").html(str);
                                                }
                                        })
                                } 
                        })


                })

        </script>


@endsection