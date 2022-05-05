<header class="p-3 bg-primary text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/admin/home" class="nav-link px-2 text-white">Əsas səhifə</a></li>
        <li><a href="/admin/country-list" class="nav-link px-2 text-white">Ölkələr</a></li>
        <li><a href="/admin/type-list" class="nav-link px-2 text-white">Viza növləri</a></li> 
        <li><a href="/admin/file-list" class="nav-link px-2 text-white">Fayllar</a></li>
        <li><a href="/admin/faq-list" class="nav-link px-2 text-white">FAQ kontent</a></li>
      </ul>
 
      @auth
        <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          {{auth()->user()->name}}
        </div>
        
        <div class="text-end">
          <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Çıxış et</a>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
    </div>
  </div>
</header>