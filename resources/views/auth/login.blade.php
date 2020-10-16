@extends('layout')

@section('content')

<div class="uk-container uk-container-xsmall">
    <div class="uk-margin">
        <h1 class="uk-heading-small uk-text-center uk-text-bold">ログインフォーム</h1>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $message)
        <p>{{ $message }}</p>
        @endforeach
    </div>
    @endif
    <div class="uk-margin">
        <div class="uk-card uk-card-default uk-card-body">
            <h3 class="uk-card-title uk-text-center uk-margin">講師としてログイン</h3>
            <form action="{{ route('login') }}" method="POST">@csrf
                <div class="uk-margin uk-text-center">
                    <div class="uk-inline">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                        <input class="uk-input" type="text" id="name" name="name" placeholder="名前" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="uk-margin uk-text-center">
                    <div class="uk-inline">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                        <input class="uk-input" type="password" placeholder="パスワード" id="password" name="password">
                    </div>
                </div>

                <div class="uk-text-center uk-margin">
                    <button class="uk-button uk-button-default" type="submit">ログイン</button>
                </div>

            </form>
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-card uk-card-default uk-card-body">
            <h3 class="uk-card-title uk-text-center uk-margin">管理者としてログイン</h3>
            <form>
                <div class="uk-margin uk-text-center">
                    <div class="uk-inline">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
                        <input class="uk-input" type="text" placeholder="名前">
                    </div>
                </div>

                <div class="uk-margin uk-text-center">
                    <div class="uk-inline">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                        <input class="uk-input" type="password" placeholder="パスワード">
                    </div>
                </div>

                <div class="uk-text-center uk-margin">
                    <button class="uk-button uk-button-default" type="submit">ログイン</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection