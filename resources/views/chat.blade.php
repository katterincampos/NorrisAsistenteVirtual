@extends('layouts.sitio')

@section('content')
    <div id="app">
        <chat-component></chat-component>
    </div>
@endsection

@section('scripts')
@vite('resources/js/app.js')
@endsection
