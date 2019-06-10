@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問詳細</h1>
<div class="main-wrap">
  <div class="panel panel-success">
    <div class="panel-heading">
      <img src="{{ $objectSelectedQuestion->users->first()->avatar }}" class="avatar-img">
      <p>&nbsp;{{ $objectSelectedQuestion->users->first()->name }}さんの質問&nbsp;&nbsp;(&nbsp;{{ $objectSelectedQuestion->tagCategories->first()->name }}&nbsp;)</p>
      <p class="question-date">{{ $objectSelectedQuestion->created_at }}</p>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <th class="table-column">Title</th>
            <td class="td-text">{{ $objectSelectedQuestion->title }}</td>
          </tr>
          <tr>
            <th class="table-column">Question</th>
            <td class='td-text'>{{ $objectSelectedQuestion->content }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    <div class="comment-list">
      @foreach ($objectSelectedQuestion->comments as $comment)
        <div class="comment-wrap">
          <div class="comment-title">
            <img src="{{ $comment->users->first()->avatar }}" class="avatar-img">
            <p>{{ $comment->users->first()->name }}</p>
            <p class="comment-date">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
          </div>
          <div class="comment-body">{{ $comment->comment }}</div>
        </div>
      @endforeach
    </div>
  <div class="comment-box">
    {{ Form::open(['route' => 'question.createComment']) }}
      <input name="user_id" type="hidden" value="{{ Auth::id() }}">
      <input name="question_id" type="hidden" value="{{ $objectSelectedQuestion->id }}">
      <div class="comment-title">
        <img src="" class="avatar-img"><p>コメントを投稿する</p>
      </div>
      <div class="comment-body">
        <textarea class="form-control" placeholder="Add your comment..." name="comment" cols="50" rows="10"></textarea>
        <span class="help-block">{{ $errors->first('comment') }}</span>
      </div>
      <div class="comment-bottom">
        <button type="submit" class="btn btn-success">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
      </div>
    {{ Form::close() }}
  </div>
</div>
@endsection