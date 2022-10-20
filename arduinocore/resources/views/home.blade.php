@extends('layouts.main')

@section('page-title', 'Registro de Datos')
@section('ngApp', 'home')
@section('ngController', 'home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    @yield('page-title')
                    <button class="btn btn-sm btn-success float-right" ng-click="create()"><i class="fas fa-plus-square"></i></button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="dato in datos track by $index">
                                    <td>@{{ dato.id }}</td>
                                    <td>@{{ dato.name }}</td>
                                    <td>@{{ dato.email }}</td>
                                    <td>@{{ dato.created_at | date }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(dato)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(dato)" ng-if="dato.id != {{ auth()->user()->id }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('ngFile')
<script src="{{ asset('js/home.js') }}"></script>

@endsection