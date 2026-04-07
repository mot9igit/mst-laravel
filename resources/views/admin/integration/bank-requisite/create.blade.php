@extends('layouts.admin.base')
@section('header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Панель администратора</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.integration.organization.index') }}">Организации</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.integration.organization.update', ['organization' => $organization->id]) }}">{{ $organization->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.integration.organization.requisite.update', ['organization' => $organization->id, 'requisite' => $requisite->id]) }}">{{ $requisite->inn }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Создание банковских реквизитов</li>
                </ol>
            </div>
            <div class="col-sm-12"><h3 class="mb-0">Создание банковских реквизитов</h3></div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card card-primary card-outline mb-4">
        <create-bank-requisite-component :org_id="{{ $organization->id }}" :requisite_id="{{ $requisite->id }}"></create-bank-requisite-component>
    </div>
@endsection
