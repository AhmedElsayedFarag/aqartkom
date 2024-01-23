@extends('bot_question::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('bot_question.name') !!}
    </p>
@endsection
