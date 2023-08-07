@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Регистрация</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="fio" class="col-md-4 col-form-label text-md-end">ФИО</label>

                                <div class="col-md-6">
                                    <input id="fio" type="text"
                                           class="form-control @error('fio') is-invalid @enderror" name="fio"
                                           value="{{ old('fio') }}" required autocomplete="name" autofocus>

                                    @error('fio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">e-mail адрес</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone"
                                       class="col-md-4 col-form-label text-md-end">Номер телефона</label>

                                <div class="col-md-6">
                                    <input id="phone" type="tel"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ old('phone') }}" required autocomplete="email"
                                           pattern="^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">Пароль</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-end">Подтвердить пароль</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mb-3">
                                <div class="captcha">
                                    <span class="mx-3">{!! captcha_img('flat') !!}</span>
                                    <button type="button" class="btn btn-danger reload" id="reload">
                                        &#x21bb;
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="captcha"
                                       class="col-md-4 col-form-label text-md-end">Повторите капчу</label>

                                <div class="col-md-6">
                                    <input id="captcha" type="text"
                                           class="form-control @error('captcha') is-invalid @enderror" name="captcha"
                                           required>
                                </div>
                            </div>
                            @error('captcha')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-danger">
                                        Зарегистрироваться
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
        $('#reload').click(function () {
            $.ajax({
                type: 'get',
                url: 'reloadCaptcha',
                success: function (data) {
                    $('.captcha span').html(data.captcha);
                }
            });
        });
    </script>
@endsection
