@extends('layout.base')
@section('content')
    <div class="bigscreen">
        <div class="login">
            <div class="form">
                <h3>Войти в кабинет</h3>
                @error('login')
                <div>{{$message}}</div>
                @enderror
                @error('password')
                <div>{{$message}}</div>
                @enderror

                <form action="{{route('login')}}" method="post">
                    @csrf

                    <div class="control">
                        <input type="text"
                               name="phone"
                               value="{{old('phone')}}"
                        >
                        <label>Телефон</label>
                    </div>

                    <div class="control">
                        <input type="password" name="password">
                        <label>Пароль</label>
                    </div>

                    <div class="input-composer embedded">
                        <button type="submit" class="btn full primary">Войти</button>
                        <a href="{{route('register')}}" class="btn tertiary dark">Регистрация</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
