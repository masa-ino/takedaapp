@extends('layout')

@section('content')

<div class="uk-container uk-container-xsmall">
  <div class="uk-margin uk-margin-large">
    <h1 class="uk-heading-small uk-text-center uk-text-bold">特訓編集</h1>
  </div>

  <div class="uk-margin" id="training_edit">
    <form id="modal_form" method="POST" action="{{ route('user.training_edit') }}">
      @csrf
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title uk-text-center uk-margin uk-text-bold">日程</h3>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-small uk-table-divider uk-table-striped">
            <thead>
              <tr>
                <th></th>
                <th>1限</th>
                <th>2限</th>
                <th>3限</th>
                <th>4限</th>
                <th>5限</th>
                <th>6限</th>
                <th>7限</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="date">月</td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="月1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="月2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="月3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="月4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="月5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="月6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="月7"></td>
              </tr>
              <tr>
                <td class="date">火</td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="火1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="火2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="火3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="火4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="火5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="火6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="火7"></td>
              </tr>
              <tr>
                <td class="date">水</td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="水1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="水2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="水3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="水4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="水5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="水6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="水7"></td>
              </tr>
              <tr>
                <td class="date">木</td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="木1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="木2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="木3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="木4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="木5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="木6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="木7"></td>
              </tr>
              <tr>
                <td class="date">金</td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="金1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="金2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="金3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="金4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="金5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="金6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="金7"></td>
              </tr>
              <tr>
                <td class="date">土</td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="土1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="土2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="土3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="土4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="土5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="土6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="form.times" type="checkbox" value="土7"></td>
              </tr>
            </tbody>
          </table>
          <small v-bind:class="{'is-hide':validation.times}" class="check_message" v-if="form.times.length == 0">@{{ errorMessage.times }}</small>
        </div>

        <div id="modal-example" uk-modal>
          <div class="uk-modal-dialog uk-modal-body uk-text-center">
            <h2 class="uk-modal-title uk-margin">確認画面</h2>
            <ul class="check_list">
              <li class=" uk-margin modal_inner_check_list" v-for="time in check.times">@{{time}}</li>
            </ul>
            <p>
              <button class="uk-button uk-button-secondary uk-modal-close" type="button">キャンセル</button>
              <button class="uk-button uk-button-default" type="submit" form="modal_form">登録する</button>
            </p>
          </div>
        </div>
      </div>
      <div class="uk-text-center uk-margin">
        <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #modal-example" v-on:click="checkFrom" v-bind:disabled="!isValid">登録する</button>
      </div>
    </form>
  </div>
</div>

<script>
  new Vue({
    el: "#training_edit",
    data: function() {
      return {
        form: {
          times: [],
        },
        errorMessage: {
          times: '時間を一つ以上選択してください'
        },
        check: {
          times: [],
        }
        //ここまでを追加
      }
    }, //ここにカンマを追加

    computed: {
      validation() {
        const form = this.form
        return {
          times: !form.times.length == 0
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
        check.times = this.form.times
      }
    },


  })
</script>
@endsection