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

        <form action="/crm/update-call" method="post" class="call-form">
                <div class="row">
                        <div class="col">
                                <select class="form-select" id="selected-country" name="country">
                                        <option selected value="0">Ölkə seçin</option>
                                        @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option> 
                                        @endforeach
                                </select>
                        </div>
                        <div class="col">
                                <div class="input-group date" id="document-date">
                                        <input type="text" class="form-control" name="document_date" placeholder="Pasportun bitmə tarixi" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                </div>
                        </div>
                        <div class="col"> 
                                <input type="number" name="number" readonly class="form-control" placeholder="050 522 17 86">
                        </div>
                </div> 
                
                <div class="row" style="margin-top: 8px">
                        <div class="col form-all-radios">
                                <span>
                                        3-5 İL erzində səyahət(shengen vizaları .UK.ABŞ.Kanada) 
                                </span>
                                <div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_travel" checked value="">
                                                <label class="form-check-label" >Seçilməyib</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_travel" value="1">
                                                <label class="form-check-label">Bəli</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_travel" value="0">
                                                <label class="form-check-label">Xeyr</label>
                                        </div>
                                </div>  
                        </div>
                        <div class="col form-all-radios">
                                <span>
                                        Aile veziyyəti 
                                </span>
                                <div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="family_case" checked value="">
                                                <label class="form-check-label">Seçilməyib</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="family_case" value="1">
                                                <label class="form-check-label">Evli</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="family_case" value="0">
                                                <label class="form-check-label">Subay</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="family_case" value="2">
                                                <label class="form-check-label">Boşanmış</label>
                                        </div>
                                </div>  
                        </div>
                </div>
                <div class="row" style="margin-top: 8px">
                        <div class="col form-all-radios">
                                <span>
                                        İş yeri 
                                </span>
                                <div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_work" checked value="">
                                                <label class="form-check-label">Seçilməyib</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_work" value="1">
                                                <label class="form-check-label">Var</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_work" value="0">
                                                <label class="form-check-label">Yoxdur</label>
                                        </div>
                                </div>  
                        </div>
                        <div class="col form-all-radios">
                                <span>
                                        Bank hesabı  
                                </span>
                                <div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_bank_account" checked value="">
                                                <label class="form-check-label">Seçilməyib</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_bank_account" value="1">
                                                <label class="form-check-label">Bəli</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="has_bank_account" value="0">
                                                <label class="form-check-label">Xeyr</label>
                                        </div> 
                                </div>  
                        </div>
                </div>
                <div class="row" style="margin-top: 15px">
                        <div class="col"> 
                                <label class="form-label">Şəhər daxil edin</label>
                                <input type="text" class="form-control" name="city"> 
                        </div>
                        <div class="col">  
                                <label class="form-label">Qeydiyyat ünvanı</label>
                                <input type="text" class="form-control" name="address">
                        </div>
                </div>
                <div class="mb-3" style="margin-top: 15px">
                        <label class="form-label">Qeyd</label>
                        <textarea class="form-control" id="call-note" name="note" rows="3"></textarea>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" id="selected-call-row" name="id" value="" />
                <button type="submit" class="btn btn-danger" style="float: right">Məlumatları yenilə</button>
                <button type="button" class="btn btn-secondary" id="close-form" style="float: right; margin-right: 5px">Bağla</button> 
        </form>

        <table class="table" style="margin-top: 120px">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Ölkə</th>
                                <th class="table-primary">Şəhər</th>
                                <th class="table-primary">Nömrə</th>
                                <th class="table-primary">Qeyd</th>
                                <th class="table-primary">Tarix</th> 
                                <th class="table-primary"></th> 
                        </tr>
                </thead>
                <tbody>
                        @foreach($calls as $index => $item)
                        <tr> 
                                <th>{{ $index+1 }}</th>
                                <th>{{ $item->country }}</th>
                                <th>{{ $item->city }}</th>
                                <th>{{ $item->citizen_number }}</th>
                                <th>{{ $item->note }}</th>
                                <th>{{ $item->created_at }}</th> 
                                <th><button type="button" class="btn btn-danger call-edit" data-id="{{ $item->id }}">Düzəliş et</button> </th> 
                        </tr>
                        @endforeach
                </tbody>
        </table>


        
 
