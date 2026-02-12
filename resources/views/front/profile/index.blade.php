
@extends('layouts.index')

@section('content')
    <h2>Ты в Профиле, Чувак!</h2>
    <div>
        <a href="{{ route("auth.logout") }}" class="href">Выйти</a>
    </div>
    <div id="app">
    </div>
@endsection
