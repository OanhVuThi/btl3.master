@extends('admin.master')
@section('content')
<div class="alert alert-danger">
    <strong>Bạn chỉ có quyền xem thông tin không có quyền  truy cập !!!</strong>
  </div>
<a href="{{ route('out') }}" class="btn btn-link">Đăng nhập với tài khoản root</a>
@endsection
