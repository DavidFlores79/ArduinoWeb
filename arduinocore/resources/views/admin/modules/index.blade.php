@extends('layouts.main')

@section('page-title', 'Módulos')
@section('ngApp', 'modules')
@section('ngController', 'modules')

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
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Ruta</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in data track by $index">
                                    <td>@{{ item.id }}</td>
                                    <td>
                                        <img ng-if="item.image != null && item.image != ''" ng-src="images/modules/@{{ item.image }}" style="width: 30px">
                                    </td>
                                    <td>@{{ item.category.short_description }}</td>
                                    <td>@{{ item.name }}</td>
                                    <td>@{{ item.description }}</td>
                                    <td>@{{ item.route }}</td>
                                    <td class="d-flex align-items-center justify-content-center border">
                                        <span class="mr-1 badge badge-pill badge-success" ng-if="item.status != 0">Habilitado</span>
                                        <span class="mr-1 badge badge-pill badge-danger" ng-if="item.status != 1">Deshabilitado</span>
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
                        <label for="avatar">Seleccione Imagen</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Categoría:</label>
                        <select class="form-control clases-movimiento" id="category_id" name="category_id" ng-model="createForm.category_id" required autofocus>
                            <option value="">Elige una opcion...</option>
                            <option ng-repeat="category in categories" value="@{{ category.id }}">@{{ category.short_description }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Título" ng-model="createForm.name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Descripción" ng-model="createForm.description" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="route">Ruta:</label>
                        <input type="text" name="route" id="route" class="form-control" placeholder="Descripción" ng-model="createForm.route" required autofocus>
                    </div>
                    <div class="custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="status" name="status" ng-model="createForm.status" ng-click="togglStatusCreate()">
                        <input type="hidden" name="status" id="input_status" value="@{{status}}">
                        <label class="custom-control-label small pt-2" for="status">
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
                <form id="editForm" ng-submit="update()" class="was-validated">
                    <div class="form-group" ng-show="!editForm.image">
                        <label for="avatar">Seleccione Imagen</label>
                        <input type="file" name="avatar" id="avatar2" accept="image/*">
                    </div>
                    <div class="form-group d-flex flex-column align-items-start" ng-if="editForm.image">
                        <label for="">Imagen cargada</label>
                        <span class="badge badge-pill badge-secondary ">
                            @{{ editForm.image }}
                            <span class="btn btn-sm ml-2 rounded-circle close_img text-white" ng-click="deleteImage()">X</span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Categoría:</label>
                        <select class="form-control clases-movimiento" id="category_id-edit" name="category_id-edit" ng-model="editForm.category_id" required autofocus>
                            <option value="">Elige una opcion...</option>
                            <option ng-repeat="category in categories" value="@{{ category.id }}">@{{ category.short_description }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name-edit" id="name-edit" class="form-control" placeholder="Título" ng-model="editForm.name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <input type="text" name="description-edit" id="description-edit" class="form-control" placeholder="Descripción" ng-model="editForm.description" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="route">Ruta:</label>
                        <input type="text" name="route-edit" id="route-edit" class="form-control" placeholder="Descripción" ng-model="editForm.route" required autofocus>
                    </div>

                    <div class="custom-control custom-switch custom-switch-lg">
                        <input type="checkbox" class="custom-control-input form-control" id="status" name="status" ng-model="editForm.status" ng-click="togglStatusCreate()">
                        <input type="hidden" name="status" id="input_status" value="@{{status}}">
                        <label class="custom-control-label small pt-2" for="status">
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

@section('styles')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- FILEPOND -->
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/jquery.serializejson.js') }}"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    // Register the plugin
    FilePond.registerPlugin(FilePondPluginFileValidateType);

    // Get a reference to the file input element
    const imageInput = document.querySelector('input[id="avatar"]');
    const imageInputEdit = document.querySelector('input[id="avatar2"]');

    //Asignando valores de labels al FilePond
    let propiedades = {
        credits: false,
        labelIdle: 'Arrastre y suelte sus archivos o navegue',
        labelFileProcessing: 'Cargando',
        labelFileProcessingComplete: "Carga completa",
        labelTapToUndo: 'Toque para deshacer',
        labelTapToCancel: 'Toque para cancelar',
        labelFileProcessingAborted: 'Carga cancelada',
        labelTapToRetry: 'Toque para reintentar',
        labelInvalidField: 'El campo contiene archivos inválidos',
        labelFileProcessingError: 'Error durante la carga',
    }
    // Create a FilePond instance
    const pond = FilePond.create(imageInput, propiedades);
    const pondEdit = FilePond.create(imageInputEdit, propiedades);

    var pond_ids = [];
    var pond_ids2 = [];

    FilePond.setOptions({
        server: {
            url: "upload",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
    });

    document.addEventListener('FilePond:error', (e) => {
        swal(titulos.mensaje_sistema, "Error al procesar el archivo", tiposDeMensaje.error);
    });
</script>

@endsection

@section('ngFile')
<script src="{{ asset('js/modules.js') }}"></script>
@endsection