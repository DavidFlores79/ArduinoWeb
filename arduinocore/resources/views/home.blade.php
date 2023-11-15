@extends('layouts.main')

@section('page-title', 'Inicio')
@section('ngApp', 'home')
@section('ngController', 'home')

@section('content')
<div class="main mx-auto col-lg-10 d-flex flex-column align-items-center">

    <div class="" ng-repeat="category in menu">
        <h3 class="text-center">@{{ category.short_description }}</h3>
        <div class="card-container">
            <div class="card-body" style="min-width: 15rem; max-width: 15.5rem;" ng-repeat="module in category.modules">
                <a href="@{{ module.route }}">
                    <div class="card m-1 card-modulo">
                        <div class="card-body text-center">
                            <img src="images/modules/@{{ module.image }}" height="60" alt="">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center">@{{ module.name }}</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('ngFile')
<script src="{{ asset('js/home.js') }}"></script>
@endsection