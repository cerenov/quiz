@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <div class="container px-4">
            <h1>ВАШ РЕЗУЛЬТАТ</h1>
            <h2>{{$result}} %</h2>
            <br>
            <a class="btn btn-primary mb-3" href="{{route('home')}}" role="button">Вернуться к списку тестов</a>
        </div>
    </div>
@endsection
