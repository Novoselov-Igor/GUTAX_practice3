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

                            <div class="row mb-3">
                                <label class="col-md-4 form-check text-md-end">Оценка</label>

                                <div class="col-md-6 d-flex">
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="1" type="radio" name="rating"
                                               id="flexRadioDefault1" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            1
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="2" type="radio" name="rating"
                                               id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            2
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="3" type="radio" name="rating"
                                               id="flexRadioDefault3">
                                        <label class="form-check-label" for="flexRadioDefault3">
                                            3
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="4" type="radio" name="rating"
                                               id="flexRadioDefault4">
                                        <label class="form-check-label" for="flexRadioDefault4">
                                            4
                                        </label>
                                    </div>
                                    <div class="form-check mx-3">
                                        <input class="form-check-input" value="5" type="radio" name="rating"
                                               id="flexRadioDefault5">
                                        <label class="form-check-label" for="flexRadioDefault5">
                                            5
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">Фото</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" accept="image/*" class="form-control" name="image" required>
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end" style="margin-right: 5%">Город</label>

                                <div class="col-md-6">
                                    <select multiple="multiple" id="city" name="cities[]" class="searchable w-75"
                                            aria-label="Default select example">
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex mb-3 justify-content-center">
                                <button id="cityNotFound" class="btn" type="button">Не нашли нужный город?</button>
                            </div>
                            <div id="addCity" class="row mb-3" hidden>
                                <label for="newCity" class="col-md-4 col-form-label text-md-end">Добавить город</label>
                                <div class="col-md-6 d-flex">
                                    <input id="newCity" type="text" class="form-control" name="newCity">
                                    <button id="btnAddCity" class="btn btn-danger mx-3" type="button">Добавить</button>
                                </div>
                            </div>

                            <div id="showFoundCity" class="row mb-3" hidden>
                                <div class="col-md-6 d-flex m-auto">
                                    <p class="my-0 mx-1">
                                        <nobr>Вы имели в виду этот город:</nobr>
                                    </p>
                                    <p class="m-0" id="foundCity"></p>
                                    <button id="rightCity" class="btn btn-danger mx-3" type="button">Да</button>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <input type="text" value="{{ Auth::user()->id }}" name="id_author" hidden>
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

    <script>
        $('#cityNotFound').on('click', function () {
            document.getElementById('addCity').hidden = false;
        })

        $('#btnAddCity').on('click', function () {
            let city = $('#newCity').val();

            $.ajax({
                url: '/feedback/checkCity',
                type: 'get',
                data: {
                    'city': city
                },
                success: function (data) {
                    console.log(data['location']);

                    document.getElementById('showFoundCity').hidden = false;

                    $('#foundCity').html(data['location'][0].name);
                }
            })
        })

        $('#rightCity').on('click', function () {
            let city = $('#foundCity').html();
            $.ajax({
                url: '/feedback/addNewCity',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'city': city
                },
                success: function (response) {
                    location.reload();
                    alert(response['success']);
                }
            })
        })
    </script>
@endsection
