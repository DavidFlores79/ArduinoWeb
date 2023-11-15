@extends('layouts.main')

@section('page-title', 'Usuarios')
@section('ngApp', 'users')
@section('ngController', 'users')

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
                                    <th scope="col">UID</th>
                                    <th scope="col">Entrada</th>
                                    <th scope="col">Salida</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="dato in datos track by $index">
                                    <td>@{{ dato.id }}</td>
                                    <td>@{{ dato.name }}</td>
                                    <td>@{{ dato.email }}</td>
                                    <td>@{{ dato.uid }}</td>
                                    <td>@{{ dato.horario_entrada }}</td>
                                    <td>@{{ dato.horario_salida }}</td>
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
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input class="form-control" type="text" name="name" ng-model="createForm.name" id="name" required min="3">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" ng-model="createForm.email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" ng-model="createForm.password" id="password" required min="8">
                    </div>
                    <div class="form-group">
                        <label for="uid">UID</label>
                        <!-- <input class="form-control" type="text" name="uid" ng-model="createForm.uid" id="uid" pattern="[A-Za-z0-9]+(\s([A-Za-z0-9]+\s))+[A-Za-z0-9]+(\s([A-Za-z0-9]{2}))" placeholder="C1 2F D6 0E"> -->
                        <input class="form-control" type="text" name="uid" ng-model="createForm.uid" id="uid" placeholder="C12FD60E">
                    </div>
                    <div class="form-group">
                        <label for="entrada">Entrada</label>
                        <input id="timepicker-entrada" class="form-control" placeholder="p.e. 09:15" required/>
                    </div>
                    <div class="form-group">
                        <label for="salida">Salida</label>
                        <input id="timepicker-salida" class="form-control" placeholder="p.e. 20:30" required/>
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
                    <div class="form-group">
                        <label for="edit-name">Nombre</label>
                        <input class="form-control" type="text" name="edit-name" ng-model="editForm.name" id="edit-name">
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email</label>
                        <input class="form-control" type="email" name="edit-email" ng-model="editForm.email" id="edit-email">
                    </div>
                    <div class="form-group">
                        <label for="uid">UID</label>
                        <!-- <input class="form-control" type="text" name="edit-uid" ng-model="editForm.uid" id="edit-uid" pattern="[A-Za-z0-9]+(\s([A-Za-z0-9]+\s))+[A-Za-z0-9]+(\s([A-Za-z0-9]{2}))" placeholder="C1 2F D6 0E"> -->
                        <input class="form-control" type="text" name="edit-uid" ng-model="editForm.uid" id="edit-uid" placeholder="C12FD60E">
                    </div>
                    <div class="form-group">
                        <label for="entrada">Entrada</label>
                        <input id="edit-entrada" class="form-control" placeholder="p.e. 09:15" required/>
                    </div>
                    <div class="form-group">
                        <label for="salida">Salida</label>
                        <input id="edit-salida" class="form-control" ng-model="editForm.horario_salida" placeholder="p.e. 20:30" required/>
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
                <h5 class="modal-title" id="eliminarModalLabel">Crear Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Realmente desea eliminar al usuario <span class="font-weight-bold" id="nombre-usuario"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" ng-click="delete(usuario)">Eliminar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ngFile')
<script src="{{ asset('js/users.js') }}"></script>

@endsection

@section('scripts')

<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script>
    $('#timepicker-entrada, #edit-entrada').timepicker({
        uiLibrary: 'bootstrap4'
    });
    $('#timepicker-salida, #edit-salida').timepicker({
        uiLibrary: 'bootstrap4'
    });
</script>
@endsection