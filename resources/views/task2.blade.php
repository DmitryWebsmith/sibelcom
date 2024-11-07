@extends('layouts.app')

@section('css')
    <style>
        .full-height {
            height: 100vh; /* высота экрана */
        }
    </style>
@endsection

@section('title', 'Задача №2')

@section('content')
    <div class="container full-height d-flex flex-column align-items-center justify-content-start mt-5">
        <div class="row">
            <div class="col-12" style="min-width: 800px">
                <h2 class="mb-4 text-center">Задача 2</h2>
                <h3 class="mb-4">Количество детали {{ $partNumber }} </h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Адрес</th>
                        <th>Количество детали</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($partAmountsList as $part)
                            <tr>
                                <td>{{ $part['url'] }}</td>
                                <td>{{ $part['partAmount'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

    </script>
@endsection