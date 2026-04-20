@extends('layouts.admin.base')
@section('header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Панель администратора</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.integration.store.index') }}">Точки продаж</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $store->name }}</li>
                </ol>
            </div>
            <div class="col-sm-12"><h3 class="mb-0">Редактирование точки продаж</h3></div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card card-primary card-outline mb-4">
        <update-store-component :store_id="{{ $store->id }}"></update-store-component>
    </div>
@endsection
