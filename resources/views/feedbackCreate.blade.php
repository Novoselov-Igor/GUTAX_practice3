@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создание отзыва</div>

                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Название</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                              required></textarea>

                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <label class="col-md-4 form-check text-md-end">Оценка</label>

                                <div class="form-check mx-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                           id="flexRadioDefault1" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        1
                                    </label>
                                </div>
                                <div class="form-check mx-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                           id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        2
                                    </label>
                                </div>
                                <div class="form-check mx-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                           id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        3
                                    </label>
                                </div>
                                <div class="form-check mx-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                           id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        4
                                    </label>
                                </div>
                                <div class="form-check mx-3">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                           id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        5
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">Фото</label>

                                <div class="col-md-6">
                                    <input id="image" accept="image/*" type="file"
                                           class="form-control @error('image') is-invalid @enderror" name="image"
                                           value="{{ old('image') }}" required autofocus>

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end">Город</label>


                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-danger">
                                        Создать
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
