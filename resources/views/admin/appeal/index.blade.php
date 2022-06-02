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
        <div class="faq-search-area">
               <h3> Müraciətlər </h3> 
        </div>
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Ad</th>
                                <th class="table-primary">Soyad</th>
                                <th class="table-primary">Nömrə</th>
                                <th class="table-primary">Status</th>
                                <th class="table-primary"></th>
                        </tr>
                </thead>
                <tbody>
                        @foreach($list as $index => $item)
                        <tr> 
                                <th class="table-light">{{ $index+1 }}</th>
                                <td class="table-light"> {{ $item->name }} </td>
                                <td class="table-light"> {{ $item->surname }} </td>
                                <td class="table-light"> {{ $item->number }} </td>
                                <td class="table-light table-edit-field">
                                        <button type="button" class="btn btn-primary step-edit" data-id="{{ $item->id }}"> {{ $item->step }} </button>
                                </td>
                                <td class="table-light table-edit-field">
                                        <button type="button" class="btn btn-danger appoint-user" data-id="{{ $item->id }}">Köçür</button> 
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
                                        <h5 class="modal-title" id="exampleModalLabel">Müraciət növü seçin</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="/admin/edit-status" id="my-form" enctype="multipart/form-data" id="my-form">
                                        <div class="modal-body"> 
                                                <div class="mb-3">
                                                        <select class="form-select" name="step" required id="visa-type">
                                                                @foreach($steps as $item)
                                                                   <option value="{{ $item->id }}"> {{ $item->name }} </option> 
                                                                @endforeach
                                                        </select>      
                                                        <select class="form-select" name="user" required id="selected-user">
                                                                @foreach($users as $item)
                                                                   <option value="{{ $item->id }}" {{ $item->id===auth()->user()->id ? "selected":"" }} > {{ $item->name }} </option> 
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

<script src="{!! url('assets/js/summernote.min.js') !!}"></script>


<script>
    $(document).ready(function() {
         
        $(document).on("click", ".step-edit", function(){

                let id = $(this).attr("data-id");

                $("#my-form").attr("action", "/admin/edit-status");
                $("#selected-row").val(id);

                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                $("#visa-type").css("display", "block");
                $("#selected-user").css("display", "none");
                myModal.show();
        })

        $(document).on("click", ".appoint-user", function() {

                let id = $(this).attr("data-id");

                $("#my-form").attr("action", "/admin/appoint-user");
                $("#selected-row").val(id);

                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                $("#visa-type").css("display", "none");
                $("#selected-user").css("display", "block");
                myModal.show();

        })
 
 
    });
</script>
@endsection