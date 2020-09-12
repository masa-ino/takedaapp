@extends('layout')

@section('content')

<div class="uk-container uk-container-xsmall">
  <div class="uk-margin uk-margin-large">
    <h1 class="uk-heading-small uk-text-center uk-text-bold">予約済み特訓一覧</h1>
  </div>
  <div class="uk-margin">
    <?php if ($result === 'success') : ?>
      <div class="success uk-text-center">
        <p>特訓が解除されました</p>
      </div>
    <?php elseif ($result === 'error') : ?>
      <div class="failure uk-text-center">
        <p>特訓の解除が失敗しました</p>
      </div>
    <?php endif ?>
  </div>
  <div class="uk-margin">
    @foreach ($users as $user)
    @foreach ($user->subjects as $subject)
    @foreach ($subject->times as $time)
    <form id="modal_form{{$time->id}}" method="POST" action="{{ route('admin.training_reserved_result', ['time' => $time->id]) }}">
      @csrf
      <div class="uk-card uk-card-default uk-card-body uk-margin">
        <div class=" uk-margin one_class">
          <ul>
            <li class="center">{{$time->time_name}}</li>
          </ul>
          <p class="uk-margin uk-text-center uk-margin-small">{{$subject->name}}</p>
          <p class="uk-margin uk-margin-small uk-text-center">{{$user->name}}</p>
          <div class="uk-text-center">
            <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #modal-example{{$time->id}}">予約を解除</button>
          </div>
        </div>
      </div>
      <div id="modal-example{{$time->id}}" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-text-center">
          <h2 class="uk-modal-title uk-margin">確認画面</h2>
          <div class=" uk-margin one_class modal_one_class">
            <ul>
              <li class="left">{{$time->time_name}}</li>
            </ul>
            <p class="uk-margin uk-text-center uk-margin-small">{{$subject->name}}</p>
            <p class="uk-margin uk-margin-small uk-text-center">{{$user->name}}</p>
          </div>
          <p>
            <button class="uk-button uk-button-secondary uk-modal-close" type="button">キャンセル</button>
            <button class="uk-button uk-button-default" type="submit" form="modal_form{{$time->id}}">解除する</button>
          </p>
        </div>
      </div>
    </form>
    @endforeach
    @endforeach
    @endforeach
  </div>
</div>

@endsection