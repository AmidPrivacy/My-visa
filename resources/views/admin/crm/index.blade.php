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


        <table class="table">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Ölkə</th>
                                <th class="table-primary">Viza tipi</th>
                                <th class="table-primary">Nömrə</th>
                                <th class="table-primary">Qeyd</th>
                                <th class="table-primary">Tarix</th> 
                                <th class="table-primary"></th> 
                        </tr>
                </thead>
                <tbody>
                        @foreach($calls as $index => $item)
                        <tr> 
                                <th class="table-light">{{ $index+1 }}</th>
                                <th class="table-light">{{ $item->country }}</th>
                                <th class="table-light">{{ $item->type }}</th>
                                <th class="table-light">{{ $item->citizen_number }}</th>
                                <th class="table-light">{{ $item->note }}</th>
                                <th class="table-light">{{ $item->created_at }}</th> 
                                <th class="table-light"><button type="button" class="btn btn-danger appoint-user" data-id="{{ $item->id }}">Düzəliş et</button> </th> 
                        </tr>
                        @endforeach
                </tbody>
        </table>


        <form action="/set-call" method="post" style="margin-top: 120px">
                <div class="row">
                        <div class="col">
                                <select class="form-select" aria-label="Default select example">
                                        <option selected value="0">Ölkə seçin</option>
                                        @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option> 
                                        @endforeach
                                </select>
                        </div>
                        <div class="col">
                                <select class="form-select" aria-label="Default select example">
                                        <option selected value="0">Viza növü seçin</option> 
                                </select>
                        </div>
                        <div class="col"> 
                                <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="050 522 17 86">
                        </div>
                </div> 
                <div class="mb-3" style="margin-top: 15px">
                        <label for="exampleFormControlTextarea1" class="form-label">Qeyd</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="float: right">Məlumatları yenilə</button>
        </form>
 
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