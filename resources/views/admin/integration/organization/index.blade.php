@extends('layouts.admin.base')
@section('header')
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Панель администратора</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Организации</li>
                </ol>
            </div>
            <div class="col-sm-12"><h3 class="mb-0">Организации</h3></div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <show-organization-component></show-organization-component>
        </div>
    </div>
@endsection
