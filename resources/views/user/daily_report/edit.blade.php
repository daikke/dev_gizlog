@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  @if ($errors->has('user_id'))
    <span class="help-block">{{ $errors->first('user_id') }}</span>
  @else
    <div class="container">
      {!! Form::open(['route' => ['daily_report.update', $dailyReport->id], 'method' => 'PUT']) !!}
        <div class="form-group form-size-small {{ $errors->has('reporting_time') ? 'has-error' : '' }}">
          {!! Form::input('date', 'reporting_time', $dailyReport->reporting_time->format('Y-m-d'), ['class' => 'form-control']) !!}
          <span class="help-block">{{ $errors->first('reporting_time') }}</span>
        </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
          {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => $dailyReport->title]) !!}
          <span class="help-block">{{ $errors->first('title') }}</span>
        </div>
        <div class="form-group {{ $errors->has('contents') ? 'has-error' : '' }}">
          {!! Form::textarea('contents', null, ['class' => 'form-control', 'placeholder' => $dailyReport->contents]) !!}
          <span class="help-block">{{ $errors->first('contents') }}</span>
        </div>
        {!! Form::submit('Update', ['class' => 'btn btn-success pull-right']) !!}
      {!! Form::close() !!}
    </div>
  @endif
</div>

@endsection

