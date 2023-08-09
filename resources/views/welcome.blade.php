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
                            <input id="location" value="{{ $location }}" hidden>
                            <button type="button" id="cityTrue" class="btn btn-success">Да</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Нет</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::check() && Auth::user()->hasVerifiedEmail())
            <div class="d-flex justify-content-end w-75 mb-3">
                <a class="btn btn-secondary" id="sendFeedback" href="{{ route('gotoFeedbackCreate') }}" hidden>
                    Написать отзыв</a>
            </div>
        @endif

        <div class="w-75" id="feedbacks" hidden>
        </div>


    </div>

    <script>
        $(window).ready(function () {
            let cookie = document.cookie.split(';');
            cookie = cookie[0].split('=');
            if (cookie[0] !== 'idCity') {
                $('#yourCityQuest').modal('toggle');
            } else {
                getFeedbacks(cookie[1]);
            }

        });

        $('#cityTrue').on('click', function () {
            $('#yourCityQuest').modal('toggle');
            $('.select2').hide();
            document.getElementById('sendFeedback').hidden = false;

            let city = $('#location').val();
            console.log(city);

            $.ajax({
                url: '/feedback/addNewCity',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'city': city
                },
                success: function () {
                    location.reload();
                }
            })
        });

        $('select').change(function () {
            document.getElementById('sendFeedback').hidden = false;

            getFeedbacks($(this).val());
        });

        function getFeedbacks(cityId) {
            $.ajax({
                url: 'getCityFeedbacks',
                type: 'get',
                data: {
                    'id': cityId
                },
                success: function (data) {
                    $('.select2').hide();
                    $('#welcome').html(data['feedbacks'][0].city.name);
                    document.getElementById('feedbacks').hidden = false;
                    console.log(data['feedbacks'][0].author.fio);
                    for (let i = 0; i < data['feedbacks'].length; i++) {
                        $('#feedbacks').append(
                            `<div class="card mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <p class="fw-bold m-0">` + data['feedbacks'][i].author.fio + `</p>
                                        <p class="m-0" id="rating">Оценка: ` + data['feedbacks'][i].rating + `</p>
                                    </div>
                                    <div class="text-center">
                                        <img src="{{ asset('public/storage/feedback_images') }}` + '/' + data['feedbacks'][i].img + `" alt="image" width="50%" class="img-thumbnail">
                                        <h5 class="m-0">` + data['feedbacks'][i].title + `</h5>
                                        <p class="m-0 text-start">` + data['feedbacks'][i].text + `</p>
                                    </div>
                                </div>
                            </div>`
                        );
                    }
                }
            })

        }
    </script>
@endsection
