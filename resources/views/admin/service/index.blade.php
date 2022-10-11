@extends('layouts.app-master')
@section('css')
<link href="{!! url('assets/css/summernote.min.css') !!}" rel="stylesheet">
@endsection
@section('admin-content')
<div class="bg-light p-5 rounded">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block"> 
                <strong>{{ $message }}</strong>
        </div> 
        @endif

        @if ($error = Session::get('error'))
        <div class="alert alert-error alert-block"> 
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

        <div class="country-filter">
                <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Xidmət axtar...">
                </div> 
        </div>
        <button type="button" class="btn btn-primary add-new-row" data-toggle="modal" data-target="#exampleModal">Yeni xidmət</button>
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Xidmət</th>
                                <th class="table-primary">Kontent</th>
                                <th class="table-primary">Şəkil</th>
                                <th class="table-primary"></th>
                        </tr>
                </thead>
                <tbody>
                        @foreach($list as $index => $item)
                        <tr> 
                                <th class="">{{ $index+1 }}</th>
                                <td class=""> 
                                       {{ $item->name }}
                                </td>
                                <td class=""> 
                                       {!! $item->content !!}
                                </td>
                                <td class="">
                                        <img src="../public/assets/uploads/service-images/{{ $item->picture }}" class="table-describe" data-id="{{ $item->id }}" />
                                </td> 
                                <td class="table-edit-field">
                                        <button type="button" class="btn btn-primary row-edit" data-id="{{ $item->id }}">düzəliş et</button>
                                        <button type="button" class="btn btn-danger" onClick="removeRow({{ $item->id }}, '/admin/service-remove/')">sil</button> 
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
                                        <h5 class="modal-title" id="exampleModalLabel">Xidmət əlavəsi</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="/admin/service-add" enctype="multipart/form-data" id="my-form">
                                        <div class="modal-body">
                                                <div class="mb-3">
                                                        <label for="serviceName" class="form-label">Xidmət adı *</label>
                                                        <input type="text" class="form-control" name="name" id="serviceName" placeholder="Ad daxil edin">
                                                </div> 
                                                <div class="mb-3">
                                                        <label for="type" class="form-label">Kontent</label>
                                                        <textarea id="summernote" name="content"></textarea>
                                                </div>
                                                <div class="mb-3" id="picture">
                                                        <label for="formFile" class="form-label">Şəkil daxil edin</label>
                                                        <input class="form-control" type="file" id="formFile" name="image">
                                                </div>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        </div>
                                        <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Göndər</button>
                                        </div>
                                </form>
                        </div>
                </div>
        </div>
</div>

        <script src="{!! url('assets/js/summernote.min.js') !!}"></script>
        <script>

                $(function() {

                        $(".add-new-row").click(function() {  
                                $("#my-form").attr("action", "/admin/service-add");
                                $(".modal-body>div").show();
                                document.getElementById("my-form").reset()
                                $("#summernote").summernote("code", "")
                        });

                        $(document).on("click", ".table-describe", function() {
                                let id = $(this).attr("data-id");
                                $("#my-form").attr("action", "/admin/service-image/"+id);
                                $(".modal-body>div").hide();
                                $("#picture").show();
                                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                                myModal.show();
                        });

                        $('#summernote').summernote({
                                placeholder: 'Kontent daxil edin',
                                tabsize: 2,
                                height: 500,
                                focus: true
                                // airMode: true
                        });

                        $(".country-filter input").keypress(function(event){
                                let val = $(this).val();
                                var keycode = (event.keyCode ? event.keyCode : event.which);

                                if(val.length>0 && keycode == '13') {
                                        api(); 
                                } 
                        });

                        $(document).on("click", ".row-edit", function(){

                                let id = $(this).attr("data-id");

                                $("#my-form").attr("action", "/admin/service/"+id);
                                $(".modal-body>div").show();
                                $("#picture").hide();
                                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});

                                $.ajax({
                                        url: "/admin/service/"+id,
                                        method: "get",
                                        success: (res)=> { 

                                                $("#serviceName").val(res.data.name);

                                                $("#summernote").summernote("code",res.data.content);
                                                
                                        }
                                })

                                myModal.show();

                        });

                        $(".country-filter .mb-3 select").change(api)

                        
                        function api() {

                                let name = $(".country-filter .mb-3 input").val();
                                let color = $(".country-filter .mb-3 select").val();

                                $.ajax({
                                        url: "/admin/service-search",
                                        method: "get",
                                        data: {
                                                name, color
                                        },
                                        success: (res)=>{ 
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
                                });

                        }


                })

        </script>


@endsection