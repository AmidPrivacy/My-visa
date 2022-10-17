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
      
       <section style="margin-top: 50px">
                @foreach($list as $item)

                <form class="form-inline" method="post" action="admin/contact-update/{{ $item->id }}">
       
                        <div class="form-group mx-sm-3 mb-2">
                                <label for="inputPassword2" class="sr-only" style="display: block">
                                        @if($item->id===1)
                                           Nömrə
                                        @elseif($item->id===2)
                                           Ünvan
                                        @elseif($item->id===3)
                                           Facebook
                                        @elseif($item->id===4)
                                           Instagram
                                        @elseif($item->id===5)
                                           Youtube
                                        @elseif($item->id===6)
                                           E-mail
                                        @else 
                                           Twitter
                                        @endif 
                                </label>
                                <input type="text" class="form-control" style="width: 70%; float: left" {{ $item->is_deleted===0 ? "" : "disabled" }}  value="{{ $item->name }}">
                                <button type="submit" class="btn btn-primary mb-2" style="margin-left: 1%" {{ $item->is_deleted===0 ? "" : "disabled" }}>Yenilə</button>
                                <a href="/admin/contact/{{ $item->id }}/{{ $item->is_deleted }}">
                                        <button type="button" class="btn btn-danger" style="position: relative; bottom: 4px">  
                                                @if($item->is_deleted===0)       
                                                        Sil
                                                @else
                                                        Aktivləşdir
                                                @endif
                                        </button>
                                </a>
                        </div>
                        

                </form>
  
                @endforeach
       </section>
 
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
        $("#my-form").attr("action", "/admin/tour-add");
        document.getElementById("my-form").reset()
        $("#summernote").summernote("code", "")
      });

      $(document).on("click", ".faq-edit", function(){

                let id = $(this).attr("data-id");

                $("#my-form").attr("action", "/admin/tour/"+id);

                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
            
                $.ajax({
                        url: "/admin/tour/"+id,
                        method: "get",
                        success: (res)=> { 

                                $("#title").val(res.data.title);

                                $("#period").val(res.data.period);
                                $("#price").val(res.data.price);
                                
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
                                $(".file-lists .list-group").prepend("<li class='list-group-item'>https://myvisa.az/../public/assets/uploads/files/"+res.data.file+" <span>"+res.data.name+"</span></li>")
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