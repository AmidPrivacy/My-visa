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
      
        <button type="button" class="btn btn-primary add-new-row" data-toggle="modal" data-target="#exampleModal">Yeni bloq</button>
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Başlıq</th>
                                <th class="table-primary">Kontent</th>
                                <th class="table-primary">Şəkil</th>
                                <th class="table-primary">Tarix</th> 
                                <th class="table-primary"></th>
                        </tr>
                </thead>
                <tbody>
                        @foreach($list as $index => $item)
                        <tr> 
                                <th class="">{{ $index+1 }}</th>
                                <td class=""> {{ $item->title }} </td>
                                <td class=""> {!! $item->content !!} </td> 
                                <td class="">
                                        <img src="../public/assets/uploads/tour-images/{{ $item->picture }}" class="table-describe" />
                                </td>
                                <td class=""> {{ $item->created_at }} </td>
                                <td class="table-light table-edit-field">
                                        <button type="button" class="btn btn-primary faq-edit" data-id="{{ $item->id }}">düzəliş et</button>
                                        <button type="button" class="btn btn-danger" onClick="removeRow({{ $item->id }}, '/admin/blog-remove/')">sil</button> 
                                </td>
                        </tr>
                        @endforeach
                </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content" style="width:900px; margin-left: -180px">
                                <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Bloq əlavəsi</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="/admin/blog-add" id="my-form" enctype="multipart/form-data" id="my-form">
                                        <div class="modal-body"> 
                                                <div class="mb-3">
                                                        <label for="title" class="form-label">Başlıq</label>
                                                        <input type="text" class="form-control" name="title" id="title" placeholder="Kontent başlığını daxil edin">
                                                </div>
                                                <div class="mb-3">
                                                        <label for="formFile" class="form-label">Şəkil daxil edin</label>
                                                        <input class="form-control" type="file" id="formFile" name="image">
                                                </div>
                                                <div class="mb-3">
                                                        <label for="type" class="form-label">Kontent</label>
                                                        <textarea id="summernote" name="content" required></textarea>
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
    $(document).ready(function() {
        $('#summernote').summernote({
                placeholder: 'Kontent daxil edin',
                tabsize: 2,
                height: 500,
                focus: true
                // airMode: true
        });

      $(".add-new-row").click(function(){  
        $("#my-form").attr("action", "/admin/blog-add");
        document.getElementById("my-form").reset()
        $("#summernote").summernote("code", "")
      });

      $(document).on("click", ".faq-edit", function(){

                let id = $(this).attr("data-id");

                $("#my-form").attr("action", "/admin/blog/"+id);

                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
            
                $.ajax({
                        url: "/admin/blog/"+id,
                        method: "get",
                        success: (res)=> { 

                                $("#title").val(res.data.title); 
                                
                                $("#summernote").summernote("code",res.data.content);
                        }
                })

                myModal.show();
      })

      $(".addition-file-upload").click(function() {
              if(($("#special-file-name").val()).length>0 && document.getElementById("inputGroupFile04").files.length > 0) {
                var form = $('#my-form')[0];
                var formData = new FormData(form);
                $.ajax({
                        url: "/admin/file-add",
                        method: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                                $(".file-lists .list-group").prepend("<li class='list-group-item'>https://visa.e-beledci.az/../public/assets/uploads/files/"+res.data.file+" <span>"+res.data.name+"</span></li>")
                                alert("Fayl uğurla əlavə edildi");
                                $("#special-file-name").val("");
                                $("#inputGroupFile04").val("");
                        },
                        error: function (e) {
                                alert("Uğursuz")
                        }
                })

              } else {
                      alert("Zəhmət olmasa fayl və başlıq daxil edin");
              }
      })


        $(".faq-search-area input").keypress(function(event){
                
                var keycode = (event.keyCode ? event.keyCode : event.which);

                if(keycode == '13') {
                        api();
                } 
        })

        $(".faq-search-area select").change(api)

        function api() {

                let title = $(".faq-search-area input").val();
                let type = $('.faq-search-area select').val();

                $.ajax({
                        url: "/admin/faq-search/",
                        method: "get",
                        data: { title, type },
                        success: (res)=>{

                                let str = "";

                                (res.data).forEach((item, index)=>{
                                        str += `
                                                <tr> 
                                                        <th class="table-light">${index+1}</th>
                                                        <td class="table-light"> ${item.name==null?"":item.name} </td>
                                                        <td class="table-light"> ${item.type } </td>
                                                        <td class="table-light table-edit-field">
                                                                <button type="button" class="btn btn-primary faq-edit" data-id="${item.id}">düzəliş et</button>
                                                                <button type="button" class="btn btn-danger" onClick="removeRow(${item.id}, '/admin/faq-remove/')">sil</button> 
                                                        </td>
                                                </tr>
                                        `;
                                })

                                $(".table tbody").html(str);
                        }
                })

        }



    });
</script>
@endsection