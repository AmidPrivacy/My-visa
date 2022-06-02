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
                        <input type="text" class="form-control" placeholder="Viza növü axtar...">
                </div>
        </div>
        <button type="button" class="btn btn-primary add-new-row" data-toggle="modal" data-target="#exampleModal">Yeni növ</button>
     
                        
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                @foreach($list as $index => $item) 
                                <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-{{ $item['country']->id }}" aria-expanded="false" aria-controls="flush-collapseOne">
                                                        {{ $item["country"]->name }}
                                                </button>
                                        </h2>
                                        <div id="flush-{{ $item['country']->id }}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
                                                <div class="accordion-body">  
                                                        <table class="table">
                                                                <thead class="table-dark">
                                                                        <tr> 
                                                                                <th class="table-primary">№</th>
                                                                                <th class="table-primary">Viza növü</th>
                                                                                <th class="table-primary">Ölkə</th>
                                                                                <th class="table-primary"></th>
                                                                        </tr>
                                                                </thead>
                                                                <tbody>
                                                                        @foreach($item["types"] as $index => $type)
                                                        
                                                                        <tr> 
                                                                                <th class="table-light">{{ $index+1 }}</th>
                                                                                <td class="table-light"> {{ $type->name }} </td>
                                                                                <td class="table-light"> {{ $item["country"]->name }} </td>
                                                                                <td class="table-light table-edit-field">
                                                                                        <button type="button" class="btn btn-danger" onClick="removeRow({{ $type->id }}, '/admin/type-remove/')">sil</button> 
                                                                                </td>
                                                                        </tr>
                                                                
                                                                        @endforeach
                                                                </tbody>
                                                        </table>
                                                </div>
                                        </div>
                                </div> 
                                @endforeach
                        </div> 
                        
              

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Viza növü əlavəsi</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="/admin/type-add" enctype="multipart/form-data">
                                        <div class="modal-body"> 
                                                <div class="mb-3">
                                                        <label for="formFile" class="form-label">Ölkə seçin</label>
                                                        <select class="form-select" name="country_id" required>
                                                                @foreach($countries as $item)
                                                                   <option value="{{ $item->id }}"> {{ $item->name }} </option> 
                                                                @endforeach
                                                        </select>                                                
                                                </div>
                                                <button type="button" class="btn btn-primary" id="add-inheritance">+</button>
                                                <div class="mb-3" style="margin-top: 45px">
                                                        <select class="form-select" name="stay_period[]">
                                                                <option value="0"> Stay Period seçin </option> 
                                                                <option value="1"> Long stay </option> 
                                                                <option value="2"> Short stay </option> 
                                                        </select>                                                
                                                </div>
                                                <div class="mb-3"> 
                                                        <input type="text" class="form-control" name="name[]" id="type" required placeholder="Viza növünü daxil edin">
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
                $("#add-inheritance").click(function(){
                        $("#type").after(`<div class="addition-field">
                                <select class="form-select" name="stay_period[]">
                                        <option value="0"> Stay Period seçin </option> 
                                        <option value="1"> Long stay </option> 
                                        <option value="2"> Short stay </option> 
                                </select>
                                <button type="button" style='margin-top: 10px' class="btn btn-danger">-</button>
                                <input style='margin-top: 10px' type="text" class="form-control" name="name[]" required placeholder="Viza növünü daxil edin">
                                        
                        </div>`)
                })

                $(document).on("click", ".addition-field button", function(){
                        $(this).parent().remove()
                })

                $(".country-filter input").keypress(function(event){
                        let val = $(this).val();
                        
                        var keycode = (event.keyCode ? event.keyCode : event.which);

                        if(val.length>0 && keycode == '13') {
                                $.ajax({
                                        url: "/admin/type-search/"+val,
                                        method: "get",
                                        success: (res)=>{ 

                                                let str = "";

                                                (res.data).forEach((item)=>{

                                                        let rows = "";
                                                        (item["types"]).forEach((type, index)=>{
                                                                rows += `<tr> 
                                                                                <th class="table-light">${ index+1 }</th>
                                                                                <td class="table-light"> ${ type.name } </td>
                                                                                <td class="table-light"> ${ item["country"].name } </td>
                                                                                <td class="table-light table-edit-field">
                                                                                        <button type="button" class="btn btn-danger" onClick="removeRow(${ type.id }, '/admin/type-remove/')">sil</button> 
                                                                                </td>
                                                                        </tr>`;
                                                        });

                                                        str += `
                                                        <div class="accordion-item">
                                                                <h2 class="accordion-header" id="flush-headingOne">
                                                                        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#flush-${ item['country'].id }" aria-expanded="false" aria-controls="flush-collapseOne">
                                                                                ${ item["country"].name }
                                                                        </button>
                                                                </h2>
                                                                <div id="flush-${ item['country'].id }" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-parent="#accordionFlushExample">
                                                                        <div class="accordion-body">  
                                                                                <table class="table">
                                                                                        <thead class="table-dark">
                                                                                                <tr> 
                                                                                                        <th class="table-primary">№</th>
                                                                                                        <th class="table-primary">Viza növü</th>
                                                                                                        <th class="table-primary">Ölkə</th>
                                                                                                        <th class="table-primary"></th>
                                                                                                </tr>
                                                                                        </thead>
                                                                                        <tbody> `+ rows +` </tbody>
                                                                                </table>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        `;
                                                })

                                                $("#accordionFlushExample").html(str);
                                        }
                                })
                        } 
                })



        })
</script>




@endsection