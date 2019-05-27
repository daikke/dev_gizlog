@extends ('common.user')
@section ('content')

<h2 class="brand-header">日報作成</h2>
<div class="main-wrap">
  @if ($errors->has('user_id'))
    <span class="help-block">{{$errors->first('user_id')}}</span>
  @else
    <div class="container">
      {!! Form::open(['route'=>'daily_report.store']) !!}
        {!! Form::input('hidden', 'user_id', Auth::id()) !!}
        @if ($errors->has('reporting_time'))
          <div class="form-group form-size-small has-error">
        @else
          <div class="form-group form-size-small">
        @endif
            {!! Form::input('string', 'reporting_time', Carbon::now()->format('Y/m/d'), ['class'=>'form-control form-require-input']) !!}
            <span class="help-block">{{$errors->first('reporting_time')}}</span>
          </div>
        @if ($errors->has('title'))
          <div class="form-group has-error">
        @else
          <div class="form-group">
        @endif
            {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => 'Title'])!!}
            <span class="help-block">{{$errors->first('title')}}</span>
          </div>
        @if ($errors->has('contents'))
          <div class="form-group has-error">
        @else
          <div class="form-group">
        @endif
            {!! Form::textarea('contents', null, ['class' => 'form-control', 'placeholder' => 'Content'])!!}
            <span class="help-block">{{$errors->first('contents')}}</span>
          </div>
        {!! Form::submit('Add', ['class' => 'btn btn-success pull-right'])!!}
      {!! Form::close() !!}
    </div>
  @endif
</div>
@endsection

