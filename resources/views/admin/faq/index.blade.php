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
                                <form method="post" action="/admin/faq-add" id="my-form" enctype="multipart/form-data">
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
                                                        <input type="text" class="form-control" name="name" id="type" required placeholder="Kontent başlığını daxil edin">
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


    });
</script>
@endsection