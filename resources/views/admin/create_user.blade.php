@extends('layout')

@section('content')

<div class="uk-container uk-container-xsmall">
  <div class="uk-margin">
    <h1 class="uk-heading-small uk-text-center uk-text-bold">講師登録</h1>
  </div>

  <div class="uk-margin">
    <?php if ($result === 'success') : ?>
      <div class="success uk-text-center">
        <p>講師が登録されました</p>
      </div>
    <?php elseif ($result === 'error') : ?>
      <div class="failure uk-text-center">
        <p>その名前は既に使われています</p>
      </div>
    <?php endif ?>
  </div>
  <div id="create_user" class="uk-margin">
    <form id="modal_form" method="POST" action="{{ route('admin.create_user') }}">
      @csrf
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title uk-text-center uk-margin">新規講師を登録</h3>
        <div class="uk-margin uk-text-center">
          <div class="uk-inline">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: user"></span>
            <input class="uk-input" type="text" id="name" name="name" placeholder="名前" value="{{ old('name') }}" v-model="form.name">
          </div>

          <small v-bind:class="{'is-hide':validation.name}" class="check_message" v-if="!form.name">@{{ errorMessage.name }}</small>
        </div>

        <div class="uk-margin uk-text-center">
          <div class="uk-inline">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input class="uk-input" type="password" placeholder="パスワード" id="password" name="password" v-model="form.password">
          </div>
          <small v-bind:class="{'is-hide':validation.password}" class="check_message" v-if="!form.password.match(/^[A-Za-z0-9]{8,}$/)">@{{ errorMessage.password }}</small>
        </div>
        <div class="uk-margin uk-grid-small uk-child-width-1-6@s uk-child-width-1-3 uk-grid">
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="現代文"> 現代文</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="古文"> 古文</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="漢文"> 漢文</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="英語"> 英語</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="数学IA"> 数学IA</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="数学ⅡB"> 数学IIB</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="数学Ⅲ"> 数学Ⅲ</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="化学"> 化学</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="物理"> 物理</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="生物"> 生物</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="地学"> 地学</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="日本史"> 日本史</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="世界史"> 世界史</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="地理"> 地理</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="現社"> 現社</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="倫理"> 倫理</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="政経"> 政経</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="form.subjects" value="倫政"> 倫政</label>
        </div>
        <small v-bind:class="{'is-hide':validation.subjects}" class="check_message" v-if="form.subjects.length == 0">@{{ errorMessage.subjects }}</small>
      </div>
      <div class="uk-text-center uk-margin">
        <button class="uk-button uk-button-default uk-margin-small-right" v-bind:disabled="!isValid" type="button" uk-toggle="target: #modal-example" v-on:click="checkFrom">登録する</button>
      </div>
      <div id="modal-example" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-text-center">
          <h2 class="uk-modal-title uk-margin">確認画面</h2>
          <ul class="check_list">
            <li class=" uk-margin modal_inner_check_list">
              <ul>
                <li class="check_left">名前</li>
                <li class="check_center">:</li>
                <li class="check_right">@{{check.name}}</li>
              </ul>
            </li>
            <li class=" uk-margin modal_inner_check_list">
              <ul>
                <li class="check_left">パスワード</li>
                <li class="check_center">:</li>
                <li class="check_right">@{{check.password}}</li>
              </ul>
            </li>
            <li class=" uk-margin modal_inner_check_list">
              <ul class="teacher_subject_wrap">
                <li class="check_left">科目</li>
                <li class="check_center">:</li>
                <li class="check_right" v-for ="subject in check.subjects">@{{subject}}</li>
              </ul>
            </li>
          </ul>
          <p>
            <button class="uk-button uk-button-secondary uk-modal-close" type="button">キャンセル</button>
            <button class="uk-button uk-button-default" type="submit" form="modal_form">登録する</button>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  new Vue({
    el: "#create_user",
    data: function() {
      return {
        form: {
          name: '',
          password: '',
          subjects: [],
        },
        errorMessage: {
          name: '名前を入力してください',
          password: 'パスワードは英数字8桁以上で設定してください',
          subjects: '科目を一つ以上選択してください'
        },
        check: {
          name: '',
          password: '',
          subjects: [],
        }
        //ここまでを追加
      }
    }, //ここにカンマを追加

    computed: {
      validation() {
        const form = this.form
        return {
          name: !!form.name,
          password: (() => {
            if (!!form.password) {
              if (!form.password.match(/^[A-Za-z0-9]{8,}$/)) {
                return false
              }
              return true
            } else {
              return false
            }
          })(),
          subjects: !form.subjects.length == 0
        }
      },
      isValid() {
        var validation = this.validation
        return Object.keys(validation).every(function(key) {
          return validation[key]
        })
      }
    },
    methods: {
      checkFrom: function(event) {
        var check = this.check
        check.name = this.form.name
        check.password = this.form.password
        check.subjects = this.form.subjects
      }
    },


  })
</script>
@endsection