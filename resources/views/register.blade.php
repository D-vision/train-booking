@extends('layout.base')
@section('content')
    <div class="bigscreen">
        <div class="login">
            <div class="form">
                <h3>Регистрация</h3>

                <form action="{{route('register')}}" method="post">
                    @csrf

                    <div class="control">
                        <input type="text"
                               name="firstName"
                               value="{{old('firstName')}}"
                        >
                        <label>Имя</label>
                    </div>
                    @error('firstName')<div class="text-danger">{{$message}}</div>@enderror

                    <div class="control">
                        <input type="text"
                               name="lastName"
                               value="{{old('lastName')}}"
                        >
                        <label>Фамилия</label>
                    </div>
                    @error('firstName')<div class="text-danger">{{$message}}</div>@enderror


                    <div class="control">
                        <input type="text"
                               name="phone"
                               value="{{old('phone')}}"
                        >
                        <label>Телефон</label>
                    </div>
                    @error('phone')<div class="text-danger">{{$message}}</div>@enderror


                    <div class="control">
                        <input type="password" name="password">
                        <label>Пароль</label>
                    </div>
                    @error('password')<div class="text-danger">{{$message}}</div>@enderror


                    <div class="control">
                        <input type="password" name="password_confirmation">
                        <label>Повторить пароль</label>
                    </div>

                    <div class="input-composer embedded">
                        <button type="submit" class="btn full primary">Зарегистрировать</button>
                        <a href="{{route('login')}}" class="btn tertiary dark">Войти в аккаунт</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
