@extends('layouts.app')
@section('content')
    <div class="container align-content-center bg-warning">
        <form action="{{route('quiz')}}" method="POST">
            @csrf
            <div class="container text-center">
                <h1>Тема: {{$quiz->getTitle()}}</h1>
                <h2>вопрос: {{$question->getText()}}</h2>
            </div>
            @php
                $index = 1;
            @endphp

            @foreach($question->getChoices() as $choice)
                <div class="form-check text-left align-content-center">
                    @if(array_key_exists($choice->getUUID(), $answers))
                        <input class="form-check-input" type="checkbox" value="{{$choice->getUUID()}}"
                               id={{$choice->getUUID()}}
                               name="choice[]" checked>
                    @else
                        <input class="form-check-input" type="checkbox" value="{{$choice->getUUID()}}"
                               id={{$choice->getUUID()}}
                               name="choice[]">
                    @endif
                    <label class="form-check-label" for="flexCheckDefault">
                        {{$choice->getText()}}
                    </label>
                </div>
            @endforeach
            <input class="form-check-input" type="text" value="{{$quiz->getUUID()}}" id="flexCheckDefault"
                   name="quiz_id"
                   hidden>
            <input class="form-check-input" type="text" value="{{$question->getUUID()}}" id="flexCheckDefault"
                   name="question_id" hidden>
            <br><br>
            <div class="container text-center align-content-center">
                <div class="row align-content-center">
                    <div class="align-content-center">
                        <button type="submit" class="btn btn-outline-primary mb-3" value="prev_question" name="button">предыдущий вопрос</button>
                        <button type="submit" class="btn btn-outline-primary mb-3" value="next_question" name="button">следующий вопрос</button>
                        <button type="submit" class="btn btn-outline-success mb-3" value="end_quiz" name="button">завершить тест</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
