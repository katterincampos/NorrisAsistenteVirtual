@extends('layouts.sitio')

@section('content')
<div class="container row justify-content-md-center">
  <div class="col col-md col-md-8 mb-3">
    <div class="">
      <div class="container">
        <div class="row justify-content-center" >
            <div class="col col-md-6 contenedor">
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <h1>Restablecer contraseña</h1>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <input class="mb-2" name="email" type="email" placeholder="Correo electrónico" required />
                    <button class="btn btn-primary mt-2" type="submit">Reestablecer</button>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection