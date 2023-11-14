@extends('layouts.main')

@section('page-title', 'Categorías de Módulos')
@section('ngApp', 'categories')
@section('ngController', 'categories')

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
                                    <th scope="col">Título</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Ícono</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in data track by $index">
                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.short_description }}</td>
                                    <td>@{{ item.long_description }}</td>
                                    <td>@{{ item.icon }}</td>
                                    <td class="d-flex align-items-center border">
                                        <span class="mr-1 badge badge-pill badge-success" ng-if="item.enabled != 0">Habilitado</span>
                                        <span class="mr-1 badge badge-pill badge-danger" ng-if="item.enabled != 1">Deshabilitado</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(item)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(item)"><i class="fas fa-trash"></i></button>
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


<!-- Modal Crear item -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Crear item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" ng-submit="store()" class="was-validated">
                    <div class="form-group">
                        <label for="short_description">Título:</label>
                        <input type="text" name="short_description" id="short_description" class="form-control" placeholder="Título" ng-model="createForm.short_description" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="long_description">Descripción:</label>
                        <input type="text" name="long_description" id="long_description" class="form-control" placeholder="Descripción" ng-model="createForm.long_description" required autofocus>
                    </div>
                    <div class="custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="enabled" name="enabled" ng-model="createForm.enabled" ng-click="toggleEnabledCreate()">
                        <input type="hidden" name="enabled" id="input_enabled" value="@{{enabled}}">
                        <label class="custom-control-label small pt-2" for="enabled">
                            Habilitado
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar item -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="update()" class="was-validated">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="short_description-edit">Título:</label>
                        <input type="text" name="short_description-edit" id="short_description-edit" class="form-control" placeholder="Título" ng-model="editForm.short_description" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="long_description-edit">Descripción:</label>
                        <input type="text" name="long_description-edit" id="long_description-edit" class="form-control" placeholder="Descripción" ng-model="editForm.long_description" required autofocus>
                    </div>
                    <div class="custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="enabled-edit" name="enabled-edit" ng-model="editForm.enabled" ng-click="toggleEnabledCreate()">
                        <input type="hidden" name="enabled-edit" id="input_enabled-edit" value="@{{enabled}}">
                        <label class="custom-control-label small pt-2" for="enabled-edit">
                            Habilitado
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar item-->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Crear item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar al item <span class="font-weight-bold">@{{ item.short_description }}</span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(profile)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/categories.js') }}"></script>
@endsection