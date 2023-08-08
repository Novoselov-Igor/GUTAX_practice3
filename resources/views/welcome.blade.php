@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center p-5">
        <div>
            <h1 id="welcome" class="mb-4">Добро пожаловать на сайт!!!</h1>
            <select id="locationList" class="searchable form-control" aria-label="Default select example">
                <option disabled selected>Выберите город</option>
                @foreach($cities as $city)
                    @if(!$city->feedbacks->isEmpty())
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endif
                @endforeach
            </select>

            <div class="modal fade" id="yourCityQuest" tabindex="-1" aria-labelledby="yourCityQuest" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            Ваш город {{ $location }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="cityTrue" class="btn btn-success">Да</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Нет</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-75" id="feedbacks" hidden>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <p class="fw-bold m-0" id="author"></p>
                        <p class="m-0" id="rating"></p>
                    </div>
                    <div class="text-center">
                        <div id="imageHolder"></div>
                        <h5 class="m-0" id="title"></h5>
                        <p class="m-0 text-start" id="text"></p>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::check() && Auth::user()->hasVerifiedEmail())
            <a class="page-link" href="{{ route('gotoFeedbackCreate') }}">Написать отзыв</a>
        @endif


    </div>

    <script>
        $(window).ready(function () {
            $('#yourCityQuest').modal('toggle');
        });

        $('#cityTrue').on('click', function () {
            $('#yourCityQuest').modal('toggle');
            $('.select2').hide();
        });

        $('select').change(function () {
            $.ajax({
                url: 'getCityFeedbacks',
                type: 'get',
                data: {
                    'id': $(this).val()
                },
                success: function (data) {
                    $('.select2').hide();
                    $('#welcome').html(data['feedbacks'][0].city.name);
                    document.getElementById('feedbacks').hidden = false;
                    console.log(data['feedbacks'][0].author.fio);
                    for (let i = 0; i < data['feedbacks'].length; i++) {
                        $('#imageHolder').append(
                            `<img src="public/feedback_images/` + data['feedbacks'][i].img + `" alt="image" width="50%" class="img-thumbnail">`
                        );
                        $('#author').html(data['feedbacks'][i].author.fio);
                        $('#rating').html('Оценка: ' + data['feedbacks'][i].rating);
                        $('#title').html(data['feedbacks'][i].title);
                        $('#text').html(data['feedbacks'][i].text);
                    }
                }
            })
        });
    </script>
@endsection
