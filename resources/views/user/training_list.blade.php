@extends('layout')

@section('content')

<div class="uk-container uk-container-xsmall">
  <div class="uk-margin uk-margin-large">
    <h1 class="uk-heading-small uk-text-center uk-text-bold">特訓リスト</h1>
  </div>

  <div class="uk-margin">
    <?php if ($result === 'success') : ?>
      <div class="success uk-text-center">
        <p>特訓が編集されました</p>
      </div>
    <?php elseif ($result === 'error') : ?>
      <div class="failure uk-text-center">
        <p>特訓の編集が失敗しました</p>
      </div>
    <?php endif ?>
  </div>


  <div class="uk-margin uk-card uk-card-default uk-card-body">
    <ul class="check_list">
      @foreach($time_list as $time)
      <li class=" uk-margin one_class">
        <ul class="create_class">
          <li class="center">{{$time}}</li>
        </ul>
      </li>
      @endforeach
    </ul>
  </div>
  <p class="uk-text-center">
    <a href="{{ route('user.training_edit') }}" class="uk-button uk-button-default">編集する</a>
  </p>

  <h2 class="uk-heading-small uk-text-center uk-text-bold">予約済み特訓</h2>
  <div class="uk-margin">
    @if($reserve_list !== null)
    @foreach ($reserve_list as $time => $subjects)
    <div class="uk-card uk-card-default uk-card-body uk-margin">
      <div class=" uk-margin one_class">
        <ul class="create_class">
          <li class="center">{{$time}}</li>
        </ul>
      </div>
      <p class="uk-margin uk-text-center">
        @foreach ($subjects as $subject)
        {{$subject}}
        @endforeach
      </p>
    </div>
    @endforeach
    @endif
  </div>
</div>

@endsection