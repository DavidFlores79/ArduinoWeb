@extends('layouts.main')

@section('page-title', 'Tipo de Campos')
@section('ngApp', 'tipo_campos')
@section('ngController', 'tipo_campos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="tipo_campo in tipo_campos track by $index">
                                    <td>@{{ tipo_campo.id }}</td>
                                    <td>@{{ tipo_campo.nombre }}</td>
                                    <td>@{{ tipo_campo.created_at | date }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(tipo_campo)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(tipo_campo)"><i class="fas fa-trash"></i></button>
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


<!-- Modal Crear tipo_campo -->
<div class="modal fade" id="agregarTipoCampoModal" tabindex="-1" aria-labelledby="agregarTipoCampoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarTipoCampoModalLabel">Crear tipo_campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" ng-submit="store()" class="was-validated">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" ng-model="createForm.nombre" required autofocus>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar tipo_campo -->
<div class="modal fade" id="editarTipoCampoModal" tabindex="-1" aria-labelledby="editarTipoCampoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarTipoCampoModalLabel">Editar tipo_campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="update()" class="was-validated">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar tipo_campo-->
<div class="modal fade" id="eliminarTipoCampoModal" tabindex="-1" aria-labelledby="eliminarTipoCampoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarTipoCampoModalLabel">Crear tipo_campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar al tipo_campo <span class="font-weight-bold" id="nombre-tipo_campo"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(tipo_campo)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/tipo_campos.js') }}"></script>

@endsection