@extends('layouts.app')

@section('css')
    <style>
        .full-height {
            height: 100vh; /* высота экрана */
        }
    </style>
@endsection

@section('title', 'Задача №1')

@section('content')
    <div class="container full-height d-flex flex-column align-items-center justify-content-start mt-5">
        <div class="row">
            <div class="col-12" style="min-width: 800px">
                <h2 class="mb-4 text-center">Задача 1</h2>
                <h3 class="mb-4">Документы</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>№ документа</th>
                        <th>документ</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $key => $document)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $document }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3 class="mb-4">Запросы</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>№ запроса</th>
                        <th>Запрос</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($queries as $key => $query)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $query }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3 class="mb-4">Релевантность</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>№ запроса</th>
                        <th>
                            Cписок номеров релевантных документов в порядке убывания релевантности. <br>
                            В скобках приведено значение релевантности документа запросу
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($queryRelevances as $key => $queryRelevance)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $queryRelevance }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection