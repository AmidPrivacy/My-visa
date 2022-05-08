@extends('layouts.app-master')

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
        
        <button type="button" class="btn btn-primary add-new-row" data-toggle="modal" data-target="#exampleModal">Yeni FAQ</button>
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Başlıq</th>
                                <th class="table-primary">Viza növü</th>
                                <th class="table-primary"></th>
                        </tr>
                </thead>
                <tbody>
                        @foreach($list as $index => $item)
                        <tr> 
                                <th class="table-light">{{ $index+1 }}</th>
                                <td class="table-light"> {{ $item->name }} </td>
                                <td class="table-light"> {{ $item->type }} </td>
                                <td class="table-light table-edit-field">
                                        <button type="button" class="btn btn-primary faq-edit" data-id="{{ $item->id }}">düzəliş et</button>
                                        <button type="button" class="btn btn-danger" onClick="removeRow({{ $item->id }}, '/admin/faq-remove/')">sil</button> 
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
                                        <h5 class="modal-title" id="exampleModalLabel">Viza növü əlavəsi</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="/admin/faq-add" id="my-form" enctype="multipart/form-data" id="my-form">
                                        <div class="modal-body">
                                                <div class="mb-3">
                                                        <label for="formFile" class="form-label">Viza növü seçin</label>
                                                        <select class="form-select" name="type" required>
                                                                @foreach($types as $item)
                                                                   <option value="{{ $item->id }}"> {{ $item->name }} </option> 
                                                                @endforeach
                                                        </select>                                                
                                                </div>
                                                <div class="mb-3">
                                                        <label for="type" class="form-label">Başlıq</label>
                                                        <input type="text" class="form-control" name="title" id="type" required placeholder="Kontent başlığını daxil edin">
                                                </div>
                                                <div class="file-lists">
                                                        <div class="input-group" style="margin-top: 7px; width: 98%; margin-left: 1%;">
                                                                <input type="file" class="form-control" id="inputGroupFile04" name="file" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                                <input type="text" class="form-control" name="name" id="special-file-name" placeholder="Fayl başlığı" />
                                                                <input type="hidden" name="check_place" value="0"/>
                                                                <button class="btn btn-outline-secondary addition-file-upload" type="button" id="inputGroupFileAddon04">Yüklə</button>
                                                        </div>
                                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                                                <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="flush-headingOne">
                                                                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                                                        Bütün fayllar
                                                                                </button>
                                                                        </h2>
                                                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
                                                                                <div class="accordion-body" style="max-height: 210px; overflow-y: scroll">
                                                                                        <ul class="list-group">
                                                                                                @foreach($files as $file)
                                                                                                <li class="list-group-item">{{ $file->file }} <span>{{ $file->name }}</span></li>
                                                                                                @endforeach
                                                                                        </ul>
                                                                                </div>
                                                                        </div>
                                                                </div>  
                                                        </div>
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
        $("#my-form").attr("action", "/admin/faq-add");
        document.getElementById("my-form").reset()
        $("#summernote").summernote("code", "")
      });

      $(".faq-edit").click(function(){

                let id = $(this).attr("data-id");

                $("#my-form").attr("action", "/admin/faq/"+id);

                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
            
                $.ajax({
                        url: "/admin/faq/"+id,
                        method: "get",
                        success: (res)=> {
                                console.log(res.data)

                                // $(".mb-3 textarea").val(res.data.data.content)
                                $("#type").val(res.data.name)
                                $("#summernote").summernote("code",res.data.content)
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
                                $(".file-lists .list-group").prepend("<li class='list-group-item'>"+res.data.file+" <span>"+res.data.name+"</span></li>")
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

    });
</script>
@endsection