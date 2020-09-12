@extends('layout')

@section('content')

<div class="uk-container uk-container-xsmall">
  <div class="uk-margin uk-margin-large">
    <h1 class="uk-heading-small uk-text-center uk-text-bold">{{$user_name}}の管理画面</h1>
  </div>
  <div class="uk-margin">
    <div class="uk-margin uk-margin-large">
      <a href="{{ route('user.training_list') }}" class="uk-button uk-button-default uk-width-1-1 big_button uk-text-bold">特訓リスト</a>
    </div>
  </div>

  @endsection