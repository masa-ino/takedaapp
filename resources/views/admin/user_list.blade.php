@extends('layout')

@section('content')
<div class="uk-container uk-container-xsmall">
  <div class="uk-margin uk-margin-large">
    <h1 class="uk-heading-small uk-text-center uk-text-bold">講師一覧</h1>
  </div>

  <div class="uk-margin">
    <?php if ($result === 'success') : ?>
      <div class="success uk-text-center">
        <p>講師が削除されました</p>
      </div>
    <?php elseif ($result === 'error') : ?>
      <div class="failure uk-text-center">
        <p>講師の削除が失敗しました</p>
      </div>
    <?php elseif ($result === 'success_edit') : ?>
      <div class="success uk-text-center">
        <p>講師が編集されました</p>
      </div>
    <?php elseif ($result === 'error_edit') : ?>
      <div class="failure uk-text-center">
        <p>講師の編集が失敗しました</p>
      </div>
    <?php endif ?>
  </div>
  <div class="uk-margin">
    @foreach($users as $user)
    <div class="uk-card uk-card-default uk-card-body uk-margin">
      <div class=" uk-margin one_class">
        <p class="uk-margin uk-text-center uk-margin-small">{{$user->name}}</p>
        <ul class="teacher_subject uk-margin">
          @foreach($user->subjects as $index => $subject)
          <li>{{$subject['name']}}</li>
          @endforeach
        </ul>
        <div class="uk-text-center">
          <a href="{{ route('admin.user_edit', ['user' => $user->id]) }}" class="uk-button uk-button-secondary" type="button">編集</a>
          <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #modal-example{{$user->id}}">削除</button>
        </div>
      </div>
    </div>
    <div id="modal-example{{$user->id}}" uk-modal>
      <div class="uk-modal-dialog uk-modal-body uk-text-center">
        <h2 class="uk-modal-title uk-margin">確認画面</h2>
        <ul class="check_list">
          <li class=" uk-margin modal_inner_check_list">
            <ul>
              <li class="check_left">名前</li>
              <li class="check_center">:</li>
              <li class="check_right">{{$user->name}}</li>
            </ul>
          </li>
          <li class=" uk-margin modal_inner_check_list">
            <ul class="teacher_subject_wrap">
              <li class="check_left">科目</li>
              <li class="check_center">:</li>
              @foreach($user->subjects as $index => $subject)
              <li class="check_right">{{$subject['name']}}</li>
              @endforeach
            </ul>
          </li>
        </ul>
        <p>
          <button class="uk-button uk-button-secondary uk-modal-close" type="button">キャンセル</button>
          <form action="{{ route('admin.user_delete', ['user' => $user->id]) }}" method="POST">@csrf
            <button class="uk-button uk-button-default" type="submit">削除する</button>
          </form>
        </p>
      </div>
    </div>
    @endforeach
  </div>
</div>

@endsection