</div>
        <script src="{!! url('assets/js/bootstrap-datepicker.min.js') !!}"></script>
        <script>

                $(function(){
                        $(".date input").each(function () {
                                $(this).datepicker("clearDates");
                        });
                        $(document).on("click", ".call-form #close-form", function(){


                                $(".call-form").removeClass("is-active"); 
                                let rowList = $(".table tbody tr");

                                rowList.each(function(){
                                        $(this).css("background", "none")
                                })
                                
                                //reset the columns
                                $("#call-note").val("");
                                $("#document-date").val("");
                                $("#selected-country").val("0");
                                $(`input[name="number"]`).val("");
                                $(`input[name="address"]`).val("");
                                $(`input[name="city"]`).val("");
                                $(`input[name="has_bank_account"]`).each((index, item)=> item.checked = index===0)
                                $(`input[name="has_work"]`).each((index, item)=> item.checked = index===0)
                                $(`input[name="family_case"]`).each((index, item)=> item.checked = index===0) 
                                $(`input[name="has_travel"]`).each((index, item)=> item.checked = index===0)


                        })

                        $(document).on("click", ".call-edit", function(){

                                $(".call-form").addClass("is-active");

                                $(this).parent().parent().css("background", "#0062ff8a");

                                let id = $(this).attr("data-id");
 
                                $("#selected-call-row").val(id);

                                $.ajax({
                                        url: "/admin/get-call/"+id,
                                        method: "get",
                                        success: (res)=>{
                                                console.log(res.data);
                                                if(res.data.length>0){
                                                        let { note, document_date, country_id, citizen_number, address, city,
                                                                has_bank_account, has_work, family_case, has_travel
                                                        } = res.data[0];
                     
                                                        $("#call-note").val(note !==null ? note : "");
                                                        $("#document-date input").val(document_date !==null ? document_date : "");
                                                        $("#selected-country").val(country_id !==null ? country_id : "0");
                                                        $(`input[name="number"]`).val(citizen_number !==null ? citizen_number : "");
                                                        $(`input[name="address"]`).val(address !==null ? address : "");
                                                        $(`input[name="city"]`).val(city !==null ? city : "");
                                                       
                                                        $(`input[name="has_bank_account"]`).each((index, item)=> { item.checked = has_bank_account ===null ? index===0 : $(item).val()==has_bank_account })
                                                        $(`input[name="has_work"]`).each((index, item)=> { item.checked = has_work ===null ? index===0 : $(item).val()==has_work })
                                                        $(`input[name="family_case"]`).each((index, item)=> { item.checked = family_case ===null ? index===0 : $(item).val()==family_case })
                                                        $(`input[name="has_travel"]`).each((index, item)=> { item.checked = has_travel ===null ? index===0 : $(item).val()==has_travel })
  
                                                }
                                        }
                                });
 

                        })

                        setInterval(() => {
                                 
                                $.ajax({
                                        url: "/admin/get-calls",
                                        method: "get",
                                        success: (res)=>{
                                                console.log(res.data);


                                                let str = "";

                                                (res.data).forEach((item, index)=>{
                                                        str += `




                                                        <tr> 
                                                                <th> ${index+1} </th>
                                                                <th> ${ item.country==null ? "" : item.country } </th>
                                                                <th> ${ item.city==null ? "" : item.city } </th>
                                                                <th> ${item.citizen_number==null ? "" : item.citizen_number} </th>
                                                                <th> ${item.note==null ? "" : item.note} </th>
                                                                <th> ${item.created_at} </th> 
                                                                <th><button type="button" class="btn btn-danger call-edit" data-id="${item.id}">Düzəliş et</button> </th> 
                                                        </tr> 
                                                        `;
                                                })

                                                $(".table tbody").html(str);
                                        }
                                }) 
                        }, 5000);


                })

        </script>


@endsection