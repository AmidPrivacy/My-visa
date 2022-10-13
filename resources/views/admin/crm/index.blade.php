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
        <div class="call-form">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-request="1" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Ümumi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                                <button class="nav-link" id="work-tab" data-request="2" data-toggle="tab" data-target="#work" type="button" role="tab" aria-controls="work" aria-selected="false">Xaricdə iş</button>
                        </li> 
                </ul>
                <div class="tab-content" id="myTabContent" style="padding-top: 25px">
                        <form action="/crm/update-call" method="post" id="my-form">
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
                                                <input type="number" name="wp_number" class="form-control" placeholder="Whatsapp nömrəsi">
                                        </div>
                                </div> 
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        
                                        <div class="row" style="margin-top: 8px"> 
                                                <div class="col">
                                                        <div class="input-group date" id="document-date">
                                                                <input type="text" class="form-control" name="document_date" placeholder="Pasportun bitmə tarixi" data-date-format="dd-mm-yyyy">
                                                                <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col"> 
                                                        <input type="number" name="number" class="form-control" placeholder="050 522 17 86">
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
                                         
                                </div>
                                <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                                        <div class="row" style="margin-top: 8px"> 
                                                <div class="col"> 
                                                        <input type="text" name="full_name" class="form-control" placeholder="Ad soyad, ata adı">
                                                </div>
                                                <div class="col">
                                                        <div class="input-group date" id="document-date">
                                                                <input type="text" class="form-control" name="birth_date" placeholder="Doğum tarixi" data-date-format="dd-mm-yyyy">
                                                                <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                        </div>
                                                </div> 
                                        </div> 
                                        <div class="row" style="margin-top: 8px"> 
                                                <div class="col"> 
                                                        <input type="text" name="education" class="form-control" placeholder="Təhsili">
                                                </div>
                                                <div class="col"> 
                                                        <input type="text" name="document" class="form-control" placeholder="Sənədi">
                                                </div>
                                        </div> 
                                </div>
                                <div class="mb-3" style="margin-top: 15px">
                                        <label class="form-label">Qeyd</label>
                                        <textarea class="form-control" id="call-note" name="note" rows="3"></textarea>
                                </div>

                                <input type="hidden" name="request_type" id="request-type" value="1" />
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" id="selected-call-row" name="id" value="" />
                                <button type="submit" class="btn btn-danger" style="float: right">Məlumatları yenilə</button>
                                <button type="button" class="btn btn-secondary" id="close-form" style="float: right; margin-right: 5px">Bağla</button> 
                        </form>
                </div>
        </div>
        
        <button type="button" class="btn btn-primary add-new-row" id="new-appeal">Yeni müraciət</button>
        <table class="table" style="margin-top: 65px">
                <thead class="table-dark">
                        <tr> 
                                <th class="table-primary">№</th>
                                <th class="table-primary">Ölkə</th>
                                <th class="table-primary">Şəhər</th>
                                <th class="table-primary">Nömrə</th>
                                <th class="table-primary">Qeyd</th>
                                <th class="table-primary">Müraciət</th>
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
                                <th>{{ $item->type==2 ? "Xarici iş" : "Ümumi" }}</th>
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

                        $("#myTab .nav-link").click(function() {
                                let val = $(this).attr("data-request"); 
                                $("#request-type").val(val);
                        })

                        $(".date input").each(function () {
                                $(this).datepicker("clearDates");
                        });

                        $("#new-appeal").click(function() {
                                $(".call-form").addClass("is-active");   
                                $(this).hide();
                                $("#my-form").attr("action", "/crm/create-call");
                        })

                        $(document).on("click", ".call-form #close-form", function(){

                                $("#new-appeal").show();
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
                                $(`input[name="wp_number"]`).val("");
                                $(`input[name="full_name"]`).val("");
                                $(`input[name="birth_date"]`).val("");
                                $(`input[name="education"]`).val("");
                                $(`input[name="document"]`).val(""); 
                                $(`input[name="address"]`).val("");
                                $(`input[name="city"]`).val("");
                                $(`input[name="has_bank_account"]`).each((index, item)=> item.checked = index===0)
                                $(`input[name="has_work"]`).each((index, item)=> item.checked = index===0)
                                $(`input[name="family_case"]`).each((index, item)=> item.checked = index===0) 
                                $(`input[name="has_travel"]`).each((index, item)=> item.checked = index===0)


                        })

                        $(document).on("click", ".call-edit", function(){

                                $("#my-form").attr("action", "/crm/update-call");
                                $("#new-appeal").hide();
                                $(".call-form").addClass("is-active");

                                $(this).parent().parent().css("background", "#0062ff8a");

                                let id = $(this).attr("data-id");
 
                                $("#selected-call-row").val(id);

                                $.ajax({
                                        url: "/admin/get-call/"+id,
                                        method: "get",
                                        success: (res)=>{
                                                if(res.data.length>0){

                                                        let { note, document_date, country_id, citizen_number, address, city, birthday, education,
                                                                has_bank_account, has_work, family_case, has_travel, wp_number, document, full_name, type
                                                        } = res.data[0];

                                                        $("#myTab .nav-link").removeClass("active");
                                                        $(".tab-content .tab-pane").removeClass("active");

                                                        if(type==2) {
                                                                $("#work-tab").addClass("active");
                                                                $(".tab-content #work").addClass("active").addClass("show");
                                                        } else {
                                                                $("#home-tab").addClass("active");
                                                                $(".tab-content #home").addClass("active").addClass("show");
                                                        }
                     
                                                        $("#call-note").val(note !==null ? note : "");
                                                        $("#document-date input").val(document_date !==null ? document_date : "");
                                                        $("#selected-country").val(country_id !==null ? country_id : "0");
                                                        $(`input[name="number"]`).val(citizen_number !==null ? citizen_number : "");
                                                        $(`input[name="address"]`).val(address !==null ? address : "");
                                                        $(`input[name="city"]`).val(city !==null ? city : "");

                                                        $(`input[name="education"]`).val(education !==null ? education : "");
                                                        $(`input[name="birthday"]`).val(birthday !==null ? birthday : "");
                                                        $(`input[name="document"]`).val(document !==null ? document : "");
                                                        $(`input[name="full_name"]`).val(full_name !==null ? full_name : "");
                                                        $(`input[name="wp_number"]`).val(wp_number !==null ? wp_number : "");
                                                        
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

                                                let str = "";

                                                (res.data).forEach((item, index)=>{
                                                        str += `

                                                        <tr> 
                                                                <th> ${index+1} </th>
                                                                <th> ${ item.country==null ? "" : item.country } </th>
                                                                <th> ${ item.city==null ? "" : item.city } </th>
                                                                <th> ${item.citizen_number==null ? "" : item.citizen_number} </th>
                                                                <th> ${item.note==null ? "" : item.note} </th>
                                                                <th> ${item.type==2 ? "Xarici iş" : "Ümumi"} </th> 
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