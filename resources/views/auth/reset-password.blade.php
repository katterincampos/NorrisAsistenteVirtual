@extends('layouts.sitio')

@section('content')
<div class="container row justify-content-md-center">
  <div class="col col-md col-md-8 mb-3">
    <div class="">
      <div class="container">
        <div class="row">
            <div class="col col-md-6 contenedor">
                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    <h1>Restablecer contraseña</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input class="mb-2" name="email" type="email" placeholder="Correo electrónico" required />
                    <input class="mb-2" name="password" type="password" placeholder="Nueva contraseña" required />
                    <input class="mb-2" name="password_confirmation" type="password" placeholder="Confirmar nueva contraseña" required />
                    <button class="btn btn-primary mt-2" type="submit">Restablecer contraseña</button>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
