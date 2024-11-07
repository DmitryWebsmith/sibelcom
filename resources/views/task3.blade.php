@extends('layouts.app')

@section('css')
    <style>
        .full-height {
            height: 100vh; /* высота экрана */
        }
    </style>
@endsection

@section('title', 'Задача №3')

@section('content')
    <div class="container full-height d-flex flex-column align-items-center justify-content-start mt-5">
        <div class="row">
            <div class="col-12" style="min-width: 800px">
                <h2 class="mb-4 text-center">Задача 3</h2>
                {!! $description !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>

</script>
@endsection