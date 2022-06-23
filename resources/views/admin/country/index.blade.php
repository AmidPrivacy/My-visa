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

        <div class="country-filter">
                <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Ölkə axtar...">
                </div>
                <div class="input-group mb-3">
                        <select class="form-select" aria-label="Default select example">
                                <option selected value="0">Rəng seçin</option>
                                @foreach($colors as $color)
                                        <option value="{{ $color->id }}" style="background-color: {{ $color->name }}">{{ $color->type }}</option>
                                @endforeach
                        </select>
                </div>
        </div>
        <button type="button" class="btn btn-primary add-new-row" data-toggle="modal" data-target="#exampleModal">Yeni ölkə</button>
        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Ölkə</th>
                                <th class="table-primary">Şəkil</th>
                                <th class="table-primary">Rəng</th>
                                <th class="table-primary"></th>
                        </tr>
                </thead>
                <tbody>
                        @foreach($list as $index => $item)
                        <tr style="background-color: {{ $item->color }}"> 
                                <th class="">{{ $index+1 }}</th>
                                <td class=""> <a href="/country/{{ $item->id }}" target="_blank" style="color: black"> {{ $item->name }} </a> </td>
                                <td class="">
                                        <img src="../public/assets/uploads/flags/{{ $item->picture }}" class="table-describe" />
                                </td>
                                <td class=""> {{ $item->color." - ".$item->type }} </td>
                                <td class="table-edit-field">
                                        <!-- <button type="button" class="btn btn-primary">düzəliş et</button> -->
                                        <button type="button" class="btn btn-danger" onClick="removeRow({{ $item->id }}, '/admin/country-remove/')">sil</button> 
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
                                        <h5 class="modal-title" id="exampleModalLabel">Ölkə əlavəsi</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="/admin/country-add" enctype="multipart/form-data">
                                        <div class="modal-body">
                                                <div class="mb-3">
                                                        <label for="countryName" class="form-label">Ölkə adı</label>
                                                        <input type="text" class="form-control" name="name" id="countryName" placeholder="Ad daxil edin">
                                                </div>
                                                <div class="mb-3">
                                                        <label for="countryName" class="form-label">Ölkə üçün rəng seçimi</label>
                                                        <select class="form-select" aria-label="Default select example" name="color">
                                                                <option selected value="0">Rəng seçin</option>
                                                                @foreach($colors as $color)
                                                                        <option value="{{ $color->id }}" style="background-color: {{ $color->name }}">{{ $color->type }}</option>
                                                                @endforeach
                                                        </select>
                                                </div>
                                                <div class="mb-3">
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


        <script>

                $(function(){

                        $(".country-filter input").keypress(function(event){
                                let val = $(this).val();
                                var keycode = (event.keyCode ? event.keyCode : event.which);

                                if(val.length>0 && keycode == '13') {
                                        api(); 
                                } 
                        })

                        $(".country-filter .mb-3 select").change(api)

                        function api() {

                                let name = $(".country-filter .mb-3 input").val();
                                let color = $(".country-filter .mb-3 select").val();

                                $.ajax({
                                        url: "/admin/country-search",
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