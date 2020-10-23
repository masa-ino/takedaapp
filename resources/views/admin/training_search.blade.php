@extends('layout')

@section('content')
<div class="uk-container uk-container-xsmall">
  <div class="uk-margin uk-margin-large">
    <h1 class="uk-heading-small uk-text-center uk-text-bold">特訓検索</h1>
  </div>

  <div class="uk-margin">
    <?php if ($result === 'success') : ?>
      <div class="success uk-text-center">
        <p>特訓が予約されました</p>
      </div>
    <?php elseif ($result === 'error') : ?>
      <div class="failure uk-text-center">
        <p>特訓の予約が失敗しました</p>
      </div>
    <?php endif ?>
  </div>

  <div class="uk-margin" id="training_search">
    <form id="modal_form" method="POST" action="{{ route('admin.training_search') }}">@csrf
      <div class="uk-card uk-card-default uk-card-body uk-margin">
        <h3 class="uk-card-title uk-text-center uk-margin uk-text-bold">科目</h3>
        <p class="uk-text-center uk-text-small uk-margin-small uk-text-danger">
          「現代文」と「古文」で検索した場合、現代文と古文の両方を登録している講師が対象となります
        </p>
        <div class="uk-margin uk-grid-small uk-child-width-1-6@s uk-child-width-1-3 uk-grid">
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="現代文"> 現代文</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="古文"> 古文</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="漢文"> 漢文</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="英語"> 英語</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="数学IA"> 数学IA</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="数学ⅡB"> 数学IIB</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="数学Ⅲ"> 数学Ⅲ</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="化学"> 化学</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="物理"> 物理</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="生物"> 生物</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="地学"> 地学</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="日本史"> 日本史</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="世界史"> 世界史</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="地理"> 地理</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="現社"> 現社</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="倫理"> 倫理</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="政経"> 政経</label>
          <label><input class="uk-checkbox" type="checkbox" name="subjects[]" v-model="checkBox.subjects" value="倫政"> 倫政</label>
        </div>
      </div>
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title uk-text-center uk-margin uk-text-bold">日程</h3>
        <div class="uk-overflow-auto">
        <p class="uk-text-center uk-text-small uk-margin-small uk-text-danger">
          「月1限」と「火1限」で検索した場合、月1限と火1限のどちらかを登録している講師が対象となります。
        </p>
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
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="月1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="月2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="月3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="月4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="月5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="月6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="月7"></td>
              </tr>
              <tr>
                <td class="date">火</td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="火1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="火2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="火3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="火4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="火5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="火6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="火7"></td>
              </tr>
              <tr>
                <td class="date">水</td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="水1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="水2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="水3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="水4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="水5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="水6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="水7"></td>
              </tr>
              <tr>
                <td class="date">木</td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="木1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="木2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="木3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="木4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="木5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="木6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="木7"></td>
              </tr>
              <tr>
                <td class="date">金</td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="金1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="金2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="金3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="金4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="金5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="金6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="金7"></td>
              </tr>
              <tr>
                <td class="date">土</td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="土1"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="土2"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="土3"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="土4"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="土5"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="土6"></td>
                <td><input class="uk-checkbox" name="times[]" v-model="checkBox.times" type="checkbox" value="土7"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="uk-text-center uk-margin">
        <button class="uk-button uk-button-default" type="submit" form="modal_form" v-on:click="checkFrom">検索する</button>
        <p class="error">
          @{{ Validation.checkBox }}
        </p>
      </div>
    </form>
  </div>

</div>

<script>
  new Vue({
    el: "#training_search",
    data: function() {
      return {
        checkBox: {
          subjects: [],
          times: [],
        }, //ここにカンマを追加
        //ここから追加
        Validation: {
          checkBox: "",
        }
        //ここまでを追加
      }
    }, //ここにカンマを追加

    methods: {
      checkFrom: function(event) {

        if ((this.checkBox.subjects.length == 0) && (this.checkBox.times.length == 0)) {
          this.Validation.checkBox = "どちらか一つ以上選択してください"
        } else {
          return true
        }
        event.preventDefault()
      },
    }

  })
</script>

@endsection