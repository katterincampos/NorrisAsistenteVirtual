@extends('layouts.appasociados')

@section('content')
<style>
    .profile-container {
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #e3e3e3;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .profile-header h3 {
        margin: 0;
    }

    img#image_preview {
        border-radius: 50%;
        margin-top: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    button[type="submit"] {
        width: 100%;
    }
</style>

<div class="container mt-5">
    <div class="profile-container">
        <div class="profile-header">
            <h3>Mi Perfil</h3>
            <button id="editButton" class="btn btn-secondary">Editar</button>
        </div>
        @if(session('profile_updated'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ¡Perfil actualizado con éxito!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($doctor)
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{ $doctor->id }}">

            <div class="form-group mt-3">
                <img id="image_preview" src="{{ $doctor->profile_image_url ?? '' }}" alt="Vista previa de imagen" style="max-width: 200px; max-height: 200px;">
            </div>
            <div class="form-group" id="imageUploadDiv" style="display: none;">
                <label for="profile_image">Imagen de Perfil</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image" onchange="previewImage(event)" disabled>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $doctor->name }}" required disabled>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $doctor->email }}" required disabled>
            </div>
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $doctor->username }}" required disabled>
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $doctor->address }}" required disabled>
            </div>
            <div class="form-group">
                <label for="city">Ciudad</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $doctor->city }}" required disabled>
            </div>
            <div class="form-group">
                <label for="zip_code">Código Postal</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $doctor->zip_code }}" required disabled>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
            </div>
        </form>
        @else
        <p>Doctor no encontrado.</p>
        @endif
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('editButton').addEventListener('click', function() {
        // Habilitar todos los inputs
        var inputs = document.querySelectorAll('input');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].removeAttribute('disabled');
        }

        // Mostrar el control de subida de imágenes
        document.getElementById('imageUploadDiv').style.display = 'block';
    });
</script>
@endsection
