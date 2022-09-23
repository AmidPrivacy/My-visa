<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My visa</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'> 
    @yield('css')
</head>
<body> 
    <header>
        <div class="container">
            <div class="brand">
               <a href="/">
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
    </header>

    @yield('public-content')

    <footer>
        <div class="footer-main">
            <div class="container">
                <div class="footer-item">
                    <h2>Bizimlə əlaqə</h2>
                    <p>+994 00 000 00 00</p>
                    <p>Bakı şəhəri X rayonu X küçəsi X</p>
                </div>
                <div class="footer-item">
                    <img src="/assets/img/footer-logo.svg" alt="" />
                </div>
                <div class="footer-item">
                    <a href="#" target="_blank">
                        <img src="/assets/img/facebook.svg" alt="">
                    </a>
                    <a href="#" target="_blank">
                        <img src="/assets/img/instagram.svg" alt="">
                    </a>
                    <a href="#" target="_blank">
                        <img src="/assets/img/youtube.svg" alt="">
                    </a>
                    
                    <a href="#" target="_blank">
                        <img src="/assets/img/mail.svg" alt="">
                    </a>
                    <a href="#" target="_blank">
                        <img src="/assets/img/twitter.svg" alt="">
                    </a>
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
    </script>
</body>
</html>