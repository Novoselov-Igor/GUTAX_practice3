@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создание отзыва</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('sendFeedback') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Название</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ $oldFeedback['title'] }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="text" class="col-md-4 col-form-label text-md-end">Отзыв</label>

                                <div class="col-md-6">
                                    <textarea id="text" name="text"
                                              class="form-control @error('text') is-invalid @enderror"
                                              required>{{ $oldFeedback['text'] }}</textarea>

                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 form-check text-md-end">Оценка</label>

                                <div class="col-md-6 d-flex">
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="1" type="radio" name="rating"
                                               id="1" checked>
                                        <label class="form-check-label" for="1">
                                            1
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="2" type="radio" name="rating"
                                               id="2">
                                        <label class="form-check-label" for="2">
                                            2
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="3" type="radio" name="rating"
                                               id="3">
                                        <label class="form-check-label" for="3">
                                            3
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="4" type="radio" name="rating"
                                               id="4">
                                        <label class="form-check-label" for="4">
                                            4
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="5" type="radio" name="rating"
                                               id="5">
                                        <label class="form-check-label" for="5">
                                            5
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">Фото</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" accept="image/*" class="form-control" name="image"
                                           required>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <input type="text" value="{{ Auth::user()->id }}" name="id_author" hidden>
                                    <input type="text" value="change" name="case" hidden>
                                    <input type="text" value="{{ $oldFeedback['id'] }}" name="id" hidden>
                                    <input type="text" value="{{ $oldFeedback['city'] }}" name="cityId" hidden>
                                    <button type="submit" class="btn btn-danger">
                                        Изменить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(window).ready(function () {
            $('#{{ $oldFeedback['rating'] }}').prop('checked', true);
        })
    </script>
@endsection
