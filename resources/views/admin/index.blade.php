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
                    <div id="viza-teleb-olunur" class="visitcountry-card">
                        <div class="row visitcountry-card_title">
                            <h3 class="col-md-12">
                            Viza tələb olunur
                            </h3>
                        </div>
                        <div class="row visitcountry-card_text countrylist-graycard">
                            
                            @foreach($list as $item)
                                <div class="col-md-3 col-6 mb-2 d-flex align-items-start">
                                    <img src="/assets/uploads/flags/{{ $item->picture }}" alt="" srcset="">
                                    <a href="/admin/country/{{ $item->id }}" class="countrylist-card_val">{{ $item->name }}</a>
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
                        <div class="row justify-content-start d-none d-md-flex">
                           

                        @foreach($types as $item)
                            <a href="#azerbaycan-viza-novleri-ve-kateqoriyalari" class="visatype-headerbox mr-3 mb-4">
                                <div class="visatype-headerbox_icon">
                                <img alt="{{ $selected->name }} Viza Növləri və Kateqoriyaları"  src="/assets/img/1.svg" >
                                </div>
                                <span>{{ $selected->name }} Viza Növləri və Kateqoriyaları</span>
                            </a>
                        @endforeach
                            <!-- <a href="#e-viza-azerbaycan" class="visatype-headerbox mr-3 mb-4">
                                <div class="visatype-headerbox_icon">
                                <img alt="E-Viza {{ $selected->name }}"  src="/assets/img/1.svg" >
                                </div>
                                <span>E-Viza {{ $selected->name }}</span>
                            </a>
                            <a href="#azerbaycan-qisamuddetli-viza" class="visatype-headerbox mr-3 mb-4">
                                <div class="visatype-headerbox_icon">
                                <img alt="{{ $selected->name }} Qısamüddətli Viza"  src="/assets/img/1.svg">
                                </div>
                                <span>{{ $selected->name }} Qısamüddətli Viza</span>
                            </a> -->
                            
                           
                        </div>
                        <div id="azerbaycan-viza-novleri-ve-kateqoriyalari" class="row visatype-card">
                            <div class="visatype-card_stickHead col-lg-12">
                                <div class="row pt-4 bg-white">
                                    <div class="col-lg-12">
                                        <div class="visatype-cardlbox">
                                        <div>
                                            <div class="visatype-headerbox_icon addhovericon">
                                            <img alt="{{ $selected->name }} Viza Növləri və Kateqoriyaları" data-pagespeed-url-hash="3880711428" src="/assets/img/1.svg" >
                                        </div>
                                        </div>
                                            <h3 class="visatype-cardlbox_title">
                                            {{ $selected->name }} Viza Növləri və Kateqoriyaları
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 visapolicy-horizantal-menu ">
                                    <ul class="nav">
                                    </ul>
                                    </div>
                                </div>
                                <div class=" visatype-card_boxbottom"></div>
                            </div>
                            <div class="col-lg-12 content">
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-viza-novleri-ve-kateqoriyalari">
                                <p>Siz {{ $selected->name }}a olan səyahətinizi {{ $selected->name }} vizasını almaqla həyata keçirə bilərsiniz. Xarici vətəndaşlar {{ $selected->name }} qısamüddətli vizasına (turist viza, e-viza) müvəqqəti səbəblər&nbsp;üçün (turizm, işgüzar, mədəni ziyarət, və s.) müraciət edə bilərlər. Əgər {{ $selected->name }}da uzun müddət müəyyən səbəblərə görə (təhsil, iş kimi) qalmaq istəyirsinizsə, {{ $selected->name }}ın uzunmüddətli vizalarına müraciət edə bilərsiniz.</p>
                                </div>
                            </div>
                            <div class="visatype-card_bottom"></div>
                        </div>
                        <div id="e-viza-azerbaycan" class="row visatype-card">
                            <div class="visatype-card_stickHead col-lg-12">
                                <div class="row pt-4 bg-white">
                                <div class="col-lg-12">
                                    <div class="visatype-cardlbox">
                                    <div>
                                        <div class="visatype-headerbox_icon">
                                        <img alt="E-Viza {{ $selected->name }}" data-pagespeed-url-hash="3880711428" src="/assets/img/1.svg" >
                                        </div>
                                    </div>
                                        <h3 class="visatype-cardlbox_title">
                                        E-Viza {{ $selected->name }}
                                        </h3>
                                    </div>
                                    </div>
                                    <div class="col-lg-12 visapolicy-horizantal-menu ">
                                        <ul class="nav">
                                        </ul>
                                    </div>
                                </div>
                                <div class=" visatype-card_boxbottom"></div>
                            </div>
                            <div class="col-lg-12 content">
                                <div class="tab-pane visatype-cardrbox_text" id="e-viza-azerbaycan">
                                    <p><strong>E-viza</strong> {{ $selected->name }} səyahət etmək üçün alınan vizanın online olan bir növüdür.</p>
                                    <p>Ərizə formasının doldurulması və servis ödənişinin edilməsindən sonra seçdiyiniz vizaya baxılma müddətindən asılı olmaq şərti ilə <strong>3 iş günü</strong> ərzində vizanızı email vasitəsilə əldə edəcəksiniz.</p>
                                    <p>&nbsp;</p>
                                    <h5><strong>{{ $selected->name }} E-Vizası üçün Tələb Olunan Sənədlər</strong></h5>
                                    <p>&nbsp;</p>
                                    <p><strong>1.&nbsp;</strong><strong>Xarici Pasport</strong></p>
                                    <ul>
                                    <li>{{ $selected->name }} ərazisindən keçdiyiniz tarixdən etibarən altı ay ərzində etibarlılıq</li>
                                    <li>Sahibi tərəfindən imzalı</li>
                                    <li>Alınma tarixi maksimum 10 il olmalı (son 10 il ərzində verilmiş)</li>
                                    <li>Ən azı bir və ya iki boş “viza səhifəsi” olmalı</li>
                                    <li>Şəkillər zərərə uğramamış və etibarlı şəkildə xarici pasporta yapışdırılmış olmalı</li>
                                    </ul>
                                    <p>&nbsp;</p>
                                
                                
                                </div>
                            </div>
                            <div class="visatype-card_bottom"></div>
                        </div>
                        <div id="azerbaycan-qisamuddetli-viza" class="row visatype-card">
                            <div class="visatype-card_stickHead col-lg-12">
                                <div class="row pt-4 bg-white">
                                    <div class="col-lg-12">
                                        <div class="visatype-cardlbox">
                                        <div>
                                            <div class="visatype-headerbox_icon">
                                            <img alt="{{ $selected->name }} Qısamüddətli Viza" src="/assets/img/1.svg">
                                            </div>
                                        </div>
                                            <h3 class="visatype-cardlbox_title">
                                            {{ $selected->name }} Qısamüddətli Viza
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 visapolicy-horizantal-menu ">
                                        <ul class="nav">
                                            <li class="nav-item visatype-cardrbox_title d-flex mb-1 policy-grounded-radiants">
                                            <a class="mx-3" href="#azerbaycan-turist-vizasi">{{ $selected->name }} Turist Vizası</a>
                                            </li>
                                            <li class="nav-item visatype-cardrbox_title d-flex mb-1 policy-grounded-radiants">
                                            <a class="mx-3" href="#azerbaycan-bizneskonqresticari-sergi-seyaheti">{{ $selected->name }} Biznes/Konqres/Ticari Sərgi Səyahəti</a>
                                            </li>
                                            <li class="nav-item visatype-cardrbox_title d-flex mb-1 policy-grounded-radiants">
                                            <a class="mx-3" href="#azerbaycan-medeni-elmi-ziyaret-idman-tedbirleri-vizasi">{{ $selected->name }} Mədəni, Elmi Ziyarət, İdman Tədbirləri Vizası</a>
                                            </li>
                                            <li class="nav-item visatype-cardrbox_title d-flex mb-1 policy-grounded-radiants">
                                            <a class="mx-3" href="#azerbaycan-aile-ve-ya-dostlari-ziyaret">{{ $selected->name }} Ailə və ya Dostları Ziyarət</a>
                                            </li>
                                            <li class="nav-item visatype-cardrbox_title d-flex mb-1 policy-grounded-radiants">
                                            <a class="mx-3" href="#azerbaycan-tehsil-qisamuddetli-vizasi">{{ $selected->name }} Təhsil (Qısamüddətli) Vizası</a>
                                            </li>
                                            <li class="nav-item visatype-cardrbox_title d-flex mb-1 policy-grounded-radiants">
                                            <a class="mx-3" href="#azerbaycan-is-qisamuddetli-vizasi">{{ $selected->name }} İş (Qısamüddətli) Vizası</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class=" visatype-card_boxbottom"></div>
                            </div>
                            <div class="col-lg-12 content">
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-qisamuddetli-viza">
                                    <h4>{{ $selected->name }} Qısamüddətli Viza</h4>
                                    <p>Əgər siz E-viza tələblərinə cavab vermirsinizsə, {{ $selected->name }}a olan qısamüddətli səyahətinizi reallaşdırmaq üçün ənənəvi “kağız üzərində” olan vizalara müraciət edə bilərsiniz. Bu vizaya müraciət səbəblərinə turizm, ailə və dostları ziyarət, işgüzar səyahətlər, qısamüddətli təhsil, mübadilə proqramları, qısamüddətli iş, və bir sıra digər məqamlar aid ola bilər. Sizə viza ilə bağlı lazım olan bütün məlumatları – hər viza növü üçün tələb olunan sənədlər, viza rüsumları, vizaya baxılma müddətləri və vizaya müraciətin harda edilməsi ilə bağlı məlumatları aşağıda tapa bilərsiniz.</p>
                                    <p>&nbsp;</p>
                                    <hr>
                                    <p>&nbsp;</p>
                                </div>
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-turist-vizasi">
                                    <h4>{{ $selected->name }} Turist Vizası</h4>
                                    <p>{{ $selected->name }} Turist vizası {{ $selected->name }}a turizm məqsədilə səyahət etmək istəyən şəxslərə verilir. Turistik fəaliyyətlətləriniz üçün {{ $selected->name }} Turist vizasına müraciət edə bilərsiniz.</p>
                                    <p>&nbsp;</p>
                                    <h5><strong>{{ $selected->name }} Turist Vizası üçün Tələb Olunan Sənədlər</strong></h5>
                                    <p>&nbsp;</p>
                                    <p><strong>1.&nbsp;</strong><strong>Ərizə Forması</strong></p>
                                    <ul>
                                    <li>Tamamilə ingiliscə doldurulmuş, müraciətçi tərəfindən imzalanmış (azyaşlı – 18 yaşı tamam olmamış şəxslərin hər iki valideyni tərəfindən imzalanmış) və tarixi qoyulmuş olmalıdır.</li>
                                    </ul>
                                    <p><strong>2. Xarici Pasport</strong></p>
                                    <ul>
                                        <li>{{ $selected->name }} ərazisindən keçdiyiniz tarixdən etibarən altı ay ərzində etibarlı olmalı</li>
                                        <li>Sahibi tərəfindən imzalı</li>
                                        <li>Alınma tarixi maksimum 10 il olmalı (son 10 il ərzində verilmiş)</li>
                                        <li>Ən azı bir və ya iki boş “viza səhifəsi” olmalı</li>
                                        <li>Şəkillər zərərə uğramamış və etibarlı şəkildə xarici pasporta yapışdırılmış olmalı</li>
                                    </ul>
                                
                                
                                    <hr>
                                    <p>&nbsp;</p>
                                </div>
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-bizneskonqresticari-sergi-seyaheti">
                                    <h4>{{ $selected->name }} Biznes/Konqres/Ticari Sərgi Səyahəti</h4>
                                    <p>{{ $selected->name }} Biznes vizası {{ $selected->name }}a daxil olaraq&nbsp;ən çoxu vizanızın etibarlılıq müddəti qədər ölkə ərazisində qalmağa icazə verir. Bu viza sahibinə görüş və konfranslarda iştirak etmək, təlimlər tərtib etmək və ya hər hansısa təlimə qoşulmaq, daxili yoxlanış aparmaq, ləvazimatların quraşdırılması, müştəri və ya yerli flial üçün müvəqqəti fəaliyyətlər icra etmək kimi biznes fəaliyyətləri ilə məşğul olmağa icazə verir.</p>
                                    <p>Biznes Vizası kateqoriyasında aşağıdakılara da müraciət mümkündür:</p>
                                    <ul>
                                        <li>İş məsələləri / iclaslar / danışıqlar / təlimlər</li>
                                        <li>Konfrans / Konqres / Sərgi</li>
                                        <li>Elmi / Tədqiqat tədbirləri</li>
                                        <li>Jurnalistlər</li>
                                        <li>Rəsmi nümayəndə heyətləri</li>
                                    </ul>
                                    <p>&nbsp;</p>
                                
                                    <hr>
                                    <p>&nbsp;</p>
                                </div>
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-medeni-elmi-ziyaret-idman-tedbirleri-vizasi">
                                    <h4>{{ $selected->name }} Mədəni, Elmi Ziyarət, İdman Tədbirləri Vizası</h4>
                                    <p>{{ $selected->name }} Mədəni/Elmi/İdman vizası sizə {{ $selected->name }}a mədəni, elmi və ya idman məqsədləri ilə daxil olmağınıza (məsələn mədəni tədbirdə iştirakınıza) imkan yaradır.</p>
                                    <p>&nbsp;</p>
                                    <h5><strong>{{ $selected->name }} Mədəni Ziyarət&nbsp;Vizası üçün Tələb Olunan Sənədlər</strong></h5>
                                    <p>&nbsp;</p>
                                    <p><strong>1. Ərizə Forması</strong></p>
                                    <ul>
                                         <li>Tamamilə ingiliscə doldurulmuş, müraciətçi tərəfindən imzalanmış (azyaşlı – 18 yaşı tamam olmamış şəxslərin hər iki valideyni tərəfindən imzalanmış) və tarixi qoyulmuş olmalıdır.</li>
                                    </ul>
                                    <p><strong>2. Xarici Pasport</strong></p>
                                    <ul>
                                        <li>{{ $selected->name }} ərazisindən keçdiyiniz tarixdən etibarən altı ay ərzində etibarlı olmalı</li>
                                        <li>Sahibi tərəfindən imzalı</li>
                                        <li>Alınma tarixi maksimum 10 il olmalı (son 10 il ərzində verilmiş)</li>
                                        <li>Ən azı bir və ya iki boş “viza səhifəsi” olmalı</li>
                                        <li>Şəkillər zərərə uğramamış və etibarlı şəkildə xarici pasporta yapışdırılmış olmalı</li>
                                    </ul>
                                    <p><strong>3. İki Ədəd Fotoşəkil</strong></p>
                                    <ul>
                                        <li>YENİ! 6 aydan gec olmayaraq çəkilmiş fotoşəkil</li>
                                        <li>Üzün qarşıdan 70-80% -ni (32-26 mm) göstərən fotoşəkil</li>
                                        <li>Ağ fonda və standart formatda</li>
                                        <li>Aydın üz cizgiləri və gözlər - saç və ya eynək ilə örtülməmiş halda</li>
                                        <li>3x4 ölçülü</li>
                                    </ul>
                                    
                                    
                                <hr>
                                <p>&nbsp;</p>
                                </div>
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-aile-ve-ya-dostlari-ziyaret">
                                    <h4>{{ $selected->name }} Ailə və ya Dostları Ziyarət</h4>
                                    <p>Qısamüddətli Ailə və dostları ziyarət vizası Turist vizasının bir növüdür və sizə {{ $selected->name }}da qanuni olaraq yaşayan ailə üzvünüzü və ya dostunuzu ziyarət etmə hüququ verir.</p>
                                    <p>&nbsp;</p>
                                    <h5><strong>{{ $selected->name }} Ailə və ya Dostları Ziyarət Vizası üçün Tələb Olunan Sənədlər</strong></h5>
                                    <p>&nbsp;</p>
                                    <p><strong>1. Ərizə Forması</strong></p>
                                    <ul>
                                        <li>Tamamilə ingiliscə doldurulmuş, müraciətçi tərəfindən imzalanmış (azyaşlı – 18 yaşı tamam olmamış şəxslərin hər iki valideyni tərəfindən imzalanmış) və tarixi qoyulmuş olmalıdır.</li>
                                    </ul>
                                    <p><strong>2. Xarici Pasport</strong></p>
                                    <ul>
                                        <li>{{ $selected->name }} ərazisindən keçdiyiniz tarixdən etibarən altı ay ərzində etibarlı olmalı</li>
                                        <li>Sahibi tərəfindən imzalı</li>
                                        <li>Alınma tarixi maksimum 10 il olmalı (son 10 il ərzində verilmiş)</li>
                                        <li>Ən azı bir və ya iki boş “viza səhifəsi” olmalı</li>
                                        <li>Şəkillər zərərə uğramamış və etibarlı şəkildə xarici pasporta yapışdırılmış olmalı</li>
                                    </ul>
                                    
                                    
                                    
                                    <hr>
                                    <p>&nbsp;</p>
                                </div>
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-tehsil-qisamuddetli-vizasi">
                                    <h4>{{ $selected->name }} Təhsil (Qısamüddətli) Vizası</h4>
                                    <p>{{ $selected->name }} qısamüddətli təhsil vizası sizə {{ $selected->name }}a təhsil və ya təlim-tədris məqsədilə edəcəyiniz səyahətinizi həyata keçirmək üçün verilir. Bu viza sizin {{ $selected->name }}da hər yarım il üçün (180 gün), 90 günə qədər qalmağınızı tələb edir.</p>
                                    <h5>&nbsp;</h5>
                                    <h5><strong>{{ $selected->name }} Təhsil (Qısamüddətli) Vizası üçün Tələb Olunan Sənədlər</strong></h5>
                                        <p>&nbsp;</p>
                                        <p><strong>1. Ərizə Forması</strong></p>
                                    <ul>
                                        <li>Tamamilə ingiliscə doldurulmuş, müraciətçi tərəfindən imzalanmış (azyaşlı – 18 yaşı tamam olmamış şəxslərin hər iki valideyni tərəfindən imzalanmış) və tarixi qoyulmuş olmalıdır.</li>
                                    </ul>
                                        <p><strong>2. Xarici Pasport</strong></p>
                                    <ul>
                                        <li>{{ $selected->name }} ərazisindən keçdiyiniz tarixdən etibarən altı ay ərzində etibarlılıq</li>
                                        <li>Sahibi tərəfindən imzalı</li>
                                        <li>Alınma tarixi maksimum 10 il olmalı (son 10 il ərzində verilmiş)</li>
                                        <li>Ən azı bir və ya iki boş “viza səhifəsi” olmalı</li>
                                        <li>Şəkillər zərərə uğramamış və etibarlı şəkildə xarici pasporta yapışdırılmış olmalı</li>
                                    </ul>
                                        <p><strong>3. İki Ədəd Fotoşəkil</strong></p>
                                    <ul>
                                        <li>YENİ! 6 aydan gec olmayaraq çəkilmiş fotoşəkil</li>
                                        <li>Üzün qarşıdan 70-80% -ni (32-26 mm) göstərən fotoşəkil</li>
                                        <li>Ağ fonda və standart formatda</li>
                                        <li>Aydın üz cizgiləri və gözlər - saç və ya eynək ilə örtülməmiş halda</li>
                                        <li>3x4 ölçülü</li>
                                    </ul>
                                    
                                <hr>
                                <p>&nbsp;</p>
                                </div>
                                <div class="tab-pane visatype-cardrbox_text" id="azerbaycan-is-qisamuddetli-vizasi">
                                    <h4>{{ $selected->name }} İş (Qısamüddətli) Vizası</h4>
                                    <p>{{ $selected->name }} qısamüddətli iş vizası sizə {{ $selected->name }}a qısamüddətli iş fəaliyyətləri üçün edəcəyiniz səyahətinizi həyata keçirmək üçün verilir.</p>
                                    <p>&nbsp;</p>
                                    <h5><strong>{{ $selected->name }} İş (Qısamüddətli) Vizası üçün Tələb Olunan Sənədlər</strong></h5>
                                        <p>&nbsp;</p>
                                        <p><strong>1.&nbsp;</strong><strong>Ərizə Forması</strong></p>
                                    <ul>
                                        <li>Tamamilə ingiliscə doldurulmuş, müraciətçi tərəfindən imzalanmış (azyaşlı – 18 yaşı tamam olmamış şəxslərin hər iki valideyni tərəfindən imzalanmış) və tarixi qoyulmuş olmalıdır.</li>
                                    </ul>
                                    <p><strong>2. Xarici Pasport</strong></p>
                                    <ul>
                                        <li>{{ $selected->name }} ərazisindən keçdiyiniz tarixdən etibarən altı ay ərzində etibarlı olmalı</li>
                                        <li>Sahibi tərəfindən imzalı</li>
                                        <li>Alınma tarixi maksimum 10 il olmalı (son 10 il ərzində verilmiş)</li>
                                        <li>Ən azı bir və ya iki boş “viza səhifəsi” olmalı</li>
                                        <li>Şəkillər zərərə uğramamış və etibarlı şəkildə xarici pasporta yapışdırılmış olmalı</li>
                                    </ul>
                            
                                </div>
                            </div>
                            <div class="visatype-card_bottom"></div>
                        </div>
                     
                        
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
    </main>
    
  
</body>
</html>