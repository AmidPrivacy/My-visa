<header class="p-3 bg-primary text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center" style="justify-content: right; margin-bottom: 15px;">
 
      <div class="form-check form-switch" id="user-activate" data-id="{{auth()->user()->id}}" style="margin-left: 22px; width: 100px; padding: 6px;">
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
                  margin-right: 25px;
                  background-color: black;
                  border-radius: 20px;
                  text-decoration: none;"
        >
          FAQ üçün keçid edin
        </a>  
      </div>
      <div class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <a href="/admin/crm" target="_blank"
          style=" color: #fff;
                  padding: 10px 18px;
                  margin-right: 25px;
                  background-color: black;
                  border-radius: 20px;
                  text-decoration: none;"
        >
          CRM üçün keçid edin
        </a>  
      </div>
      
      <div class="dropdown">
        <button type="button" class="btn btn-dark notification-toggle">
          Bildirişlər <span class="badge badge-light">0</span>
        </button> 

        <div class="dropdown-menu notification-window">
          <ul class="list-group"> </ul> 
        </div>
      </div>
      @auth
        <div class="text-end" style="min-width: 200px">
        {{auth()->user()->name}}
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
    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"> 
        <li><a href="/admin/appeals" class="nav-link px-2 text-white">Ümumi müraciətlər</a></li> 
        <li><a href="/admin/country-appeals" class="nav-link px-2 text-white">Müraciətlər(ölkə)</a></li>
        <li><a href="/admin/service-appeals" class="nav-link px-2 text-white">Müraciətlər(xidmət)</a></li>
        <li><a href="/admin/country-list" class="nav-link px-2 text-white">Ölkələr</a></li>
        <li><a href="/admin/type-list" class="nav-link px-2 text-white">Viza növləri</a></li> 
        <li><a href="/admin/file-list" class="nav-link px-2 text-white">Fayllar</a></li>
        <li><a href="/admin/excell-list" class="nav-link px-2 text-white">Excell</a></li>
        <li><a href="/admin/faq-list" class="nav-link px-2 text-white">FAQ kontent</a></li> 
        @if(auth()->user()->role_id !== 1)
        <li><a href="/admin/tour-list" class="nav-link px-2 text-white">Turlar</a></li> 
        <li><a href="/admin/blog-list" class="nav-link px-2 text-white">Bloqlar</a></li> 
        <li><a href="/admin/question-list" class="nav-link px-2 text-white">Suallar</a></li> 
        <li><a href="/admin/service-list" class="nav-link px-2 text-white">Xidmətlər</a></li> 
        <li><a href="/admin/contact" class="nav-link px-2 text-white">Əlaqə</a></li> 
        @endif
      </ul>
  </div>
</header>