@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center p-5">
        @foreach($feedbacks as $feedback)
            <div class="card mb-3">
                <div class="card-header">
                    <h6>Город: {{ $feedback->city->name }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div>
                            <p class="fw-bold m-0">{{ $feedback->author->fio }}</p>
                            <p class="m-0" id="rating">Оценка: {{ $feedback->rating }}</p>
                        </div>
                        @if($feedback->id_author === Auth::user()->id)
                            <form method="get" action="{{ route('gotoFeedbackChange') }}">
                                <input name="title" value="{{ $feedback->title }}" hidden>
                                <input name="text" value="{{ $feedback->text }}" hidden>
                                <input name="rating" value="{{ $feedback->rating }}" hidden>
                                <input name="city" value="{{ $feedback->id_city }}" hidden>
                                <input name="id" value="{{ $feedback->id }}" hidden>
                                <button class="btn btn-danger">Изменить</button>
                            </form>
                        @endif
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('public/storage/feedback_images') }}/{{ $feedback->img }}" alt="image"
                             width="25%" class="img-thumbnail">
                        <h5 class="m-0">{{ $feedback->title }}</h5>
                        <p class="m-0 text-start">{{ $feedback->text }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
