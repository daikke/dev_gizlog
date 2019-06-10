@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問編集</h1>

<div class="main-wrap">
  <div class="container">
    {{ Form::open(['route' => ['question.update', $objectSearchedQuestion->id]]) }}
      <div class="form-group">
        <select name='tag_category_id' class = "form-control selectpicker form-size-small" id ="pref_id">
          @foreach ($objectTagCategories as $objectTagCategory)
            <option value="{{ $objectTagCategory->id }}" {{ $objectTagCategory->id === $objectSearchedQuestion->tag_category_id ? 'selected' : '' }}>{{ $objectTagCategory->name }}</option>
          @endforeach
        </select>
        <span class="help-block">{{ $errors->first('tag_category_id') }}</span>
      </div>
      <div class="form-group">
        <input class="form-control" placeholder="title" name="title" type="text" value="{{ $objectSearchedQuestion->title }}">
        <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="{{ $objectSearchedQuestion->content }}" name="content" cols="50" rows="10"></textarea>
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      <input name="confirm" class="btn btn-success pull-right" type="submit" value="update">
    {{ Form::close() }}
  </div>
</div>

@endsection

