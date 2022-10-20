@extends('layouts.main')

@section('page-title', 'Perfiles')
@section('ngApp', 'perfiles')
@section('ngController', 'perfiles')

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
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Visible</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="dato in datos track by $index">
                                    <td>@{{ dato.id }}</td>
                                    <td>@{{ dato.nombre }}</td>
                                    <td>@{{ dato.created_at | date }}</td>
                                    <td ng-class="{0:'text-danger', 1:'text-success'}[dato.estatus]">@{{ dato.estatus | activoInactivo }}</td>
                                    <td ng-class="{0:'text-danger', 1:'text-success'}[dato.visible]">@{{ dato.visible | siNo }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(dato)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(dato)"><i class="fas fa-trash"></i></button>
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


<!-- Modal Crear -->
<div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Crear @yield('page-title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createForm" ng-submit="store()" class="was-validated">
                    <div class="form-group" ng-repeat="campo in formulario_crear track by $index">
                        <label for="@{{ campo.nombre }}" ng-if="campo.tipo_campo.nombre != 'hidden' && campo.tipo_campo.nombre != 'toggleswitch'">@{{ campo.etiqueta }}</label>
                        
                        <select ng-if="campo.tipo_campo.nombre == 'selectbox'"
                                class="form-control" 
                                id="@{{ campo.nombre }}" 
                                name="@{{ campo.nombre }}"
                                ng-model="createForm[campo.nombre]"
                                ng-options="@{{ campo.ng_options }}"
                                ng-readonly="@{{ campo.sololectura }}"
                                ng-required="@{{ campo.requerido }}">
                                <option value="">Selecciona...</option>
                        </select>
                        
                        <input  type="@{{ campo.tipo_campo.nombre }}" 
                                minlength="@{{ campo.minlength }}" 
                                min="@{{ campo.min }}" 
                                ng-readonly="@{{ campo.sololectura }}"
                                name="@{{ campo.nombre }}" 
                                id="@{{ campo.nombre }}" 
                                class="form-control" 
                                placeholder="Escribe tu @{{ campo.etiqueta }}"
                                ng-model="createForm[campo.nombre]"
                                ng-required="@{{ campo.requerido }}"
                                ng-if="campo.tipo_campo.nombre != 'selectbox' && campo.tipo_campo.nombre != 'toggleswitch'"
                        autofocus>

                        <div class="custom-control custom-switch" ng-if="campo.tipo_campo.nombre == 'toggleswitch'">
                            <input  type="checkbox"
                                    class="custom-control-input"
                                    name="@{{ campo.id }}-@{{ campo.nombre }}" 
                                    id="@{{ campo.id }}-@{{ campo.nombre }}" 
                                    ng-model="createForm[campo.nombre]">
                            <label class="custom-control-label" for="@{{ campo.id }}-@{{ campo.nombre }}">@{{ campo.etiqueta }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar @yield('page-title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form ng-submit="update()" class="was-validated">
                    <div class="form-group" ng-repeat="campo in formulario_editar track by $index">
                        <label ng-if="campo.tipo_campo.nombre != 'hidden' && campo.tipo_campo.nombre != 'toggleswitch'" for="@{{ campo.nombre }}">@{{ campo.etiqueta }}</label>
                        <select ng-if="campo.tipo_campo.nombre == 'selectbox'"
                                class="form-control" 
                                id="@{{ campo.nombre }}" 
                                name="@{{ campo.nombre }}"
                                ng-model="editForm[campo.nombre]"
                                ng-options="@{{ campo.ng_options }}"
                                ng-readonly="@{{ campo.sololectura }}"
                                ng-required="@{{ campo.requerido }}">
                                <option value="">Selecciona...</option>
                        </select>

                        <input  type="@{{ campo.tipo_campo.nombre }}" 
                                minlength="@{{ campo.minlength }}" 
                                min="@{{ campo.min }}" 
                                ng-readonly="@{{ campo.sololectura }}"
                                name="@{{ campo.nombre }}" 
                                id="@{{ campo.nombre }}" 
                                class="form-control" 
                                placeholder="Escribe tu @{{ campo.etiqueta }}"
                                ng-model="editForm[campo.nombre]"
                                ng-required="@{{ campo.requerido }}"
                                ng-if="campo.tipo_campo.nombre != 'selectbox' && campo.tipo_campo.nombre != 'toggleswitch'"
                                autofocus>
                        <div class="custom-control custom-switch" ng-if="campo.tipo_campo.nombre == 'toggleswitch'">
                            <input  type="checkbox"
                                    class="custom-control-input"
                                    name="@{{ campo.id }}-@{{ campo.nombre }}" 
                                    id="@{{ campo.id }}-@{{ campo.nombre }}" 
                                    ng-model="editForm[campo.nombre]">
                            <label class="custom-control-label" for="@{{ campo.id }}-@{{ campo.nombre }}">@{{ campo.etiqueta }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar-->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Crear Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar al perfil <span class="font-weight-bold" id="nombre-dato"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(dato)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/perfiles.js') }}"></script>

@endsection