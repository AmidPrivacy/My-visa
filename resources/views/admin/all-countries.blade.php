<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/plane.jpg">
    <link rel="stylesheet" href="/assets/css/visa.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">   
    <link rel="stylesheet" href="/assets/css/flag.min.css"> 
    <title>Visa</title>
</head>
<body>
    <main>
        <section class="countries_section">
            <div class="wrapper-container">
                <h1 class="countryList-title" id="top">ÖLKƏLƏRİN VİZA SİYASƏTLƏRİ</h1>
                <div class="country-filter">
                    <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Ölkə axtar...">
                    </div>
                </div>
            </div>
            <div class="countrylist-flag row d-flex align-items-start justify-content-center">

                @foreach($list as $item)

                <a href="/country/{{ $item->id }}" class="col-6 col-lg-2 d-flex justify-content-center align-items-center flex-column" target="_blank">
                    <div class="mb-3 country-middle-describe">
                        <img src="/public/assets/uploads/flags/{{ $item->picture }}" alt="{{ $item->name }}" srcset="">
                    </div>
                    <div class="countrylist-flag-title mb-4">
                        {{ $item->name }}
                    </div>
                </a>

                @endforeach
               
            </div>
            <!--<div class="wrapper-container">-->
               
            <!--    <div class="countrylist-card">-->
            <!--        <div id="linkA" class="row countrylist-allcard countrylist-graycard">-->
            <!--        @foreach($list as $item)-->
            <!--            <div class="col-md-3 col-6 mb-3 mb-md-2 d-flex align-items-start">-->
            <!--                <img src="/assets/uploads/flags/{{ $item->picture }}" alt="" srcset="">-->
            <!--                <a href="/admin/country/{{ $item->id }}" class="countrylist-card_val">{{ $item->name }}</a>-->
            <!--            </div>-->
            <!--        @endforeach-->
            <!--    </div>-->
            <!--</div>-->
        </section>
    </main> 

    <script src="{!! url('assets/js/jquery-3.5.1.min.js') !!}"></script>
    <script>

            $(function(){

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
                                                            <a href="/country/${ item.id }" class="col-6 col-lg-2 d-flex justify-content-center align-items-center flex-column" target="_blank">
                                                                <div class="mb-3 country-middle-describe">
                                                                    <img src="/public/assets/uploads/flags/${ item.picture }" alt="${ item.name }" srcset="">
                                                                </div>
                                                                <div class="countrylist-flag-title mb-4">
                                                                    ${ item.name }
                                                                </div>
                                                            </a>
                                                            `;
                                                    })

                                                    $(".countrylist-flag").html(str);
                                            }
                                    })
                            } 
                    })


            })

    </script>

</body>
</html>