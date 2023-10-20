@extends('layouts.appweb')

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
            <h3>Mi perfil</h3>
            <button id="editButton" class="btn btn-secondary">Editar</button>
        </div>
        @if(session('profile_updated'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ¡Perfil actualizado con éxito!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($patient)
        <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{ $patient->id }}">

            <div class="form-group mt-3">
                <img id="image_preview" src="{{ $patient->imagen_perfil ?? '' }}" alt="Vista previa de imagen" style="max-width: 200px; max-height: 200px;">
            </div>
            <div class="form-group" id="imageUploadDiv" style="display: none;">
                <label for="imagen_perfil">Imagen de Perfil</label>
                <input type="file" class="form-control" id="imagen_perfil" name="imagen_perfil" onchange="previewImage(event)" disabled>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $patient->name }}" required disabled>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $patient->email }}" required disabled>
            </div>

            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $patient->fecha_nacimiento }}" required disabled>
            </div>

            <div class="form-group">
                <label for="genero">Género</label>
                <input type="text" class="form-control" id="genero" name="genero" value="{{ $patient->genero }}" required disabled>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $patient->telefono }}" required disabled>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $patient->direccion }}" required disabled>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $patient->ciudad }}" required disabled>
            </div>

            <div class="form-group">
                <label for="pais">País</label>
                <input type="text" class="form-control" id="pais" name="pais" value="{{ $patient->pais }}" required disabled>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
            </div>
        </form>
        @else
        <p>Paciente no encontrado.</p>
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
