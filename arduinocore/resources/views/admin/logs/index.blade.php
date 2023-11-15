@extends('layouts.main')

@section('page-title', 'Bitácora')
@section('ngApp', 'logs')
@section('ngController', 'logs')

@section('content')

    <div class="main mx-auto col-lg-10">
        <div class="card contenedor">
            <div class="card-header bg-default d-md-flex justify-content-between ">
                <h5 class="font-weight-bold centers-title">@yield('page-title')</h5>
                <input type="text" name="buscar" class="search-query form-control col-lg-3 col-md-4 col-sm-12"
                    placeholder="Buscar..." ng-model="searchQuery">
            </div>
            <div class="card-body">
                <div class="row d-flex align-items-stretch">

                    <div class="form-group col-12 col-sm-5 col-md-3">
                        <label for="fecha_desde">Seleccione la fecha de busqueda:</label>
                        <input type="text" ng-model="fechain" class="form-control datepicker fechas"
                        id="fecha_in" title="Fecha Inicial"readonly>
                    </div>

                    <div class="form-group col-12 col-sm-2 col-lg-2 d-flex align-items-end">
                        <button type="button" style="width: 90px" class="btn btn-success form-control"
                            ng-click="searchLogs()">Buscar</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center" id="tbl_admon_mensajes">
                        <thead class="">
                            <tr class="">
                                <th class=""><a class="text-body" href="#"
                                        ng-click="sortType = 'id'; sortReverse = !sortReverse"> ID </a></th>
                                <th><a class="text-body" href=""
                                        ng-click="sortType = 'descripcion'; sortReverse = !sortReverse"> Descripcion </a>
                                </th>
                                <th><a class="text-body" href=""
                                        ng-click="sortType = 'nickname_nombre'; sortReverse = !sortReverse"> Usuario</a>
                                </th>
                                <th><a class="text-body" href=""
                                        ng-click="sortType = 'documento'; sortReverse = !sortReverse"> Doc SAP</a></th>
                                <th><a class="text-body" href=""
                                        ng-click="sortType = 'created_at'; sortReverse = !sortReverse"> Fecha</a></th>
                                <th><a class="text-body" href=""
                                        ng-click="sortType = 'direccion_ip'; sortReverse = !sortReverse"> IP</a></th>
                                <th><a class="text-body" href=""> Opc.</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td ng-if="logs.length == 0" class="text-center" colspan="20">Sin datos guardados
                                </td>
                            </tr>
                            <tr ng-model="logs"
                                dir-paginate="log in datosFiltrados = (logs|filter:searchQuery|orderBy:sortType:sortReverse)|itemsPerPage:pageSize"
                                current-page="currentPage" pagination-id="itemsPagination">
                                <td>@{{ log.id }}</td>
                                <td>@{{ log.description }}</td>
                                <td>@{{ log.nickname_name }}</td>
                                <td>@{{ log.document }}</td>
                                <td>@{{ log.created_at | date: "yyyy-MM-dd '-' h:mma" }}</td>
                                <td>@{{ log.ip_address }}</td>
                                <td><a ng-class="{0:'btn-danger', 1:'btn-info'}[log.success]" class="btn "ng-click="logDetails(log)"><i class="fas fa-info-circle"></i></a></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="btn-toolbar" role="toolbar" aria-label="Calimax">
                        <dir-pagination-controls boundary-links="true" pagination-id="itemsPagination"
                            on-page-change="pageChangeHandler(newPageNumber)">
                        </dir-pagination-controls>
                    </div>

                </div>

                <div class="text-right">
                    @{{ logs.length }} Registros
                </div>

            </div>
        </div>
    </div>

    <!-- Detalle de Bitacora Modal -->
    <div class="modal fade" id="log-modal" tabindex="-1" aria-labelledby="log-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="log-modalLabel">Bitácora</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@{{ log.trace }}</p>
                    <p>Documento: <span class="font-weight-bold">@{{ log.document }}</span></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('ngFile')
    <script src="{{ asset('js/logs.js') }}"></script>
    <script></script>
@endsection