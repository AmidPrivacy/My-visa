<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/plane.png">
    <link rel="stylesheet" href="/assets/css/visa.css">
    <link rel="stylesheet" href="/assets/css/bootstrap2.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">   
    <link rel="stylesheet" href="/assets/css/flag.min.css"> 
    <title>Asan Visa</title>
</head>
<body>
    <main>
        <section class="banner"> 
            <div class="banner-body">
                <div class="banner-body_background"></div>
                <div class="banner-body_container wrapper-container">
                    <div class="banner-body_title">
                        <h1>
                        {{ $selected->name }} Viza Siyasəti
                        </h1>
                    </div>
                         <div class="banner-body_line">
                             <img src="/assets/img/line.png" alt="pickvisa.az" >
                        </div>
                    <div class="banner-body_footertitle">
                        <h2>
                            Səyahətinizi planlamaq üçün {{ $selected->name }} ölkəsinin viza siyasətinə nəzər yetirin.
                        </h2>
                     </div>
                </div>
            </div>
        </section>
        <section class="visitcountry">
                <div class="wrapper-container wrapper-container_mobile section-title">
                    <h2>
                        {{ $selected->name }} ölkəsinə səyahət üçün viza almalısınızmı?
                    </h2>
                    <div id="countries-has-visa" class="visitcountry-card">
                        <div class="row visitcountry-card_title">
                            <h3 class="col-md-12">
                                Viza tələb olunur
                            </h3>
                        </div>
                        <div class="row visitcountry-card_text countrylist-graycard">
                            
                            @foreach($list as $item)
                                <div class="col-md-3 col-6 mb-2 d-flex align-items-start">
                                    <img src="/public/assets/uploads/flags/{{ $item->picture }}" alt="" srcset="">
                                    <a href="/country/{{ $item->id }}" class="countrylist-card_val">{{ $item->name }}</a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
         </section>
         <section class="visatype">
                <div class="wrapper-container section-title px-3 px-md-0">
                    <h2>Viza Növləri</h2> 
                    <div class="container">
                        <div class="btn-group stay-period-style" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary {{ isset($_GET['period'])?'':'active-tab' }}" data-id="0">Hamısı</button>
                            <button type="button" class="btn btn-primary {{ isset($_GET['period']) && $_GET['period']==1 ?'active-tab':'' }}" data-id="1">Long stay</button>
                            <button type="button" class="btn btn-primary {{ isset($_GET['period']) && $_GET['period']==2 ?'active-tab':'' }}" data-id="2">Short stay</button>
                        </div>
                        <div class="row justify-content-start d-none d-md-flex">
                           
                            @foreach($types as $item)
                                <a href="#visa-type-{{ $item->id }}" class="visatype-headerbox mr-3 mb-4">
                                    <div class="visatype-headerbox_icon">
                                    <img alt="{{ $selected->name }}"  src="/assets/img/1.svg" >
                                    </div>
                                    <span>{{ $item->name }}</span>
                                </a>
                            @endforeach
                           
                        </div>

                        @foreach($types as $type) 
                        
                        <div id="visa-type-{{ $type->id }}" class="row visatype-card">
                            <div class="visatype-card_stickHead col-lg-12">
                                <div class="row pt-4 bg-white">
                                    <div class="col-lg-12">
                                        <div class="visatype-cardlbox">
                                            <div>
                                                <div class="visatype-headerbox_icon">
                                                <img alt="{{ $type->name }} Qısamüddətli Viza" src="/assets/img/1.svg">
                                                </div>
                                            </div>
                                            <h3 class="visatype-cardlbox_title">
                                                {{ $type->name }} <span class="main-author" onclick="checkAuthors(2, {{ $type->id }})"> {{ $type->user }} </span>
                                            </h3>

                                            <button type="button" class="btn btn-primary type-collapse" data-count="{{ count($type->children) }}">{{ count($type->children)>0 ? "+" : "-" }}</button>
                                        </div>
                                    </div>
                                    @if(count($type->children)>1)
                                    <div class="col-lg-12 visapolicy-horizantal-menu">
                                        <ul class="nav">

                                        @foreach($type->children as $item) 

                                            <li class="nav-item visatype-cardrbox_title d-flex mb-1 policy-grounded-radiants">
                                                <a class="mx-3" href="#faq-{{ $item->id }}">{{ $item->name }}</a>
                                            </li>

                                        @endforeach
                                           
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class=" visatype-card_boxbottom"></div>
                            </div>
                            <div class="col-lg-12 content type-faqs">
                                @foreach($type->children as $item) 
                                <div class="tab-pane visatype-cardrbox_text" id="faq-{{ $item->id }}">
                                    <h4>{{ $item->name }} <span class="main-author" onclick="checkAuthors(3, {{ $item->id }})"> {{ $type->user }} </span></h4>
                                    
                                    {!! $item->content !!}

                                </div>
                                @endforeach
                            </div>
                            <div class="visatype-card_bottom"></div>
                        </div>
                     
                        @endforeach
                        
                    </div>   
                </div>
            </section>
            <!-- <section id="visa-policy-faq" class="faq-visapolicy mb-5">
                <div class="wrapper-container section-title">
                    <h2>FAQ</h2>
                    <div id="men-azerbaycana-viza-teleb-etmeyen-olkenin-vetendasiyam-men-azerbaycana-daxil-olarken-her-hansisa-bir-problem-ile-qarsilasa-bilerem" class="faq-visapolicy-card">
                        <div class=" row">
                            <div class="col-lg-12">
                                <img alt="pickvisa.az" data-pagespeed-url-hash="3520842087" src="/assets/img/question.svg" >
                                <h3>
                                Mən {{ $selected->name }}a viza tələb etməyən ölkənin vətəndaşıyam. Mən {{ $selected->name }}a daxil olarkən hər hansısa bir problem ilə qarşılaşa bilərəm?
                                </h3>
                            </div>
                            <div class="col-lg-12">
                                <p>{{ $selected->name }}a daxil olarkən viza tələbi olmasa da, müəyyən tələblərə cavab verməli olacaqsınız.</p>
                                
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
                <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header">
                        <strong class="mr-auto">İsdifadəçi əməliyyatları</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Hello, world! This is a toast message.
                    </div>
                </div>
            </div>
    </main>
    
    <script src="{!! url('assets/js/jquery-3.5.1.min.js') !!}"></script>
    <script src="{!! url('assets/js/bootstrap.bundle.min.js') !!}"></script>
    <script>
        function checkAuthors(category, rowId) {
            
            fetch(`/admin/archive/${rowId}/${category}`).then(response => response.json()).then(res => {
                if(res.length>0) {

                    let str = "";
                    res.forEach(item=>{
                        str += `
                            <tr style="border-bottom: solid 1px #ccc"> 
                                <th>${item.user}</th> 
                                <th>${item.operation}</th> 
                                <th>${item.created_at}</th> 
                            </tr>
                        `
                    })
                    document.querySelector(".toast-body").innerHTML = "<table>"+str+"</table>";
                    $('.toast').toast('show');

                } else {
                    document.querySelector(".toast-body").innerHTML = "";
                }
            })
        }


        $(function(){

            $(".type-collapse").click(function(){
                if($(this).attr("data-count") !== "0") {
                    var parent = $(this).parent().parent().parent().parent().parent();
                    if($(this).text()==="+"){
                        $(parent).find(".type-faqs").css("display","block")
                        $(this).text("-")
                    } else {
                        $(parent).find(".type-faqs").css("display","none")
                        $(this).text("+")
                    }
                }
            })

            $(".visatype-headerbox").click(function() {
                let id = $(this).attr("href"); 
                let dataCheck = $(id).find(".visatype-cardlbox .type-collapse").attr("data-count");
                // alert(dataCheck);
                if(dataCheck==1) {
                    $(id).find(".visatype-cardlbox .type-collapse").html("-");
                }
            })

            $(".stay-period-style button").click(function(){

                let path = location.pathname.split("/");
 
                let tempPath = '/'+path[1]+'/'+path[2];

                let period = $(this).attr("data-id");
 

                let currentPath = period==0 ? tempPath : tempPath+'?period='+period;
                

                console.log(path)
                console.log(period)

                window.location.assign(currentPath);
            })


        })
    </script>
  
</body>
</html>