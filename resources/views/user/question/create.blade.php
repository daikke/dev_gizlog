@extends ('common.user')
@section ('content')

<h2 class="brand-header">質問投稿</h2>
<div class="main-wrap">
  <div class="container">
    {{ Form::open(['route' => 'question.confirm']) }}
      <div class="form-group">
        <select name='tag_category_id' class = "form-control selectpicker form-size-small" id="pref_id">
          <option value="">Select category</option>
            @foreach ($objectTagCategories as $objectTagCategory)
              <option value= "{{ $objectTagCategory->id }}">{{ $objectTagCategory->name }}</option>
            @endforeach
        </select>
        <span class="help-block">{{ $errors->first('tag_category_id') }}</span>
      </div>
      <div class="form-group">
        <input class="form-control" placeholder="title" name="title" type="text">
        <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="Please write down your question here..." name="content" cols="50" rows="10"></textarea>
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      <input name="confirm" class="btn btn-success pull-right" type="submit" value="create">
    {{ Form::close() }}
  </div>
</div>

@endsection

