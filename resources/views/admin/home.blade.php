@extends('layout')

@section('content')

<div class="uk-container uk-container-xsmall">
    <div class="uk-margin uk-margin-large">
      <h1 class="uk-heading-small uk-text-center uk-text-bold">管理者の管理画面</h1>
    </div>
    <div class="uk-margin">
      <a href="{{ route('admin.training_search') }}" class="uk-button uk-button-default uk-width-1-1 big_button uk-text-bold">特訓検索</a>
    <div class="uk-margin uk-margin-large">
      <a href="{{ route('admin.training_reserved') }}" class="uk-button uk-button-default uk-width-1-1 big_button uk-text-bold">予約済み特訓一覧</a>
    </div>
    <div class="uk-margin uk-margin-large">
      <a href="{{ route('admin.create_user') }}" class="uk-button uk-button-default uk-width-1-1 big_button uk-text-bold">講師登録</a>
    </div>
    <div class="uk-margin uk-margin-large">
      <a href="{{ route('admin.user_list') }}" class="uk-button uk-button-default uk-width-1-1 big_button uk-text-bold">講師一覧</a>
    </div>
  </div>
  </div>

  @endsection