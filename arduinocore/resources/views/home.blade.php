@extends('layouts.main')

@section('page-title', 'Registro de Datos')
@section('ngApp', 'home')
@section('ngController', 'home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-default d-flex flex-column flex-sm-row justify-content-between ">
                    <div class=" centers-title my-2 my-sm-0">
                        <h5 class="font-weight-bold">@yield('page-title')</h5>
                        <small class="text-muted">Hoy {{ date('d-M-Y') }}</small>
                    </div>
                    <input type="text" name="buscar" class="search-query form-control col-12 col-sm-4 col-xs-3 " placeholder="Buscar..." ng-model="searchQuery">
                </div>
                <div class="card-body">
                    <div class="my-2 float-right text-muted small">
                        <span class="mx-2">@{{ datos.length }} registros</span>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#sensoresModal">
                            <!-- <i class="fas fa-chart-bar"></i> -->
                            <!-- <i class="fas fa-chart-pie"></i> -->
                            <i class="far fa-chart-bar"></i>
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Sensor</th>
                                    <th scope="col">Temperatura</th>
                                    <th scope="col">Humedad</th>
                                    <!-- <th scope="col">Opciones</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="dato in datos track by $index">
                                <tr dir-paginate="dato in datosFiltrados = (datos|filter:searchQuery|orderBy:sortType:sortReverse)|itemsPerPage:pageSize" current-page="currentPage" pagination-id="itemsPagination">
                                    <td>@{{ dato.id }}</td>
                                    <td>@{{ dato.created_at | date:"hh:mm:ss a"}}</td>
                                    <td>@{{ dato.sensor }}</td>
                                    <td>@{{ dato.temperatura | number : 2 | temperatura }}</td>
                                    <td>@{{ dato.humedad | number : 2 | humedad}}</td>
                                    <!-- <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(dato)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(dato)" ng-if="dato.id != {{ auth()->user()->id }}"><i class="fas fa-trash"></i></button>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                        <div class="btn-toolbar " role="toolbar" aria-label="Calimax">
                            <dir-pagination-controls boundary-links="true" pagination-id="itemsPagination" on-page-change="pageChangeHandler(newPageNumber)">
                            </dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="sensoresModal" tabindex="-1" aria-labelledby="sensoresModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sensoresModalLabel">Gráficas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-12"><span class="text-muted">Por hora del día {{ date('d-M-Y') }}</span></div>
                    <div class="ct-chart col-md-12 my-4"></div>
                    <div class="col-12"><span class="text-muted">Temperatura y Humedad (últimas lecturas)</span></div>
                    <div class="ct-chart1 col-md-6"></div>
                    <div class="ct-chart2 col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ngFile')
<script src="{{ asset('js/home.js') }}"></script>
@endsection

@section('scripts')
<script>
    moment().format();
</script>
@endsection

@section('styles')
<style>
    .ct-chart1 .ct-chart-donut .ct-slice-donut-solid {
        fill: lightgreen !important;
    }

    .ct-chart2 .ct-chart-donut .ct-slice-donut-solid {
        fill: rgba(30, 105, 166, 0.6)
    }

    .fa-chart-bar {
        font-size: 18px;
    }
</style>
@endsection