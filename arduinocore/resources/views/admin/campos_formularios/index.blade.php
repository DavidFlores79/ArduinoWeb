@extends('layouts.main')

@section('page-title', 'Crear Formularios')
@section('ngApp', 'campos_formularios')
@section('ngController', 'campos_formularios')

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
                                    <th scope="col">Formulario</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Campo</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="campos_formulario in campos_formularios track by $index">
                                    <td>@{{ campos_formulario.id }}</td>
                                    <td>@{{ campos_formulario.tipo_formulario.nombre }}</td>
                                    <td>@{{ campos_formulario.tipo_campo.nombre }}</td>
                                    <td>@{{ campos_formulario.nombre }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(campos_formulario)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(campos_formulario)"><i class="fas fa-trash"></i></button>
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


<!-- Modal Crear campos_formulario -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Crear campos_formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" ng-submit="store()" class="was-validated">
                    <div class="form-group">
                        <label for="formulario">Formulario:</label>
                        <select class="form-control" 
                                id="formulario" 
                                name="formulario" 
                                ng-model="createForm.formulario"
                                ng-options="formulario.id as formulario.nombre for formulario in formularios"
                                required
                                ng-change="camposTabla()">
                            <option value="">Elige una opcion...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipo_campo">Tipos de Campo:</label>
                        <select class="form-control" 
                                id="tipo_campo" 
                                name="tipo_campo" 
                                ng-model="createForm.tipo_campo"
                                ng-options="tipo_campo.id as tipo_campo.nombre for tipo_campo in tipos_campo"
                                required>
                            <option value="">Elige una opcion...</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" ng-if="createForm.tipo_campo == 6" >
                                <label for="minlength">Ng-Options</label>
                                <input type="text" name="ng_options" id="ng_options" class="form-control" placeholder="p.ej. colores" ng-model="createForm.ng_options" required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-if="createForm.tipo_campo == 1 || createForm.tipo_campo == 3" >
                        <label for="minlength">Tamaño mínimo (minlength)</label>
                        <input type="number" name="minlength" min="0" step="1" id="minlength" class="form-control" placeholder="Tamaño mínimo" ng-model="createForm.minlength" required autofocus>
                    </div>
                    <div class="form-group" ng-if="createForm.tipo_campo == 4">
                        <label for="min">Tamaño mínimo (min)</label>
                        <input type="number" name="min" min="0" step="1" id="min" class="form-control" placeholder="Tamaño mínimo" ng-model="createForm.min" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <select class="form-control" name="nombre" id="nombre" ng-model="createForm.nombre" ng-options="nombre_campo for nombre_campo in nombre_campos" required>
                            <option value="">Elige una opcion...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="etiqueta">Etiqueta (label):</label>
                        <input type="text" name="etiqueta" id="etiqueta" class="form-control" placeholder="Etiqueta (label)" ng-model="createForm.etiqueta" required autofocus>
                    </div>
                    <div class="form-group custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="requerido" name="requerido" ng-model="createForm.requerido">
                        <input type="hidden" id="input-requerido">
                        <label class="custom-control-label" for="requerido">
                            Requerido
                        </label>
                    </div>
                    <div class="form-group custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="sololectura" name="sololectura" ng-model="createForm.sololectura">
                        <input type="hidden" id="input-sololectura">
                        <label class="custom-control-label" for="sololectura">
                            Solo Lectura
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

<!-- Modal Editar campos_formulario -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Campo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="update()" class="was-validated" ng-model="editForm">
                    <div class="form-group">
                        <label for="edit-tipo_formulario_id">Formulario:</label>
                        <select class="form-control" 
                                id="edit-tipo_formulario_id" 
                                name="edit-tipo_formulario_id" 
                                ng-model="editForm.tipo_formulario_id" 
                                ng-selected="formulario.id == editForm.tipo_formulario_id"
                                ng-options="formulario.id as formulario.nombre for formulario in formularios"
                                ng-change="camposTabla()">
                            <option value="">Elige una opcion...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <select class="form-control"
                                name="edit-nombre" 
                                id="edit-nombre" 
                                ng-model="editForm.nombre" 
                                ng-selected="nombre_campo == editForm.nombre"
                                ng-options="nombre_campo for nombre_campo in nombre_campos" 
                                required>
                            <option value="">Elige una opcion...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-etiqueta">Etiqueta (label):</label>
                        <input type="text" name="edit-etiqueta" id="edit-etiqueta" class="form-control" placeholder="Etiqueta (label)" ng-model="editForm.etiqueta" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="tipo_campo">Tipos de Campo:</label>
                        <select class="form-control" 
                                id="edit-tipo_campo" 
                                name="edit-tipo_campo" 
                                ng-model="editForm.tipo_campo_id"
                                ng-selected="tipo_campo.id == editForm.tipo_campo.id"
                                ng-options="tipo_campo.id as tipo_campo.nombre for tipo_campo in tipos_campo">
                            <option value="">Elige una opcion...</option>
                        </select>
                    </div>
                    <div class="form-group" ng-if="editForm.tipo_campo.nombre == 'text' || editForm.tipo_campo.nombre == 'password'" >
                        <label for="minlength">Tamaño mínimo (minlength)</label>
                        <input type="number" name="edit-minlength" min="0" step="1" id="edit-minlength" class="form-control" placeholder="Tamaño mínimo" ng-model="editForm.minlength" required autofocus>
                    </div>
                    <div class="form-group" ng-if="editForm.tipo_campo.nombre == 'number'">
                        <label for="min">Tamaño mínimo (min)</label>
                        <input type="number" name="edit-min" min="0" step="1" id="edit-min" class="form-control" placeholder="Tamaño mínimo" ng-model="editForm.min" required autofocus>
                    </div>
                    <div class="form-group" ng-if="editForm.tipo_campo.nombre == 'selectbox'">
                        <label for="minlength">Ng-Options</label>
                        <input type="text" name="edit-ng_options" id="edit-ng_options" class="form-control" placeholder="color.id as color.nombre disable when color.shade == 'dark' for color in colores" ng-model="editForm.ng_options" required autofocus>
                    </div>
                    <div class="form-group custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="edit-requerido" name="edit-requerido" ng-checked="editForm.requerido == 1" ng-model="requerido">
                        <input type="hidden" id="input-requerido">
                        <label class="custom-control-label" for="edit-requerido">
                            Requerido
                        </label>
                    </div>
                    <div class="form-group custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="edit-sololectura" name="edit-sololectura" ng-checked="editForm.sololectura == 1" ng-model="editForm.sololectura">
                        <label class="custom-control-label" for="edit-sololectura">
                            Solo Lectura
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

<!-- Modal Eliminar campos_formulario-->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Crear campos_formulario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar el campo <span class="font-weight-bold" id="nombre-campos_formulario"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(campos_formulario)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/campos_formularios.js') }}"></script>

@endsection