@extends('layouts.admin.base')
@section('header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Панель администратора</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Пользователи</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Создание</li>
                </ol>
            </div>
            <div class="col-sm-12"><h3 class="mb-0">Создание пользователя</h3></div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card card-primary card-outline mb-4">
        <create-user-component></create-user-component>
    </div>
@endsection
