@extends('layouts.main')

@section('page-title', 'Tipos de Formulario')
@section('ngApp', 'tipo_formularios')
@section('ngController', 'tipo_formularios')

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
                                    <th scope="col">Tabla</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="tipo_formulario in tipo_formularios track by $index">
                                    <td>@{{ tipo_formulario.id }}</td>
                                    <td>@{{ tipo_formulario.nombre }}</td>
                                    <td>@{{ tipo_formulario.tabla }}</td>
                                    <td>@{{ tipo_formulario.created_at | date }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(tipo_formulario)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(tipo_formulario)"><i class="fas fa-trash"></i></button>
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


<!-- Modal Crear tipo_formulario -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Crear tipo_formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" ng-submit="store()" class="was-validated">
                    <div class="form-group">
                        <label for="nombre">Formulario:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del Formulario" ng-model="createForm.nombre" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="edit-tabla">Tabla:</label>
                        <select class="form-control" id="tabla" name="tabla" ng-model="createForm.tabla" required autofocus>
                            <option value="">Elige una opcion...</option>
                            <option ng-repeat="tabla in tablas" value="@{{ tabla }}">
                                @{{ tabla }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar tipo_formulario -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar tipo_formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="update()" class="was-validated">
                    <input type="hidden" name="id" id="edit-id" ng-model="editForm.id">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" ng-model="editForm.nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="edit-tabla">Tabla:</label>
                        <select class="form-control" id="edit-tabla" name="edit-tabla" ng-model="editForm.tabla" ng-options="tabla for tabla in tablas">
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar tipo_formulario-->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Crear tipo_formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar al tipo_formulario <span class="font-weight-bold" id="nombre-tipo_formulario"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(tipo_formulario)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/tipo_formularios.js') }}"></script>
@endsection