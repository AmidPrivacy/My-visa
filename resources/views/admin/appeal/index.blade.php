@extends('layouts.app-master')
@section('css') 
<link href="{!! url('assets/css/bootstrap-datepicker.min.css') !!}" rel="stylesheet" /> 
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
               <h3> Müraciətlər </h3> 
               <div class="search-fields">
                        <input id="search-fist-name" placeholder="Ad" />
                        <input id="search-last-name" placeholder="Soyad" />
                        <input id="search-number" placeholder="Nömrə"/>
                        <select id="search-step" style="width: 15%">
                                @foreach($steps as $item)
                                        <option value="{{ $item->id }}"> {{ $item->name }} </option> 
                                @endforeach
                        </select>  
                        <div class="input-group input-daterange">
                                <input type="text" class="form-control range-first" placeholder="Başlama tarixi" data-date-format="yyyy-mm-dd">
                                <div class="input-group-addon">-</div>
                                <input type="text" class="form-control range-second" placeholder="Son  tarix" data-date-format="yyyy-mm-dd">
                        </div>
                        <button>Axtar</button>
               </div>
        </div>
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Ad</th>
                                <th class="table-primary">Soyad</th>
                                <th class="table-primary">Nömrə</th>
                                <th class="table-primary">Müraciət tipləri</th>
                                <th class="table-primary">Status</th> 
                                <th class="table-primary">Tarix</th> 
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
                                <td class="table-light"> 
                                        @foreach($item->types as $type) 
                                                <a href="{{ $type->path }}" class="appeal-type-list" target="_blank"> {{ $type->name }} </a>
                                        @endforeach
                                </td>
                                <td class="table-light table-edit-field">
                                        <button type="button"  class="btn btn-primary step-edit" data-id="{{ $item->id }}"> {{ $item->step }} </button>
                                </td>
                                <td class="table-light"> {{ $item->date }} </td>
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
 
<script src="{!! url('assets/js/bootstrap-datepicker.min.js') !!}"></script>


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

        $(".appeal-search-area button").click(function(){
                let name = $("#search-fist-name").val();
                let surName = $("#search-last-name").val();
                let number = $("#search-number").val();
                let status = $("#search-step").val();
                let startDate = $(".input-daterange .range-first").val();
                let endDate = $(".input-daterange .range-second").val();

                if(name.length>0 || surName.length>0 || number.length>0 || status.length>0 || startDate.length>0 || endDate.length>0) {
                        
                        $.ajax({
                                url: "/admin/appeal-search",
                                method: "get",
                                data: {
                                        name, surName, number, status, startDate, endDate
                                },
                                success: (res)=>{
                                        console.log(res.data);


                                        let str = "";

                                        (res.data).forEach((item, index)=>{
                                                let types="";
                                                item.types.forEach(function(type){           
                                                        types += "<a href="+type.path+" class='appeal-type-list' target='_blank'>"+type.name+" </a>";
                                                });  
                                                str += `<tr> 
                                                        <th class="table-light"> ${ index+1 }</th>
                                                        <td class="table-light"> ${ item.name } </td>
                                                        <td class="table-light"> ${ item.surname } </td>
                                                        <td class="table-light"> ${ item.number } </td>
                                                        <td class="table-light"> 
                                                             ${types}
                                                        </td>
                                                        <td class="table-light table-edit-field">
                                                                <button type="button" class="btn btn-primary step-edit" data-id="${ item.id }"> ${ item.step } </button>
                                                        </td>
                                                        <td class="table-light"> ${ item.date } </td>
                                                        <td class="table-light table-edit-field">
                                                                <button type="button" class="btn btn-danger appoint-user" data-id="${ item.id }">Köçür</button> 
                                                        </td> 
                                                </tr>`;
                                        })

                                        $(".table tbody").html(str);
                                }
                        })

                }
        })
 
        $(".input-daterange input").each(function () {
                $(this).datepicker("clearDates");
        });
 
    });
</script>
@endsection