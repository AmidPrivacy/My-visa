<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My visa</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> 
    @yield('css')
    <link href="{!! url('assets/css/client-side/responsive.css') !!}" rel="stylesheet"> 
    <link rel="icon" href="/assets/img/logo1.svg" type="image/svg" sizes="21x16">
</head>
<body> 
    <header>
        <div class="desktop container">
            <div class="brand"> 
               <a href="/landingpage">
                <img src="/assets/img/logo.svg" alt="">
               </a> 
            </div>
            <div class="lang">
                <div class="lang-item">
                    <span>Az</span>
                    <img src="/assets/img/az.svg" alt="">
                </div>
                <div class="lang-item">
                    <span>Ru</span>
                    <img src="/assets/img/ru.svg" alt="">
                </div>
                <div class="lang-item">
                    <span>En</span>
                    <img src="/assets/img/en.svg" alt="">
                </div>
            </div>
            <nav> 
                <div class="menu">
                    <a href="/landingpage">
                        <img src="/assets/img/home.svg" alt="">
                    </a>
                </div>
                <div class="menu">
                    <a href="/visa-services">Viza xidmətləri</a>
                </div>
                <div class="menu">
                    <a href="/tours" class="menu">Turlar</a>
                </div>
                <div class="menu">
                    <a href="/blog" class="menu">Blog</a>
                </div>
                <div class="menu">
                    <a href="/faq" class="menu">FAQ</a>
                </div>
            </nav> 
        </div>
        <div class="mobile-menu container">
            <div class="mobile-button">
                <div class="mobile-burger"></div>
            </div>
             
            <div class="brand">
                <a href="/">
                 <img src="assets/img/logo.svg" alt="">
                </a> 
             </div>
             <div class="lang">
                 <div class="lang-item">
                     <span>Az</span>
                     <img src="assets/img/az.svg" alt="">
                 </div>
                 <div class="lang-item">
                     <span>Ru</span>
                     <img src="assets/img/ru.svg" alt="">
                 </div>
                 <div class="lang-item">
                     <span>En</span>
                     <img src="assets/img/en.svg" alt="">
                 </div>
             </div>

             
            
        </div>
        <nav class="mobile-nav "> 
            <ul class="hamburgerUL container">
               <li class="hamburgerItem">
                   <a href="/visa-services">Viza xidmətləri</a> 
               </li>
               <li class="hamburgerItem">
                   <a href="/tours" class="menu">Turlar</a>
               </li>
               <li class="hamburgerItem">
                   <a href="/blog" class="menu">Blog</a>
               </li>
               <li class="hamburgerItem"> 
                   <a href="/faq" class="menu">FAQ</a>
               </li>
            </ul>
        </nav>
    </header>

    @yield('public-content')

    <footer class="mobile-footer">
        <div class="footer-main">
            <div class="container mobile-footer">
                <div class="footer-item">
                    <h2>Bizimlə əlaqə</h2> 
                    @if($contact[0]->is_deleted===0)
                    <p>{{ $contact[0]->name }}</p>
                    @endif
                    @if($contact[1]->is_deleted===0)
                    <p>{{ $contact[1]->name }}</p> 
                    @endif
                </div>
                <div class="footer-item">
                    <img src="/assets/img/footer-logo.png" alt="" />
                </div>
                <div class="footer-item">
                    @if($contact[2]->is_deleted===0)
                    <a href="{{ $contact[2]->name }}" target="_blank">
                        <img src="/assets/img/facebook.svg" alt="">
                    </a>
                    @endif
                    @if($contact[3]->is_deleted===0)
                    <a href="{{ $contact[3]->name }}" target="_blank">
                        <img src="/assets/img/instagram.svg" alt="">
                    </a>
                    @endif
                    @if($contact[4]->is_deleted===0)
                    <a href="{{ $contact[4]->name }}" target="_blank">
                        <img src="/assets/img/youtube.svg" alt="">
                    </a>
                    @endif
                    @if($contact[5]->is_deleted===0)
                    <a href="{{ $contact[5]->name }}" target="_blank">
                        <img src="/assets/img/mail.svg" alt="">
                    </a>
                    @endif
                    @if($contact[6]->is_deleted===0)
                    <a href="{{ $contact[6]->name }}" target="_blank">
                        <img src="/assets/img/twitter.svg" alt="">
                    </a>
                    @endif 
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                © 2022 myvisa.az Bütün hüquqlar qorunur.
            </div>
        </div>
    </footer>
    @yield('js')
    <script>

        const menuBtn= document.querySelector('.mobile-button');
        const mobileNav= document.querySelector('.mobile-nav');
        let menuOpen=false;
        menuBtn.addEventListener('click',()=>{
            if (!menuOpen) {
                menuBtn.classList.add('open');
                mobileNav.style.display="block"
                menuOpen=true;
            }
            else{
                menuBtn.classList.remove('open');
                mobileNav.style.display="none"
                menuOpen=false;
            }
        });

        function myFunction(tag, boxSelection) {
            var input, filter, ul, li, a, i, txtValue;
            input = tag;
            filter = input.value.toUpperCase(); 
            li = document.querySelectorAll(boxSelection);
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("span")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        function validateMyForm() {

            let check = true;

            //error tags
            var fNameErrorTag = document.getElementById("first-name-error");
            var lNameErrorTag = document.getElementById("last-name-error");
            // var mailErrorTag = document.getElementById("mail-error");
            var numberErrorTag = document.getElementById("number-error"); 

            let fName = document.forms["my-form"]["fName"].value;
            let lName = document.forms["my-form"]["lName"].value;
            // let mail = document.forms["my-form"]["mail"].value;
            let number = document.forms["my-form"]["number"].value;

            if (fName.length < 3) {
                check = false;
                fNameErrorTag.textContent = "Zəhmət olmasa adınızı daxil edin" 
            } else {
                fNameErrorTag.textContent = "" 
            }

            if (lName.length < 3) {
                check = false;
                lNameErrorTag.textContent = "Zəhmət olmasa soyadınızı daxil edin" 
            } else {
                lNameErrorTag.textContent = "" 
            }

            // if (mail.length < 4) {
            //     check = false;
            //     mailErrorTag.textContent = "Zəhmət olmasa email daxil edin" 
            // } else {
            //     mailErrorTag.textContent = "" 
            // }

            if (number.length < 9) {
                check = false;
                numberErrorTag.textContent = "Zəhmət olmasa mobil nömrənizi düzgün formatda daxil edin" 
            } else {
                numberErrorTag.textContent = "" 
            }

            if(!check) { 
                return false;
            }

        };
        
    </script>
</body>
</html>