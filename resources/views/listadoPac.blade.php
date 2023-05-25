@extends('layouts.sitio')

@section('content')
    <div id="app">
        <users-table></users-table>
    </div>
@endsection

@section('scripts')
@vite('resources/js/app.js')
@endsection
