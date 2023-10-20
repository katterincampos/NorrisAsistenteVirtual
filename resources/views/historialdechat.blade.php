@extends('layouts.appasociados')

@section('content')
    <div id="app" class="m-0">
        <historial-chat></historial-chat>
    </div>
@endsection

@section('scripts')
@vite('resources/js/app.js')
@endsection
