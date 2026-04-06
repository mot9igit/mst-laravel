@extends('layouts.admin.base')
@section('header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4"><h3 class="mb-0">Редактирование организации</h3></div>
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Панель администратора</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.integration.organization.index') }}">Организации</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.integration.organization.update', ['organization' => $organization->id]) }}">{{ $organization->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $requisite->inn }}</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card card-primary card-outline mb-4">
        <update-organization-requisite-component :org_id="{{ $organization->id }}" :requisite_id="{{ $requisite->id }}"></update-organization-requisite-component>
    </div>
@endsection
