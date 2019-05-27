@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  @if ($errors->has('user_id'))
    <span class="help-block">{{ $errors->first('user_id') }}</span>
  @else
    <div class="container">
      {!! Form::open(['route' => ['daily_report.update', $dailyReports->id], 'method' => 'PUT']) !!}
        {!! Form::input('hidden', 'user_id', Auth::id(), ['class' => 'form-control']) !!}
        @if ($errors->has('reporting_time'))
          <div class="form-group form-size-small has-error">
        @else
          <div class="form-group form-size-small">
        @endif
            {!! Form::input('date', 'reporting_time', Carbon::createFromTimeString($dailyReports->reporting_time)->format('Y-m-d'), ['class' => 'form-control']) !!}
            <span class="help-block">{{ $errors->first('reporting_time') }}</span>
          </div>
        @if ($errors->has('title'))
          <div class="form-group has-error">
        @else
          <div class="form-group">
        @endif
            {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => $dailyReports->title]) !!}
            <span class="help-block">{{ $errors->first('title') }}</span>
          </div>
        @if ($errors->has('contents'))
          <div class="form-group has-error">
        @else
          <div class="form-group">
        @endif
            {!! Form::textarea('contents', null, ['class' => 'form-control', 'placeholder' => $dailyReports->contents]) !!}
            <span class="help-block">{{ $errors->first('contents') }}</span>
          </div>
        {!! Form::submit('Update', ['class' => 'btn btn-success pull-right']) !!}
      {!! Form::close() !!}
    </div>
  @endif
</div>

@endsection

