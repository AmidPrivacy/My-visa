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
        <div class="appeal-search-area">
                <h3>Ölkələr üzrə müraciətlər </h3> 
                
        </div>
        <hr />
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Ad soyad</th>
                                <th class="table-primary">Ölkə</th> 
                                <th class="table-primary">Visa tipi</th> 
                                <th class="table-primary">Sığorta</th>
                                <th class="table-primary">E-mail</th>
                                <th class="table-primary">Mob nömrə</th> 
                                <th class="table-primary">Tarix</th> 
                                <!-- <th class="table-primary"></th> -->
                        </tr>
                </thead>
                <tbody>
                        @foreach($list as $index => $item)
                        <tr> 
                                <th class="">{{ $index+1 }}</th>
                                <td class=""> {{ $item->full_name }} </td>
                                <td class=""> {{ $item->country }} </td>
                                <td class=""> {{ $item->type }} </td> 
                                <td class=""> {{ $item->insure ==0 ? "Yoxdur" : "Var" }} </td>
                                <td class=""> {{ $item->mail }} </td>
                                <td class=""> {{ $item->number }} </td>
                                <td class=""> {{ $item->date }} </td>
                                <!-- <td class="table-light table-edit-field">
                                        <button type="button" class="btn btn-primary faq-edit" data-id="{{ $item->id }}">düzəliş et</button>
                                        <button type="button" class="btn btn-danger" onClick="removeRow({{ $item->id }}, '/admin/question-remove/')">sil</button> 
                                </td> -->
                        </tr>
                        @endforeach
                </tbody>
        </table>
 
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
        $("#my-form").attr("action", "/admin/question-add");
        document.getElementById("my-form").reset()
        $("#summernote").summernote("code", "")
      });

      $(document).on("click", ".faq-edit", function(){

                let id = $(this).attr("data-id");

                $("#my-form").attr("action", "/admin/question/"+id);

                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
            
                $.ajax({
                        url: "/admin/question/"+id,
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