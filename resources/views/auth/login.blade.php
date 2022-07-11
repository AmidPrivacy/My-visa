@extends('layouts.auth-master')

@section('content')
    <form method="post" action="{{ route('login.perform') }}">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <img class="mb-4" src="{!! url('assets/img/logo1.svg') !!}" alt="" style="margin-bottom: 55px !important; width: 170px">
        
        <h1 class="h3 mb-3 fw-normal">Sistemə giriş</h1>

        @include('layouts.partials.messages')

        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="İstifadəçi adı" required="required" autofocus>
            <label for="floatingName">Email və ya istifadəçi adı</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>
        
        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Şifrə" required="required">
            <label for="floatingPassword">Şifrə</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Giriş et</button>
        
        @include('auth.partials.copy')
    </form>
@endsection