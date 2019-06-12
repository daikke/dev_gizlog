@extends ('common.user')
@section ('content')
<h2 class="brand-header">投稿内容確認</h2>
<div class="main-wrap">
  <div class="panel panel-success">
    <div class="panel-heading">
      {{ $validatedInputs['tag_category_name'] }}の質問
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <th class="table-column">Title</th>
            <td class="td-text">{{ $validatedInputs['title'] }}</td>
          </tr>
          <tr>
            <th class="table-column">Question</th>
            <td class='td-text'>{!! nl2br($validatedInputs['content']) !!}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="btn-bottom-wrapper">
    {{ Form::open(['route' => 'question.store'])}}
      <input name="tag_category_id" type="hidden" value="{{ $validatedInputs['tag_category_id'] }}">
      <input name="title" type="hidden" value="{{ $validatedInputs['title'] }}">
      <input name="content" type="hidden" value="{{ $validatedInputs['content'] }}">
      <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
      @if(isset($validatedInputs['id']))
        {{ Form::input('hidden', 'redirectRoute', 'question.mypage') }}
      @else
        {{ Form::input('hidden', 'redirectRoute', 'question.index') }}
      @endif
    {{ Form::close() }}
  </div>
</div>

@endsection

