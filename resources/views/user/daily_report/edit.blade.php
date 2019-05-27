@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  @if ($errors->has('user_id'))
    <span class="help-block">{{$errors->first('user_id')}}</span>
  @else
    <div class="container">
      {!! Form::open(['route' => ['daily_report.update', $daily_reports->id], 'method' => 'PUT'])!!}
        <input class="form-control" name="user_id" type="hidden" value="{{ Auth::id() }}">
        @if ($errors->has('reporting_time'))
          <div class="form-group form-size-small has-error">
        @else
          <div class="form-group form-size-small">
        @endif
            <input class="form-control" name="reporting_time" type="date" value="{{ Carbon::createFromTimeString($daily_reports->reporting_time)->format('Y-m-d') }}">
          <span class="help-block">{{ $errors->first('reporting_time') }}</span>
          </div>
        @if ($errors->has('title'))
          <div class="form-group has-error">
        @else
          <div class="form-group">
        @endif
            <input class="form-control" placeholder="{{ $daily_reports->title }}" name="title" type="text">
          <span class="help-block">{{ $errors->first('title') }}</span>
          </div>
        @if ($errors->has('contents'))
          <div class="form-group has-error">
        @else
          <div class="form-group">
        @endif
            <textarea class="form-control" placeholder="{{ $daily_reports->contents }}" name="contents" cols="50" rows="10"></textarea>
          <span class="help-block">{{ $errors->first('contents') }}</span>
          </div>
        <button type="submit" class="btn btn-success pull-right">Update</button>
      {!! Form::close() !!}
    </div>
  @endif
</div>

@endsection

