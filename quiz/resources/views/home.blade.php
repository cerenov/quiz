@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <div class="container px-4">
            <h1>Список тестов</h1>
            <div class="row gx-5">
                @foreach($list_quizzes as $quiz)
                    <div class="col">
                        <div class="p-3 border bg-light">
                            <p>
                                Тема: {{$quiz->getTitle()}}
                            </p>
                            <form action="{{route('quiz')}}" method="POST">
                                @csrf
                                <input class="form-check-input" type="text" value="{{$quiz->getUUID()}}"
                                       id="flexCheckDefault"
                                       name="quiz_id" hidden>
                                <button type="submit" class="btn btn-primary mb-3">начать тест</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
