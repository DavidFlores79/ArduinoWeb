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
                    <h5 class="font-weight-bold centers-title my-2 my-sm-0">@yield('page-title')</h5>
                    <input type="text" name="buscar" class="search-query form-control col-12 col-sm-3 " placeholder="Buscar..." ng-model="searchQuery">
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sensor</th>
                                    <th scope="col">Temperatura</th>
                                    <th scope="col">Humedad</th>
                                    <th scope="col">Fecha Registro</th>
                                    <!-- <th scope="col">Opciones</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="dato in datos track by $index">
                                <tr dir-paginate="dato in datosFiltrados = (datos|filter:searchQuery|orderBy:sortType:sortReverse)|itemsPerPage:pageSize" current-page="currentPage" pagination-id="itemsPagination">
                                    <td>@{{ dato.id }}</td>
                                    <td>@{{ dato.sensor }}</td>
                                    <td>@{{ dato.temperatura | number : 2 | temperatura }}</td>
                                    <td>@{{ dato.humedad | number : 2 | humedad}}</td>
                                    <td>@{{ dato.created_at | date:"MM/dd/yyyy 'a las' hh:mma"}}</td>
                                    <!-- <td>
                                        <button type="button" class="btn btn-sm btn-primary" ng-click="edit(dato)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" ng-click="confirmarEliminar(dato)" ng-if="dato.id != {{ auth()->user()->id }}"><i class="fas fa-trash"></i></button>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                        <div class="float-right">
                            @{{ datos.length }} Registros
                        </div>
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



@endsection

@section('ngFile')
<script src="{{ asset('js/home.js') }}"></script>

@endsection