@extends('admin.master')
@section('content')
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<h1>Đổi mật khẩu lần đầu đăng nhập</h1>
<form id="form-change-password" role="form" method="POST" action="{{ route('pass') }}" novalidate class="form-horizontal">
   
    <div class="col-md-9">
      <label for="current_password" class="col-sm-4 control-label">Mật khẩu hiện tại</label>
      <div class="col-sm-8">
        <div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password">
          <span class="help-block">{{ $errors->first('current_password') }}</span>
        </div>
      </div>
      <label for="password" class="col-sm-4 control-label">Mật khẩu mới</label>
      <div class="col-sm-8">
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <span class="help-block">{{ $errors->first('password') }}</span>
        </div>
      </div>
      <label for="password_confirmation" class="col-sm-4 control-label">Nhập lại mật khẩu mới</label>
      <div class="col-sm-8">
        <div class="form-group">
          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter Password">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-5 col-sm-6">
        <button type="submit" class="btn btn-danger">Submit</button>
      </div>
    </div>
  </form>
@endsection