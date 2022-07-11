<header class="p-3 bg-primary text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/admin/crm" class="nav-link px-2 text-white">CRM</a></li>
        <li><a href="/admin/appeals" class="nav-link px-2 text-white">Müraciətlər</a></li>
        <li><a href="/admin/country-list" class="nav-link px-2 text-white">Ölkələr</a></li>
        <li><a href="/admin/type-list" class="nav-link px-2 text-white">Viza növləri</a></li> 
        <li><a href="/admin/file-list" class="nav-link px-2 text-white">Fayllar</a></li>
        <li><a href="/admin/excell-list" class="nav-link px-2 text-white">Excell</a></li>
        <li><a href="/admin/faq-list" class="nav-link px-2 text-white">FAQ kontent</a></li> 
      </ul>
      
      <div class="form-check form-switch" id="user-activate" data-id="{{auth()->user()->id}}" style="margin-right: 22px; width: 100px; padding: 6px;">
        <input type="hidden" name="_token" id="request_csrf" value="{{ csrf_token() }}" />
        <label class="form-check-label" >{{auth()->user()->status==0? 'Offline': 'Online'}}</label>
        <input class="form-check-input" type="checkbox" {{auth()->user()->status==0? '': 'checked'}} role="switch" id="flexSwitchCheckDefault">
      </div>
      @if(auth()->user()->role_id !== 1)
      <div style="position: relative; right: 25px">
        <a href="/admin/users">
          <img src="/assets/img/user.png" alt="" style="width: 40px">
        </a>
      </div>
      @endif
      <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <a href="/home" target="_blank"
          style=" color: #fff;
                  padding: 10px 18px;
                  margin-right: 26px;
                  background-color: black;
                  border-radius: 20px;
                  text-decoration: none;"
        >
          FAQ üçün keçid edin
        </a>  
      </div>
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