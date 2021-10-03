@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card-group mb-0">
            <div class="card p-4 bg-white">
            <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
            {{ csrf_field() }}
                <div class="card-body bg-light">
                <h1>Acceder</h1>
                <p class="text-muted">Control de acceso al sistema</p>
                <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary px-4">Acceder</button>
                </div>
                </div>
            </div>
            <br>
            <br>
            <h6 style="color:#ABB2B9">Todos los derechos reservados &copy;Arcatech</h6>
            </form>
            </div>
            <div class="card text-white bg-dark  py-1 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                
                    <img src="img\5.png" class="card-img-top" alt="Cinque Terre" width="100%" height="60%"> 
                    <h4>Sistema Arcatech </h4>
                    <p>  Sistem Javier Tecnology</p>  
                
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
