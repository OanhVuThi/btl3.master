@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.depot.create') }}" class="btn btn-primary">Tạo kho</a>
                <a href="{{route('admin.depot.export') }}" class="btn btn-primary">Bảng Excel Quản Lý Kho</a>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Danh sách kho</div>
                <div class="panel-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Người Quản lý</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                                <th>Chức năng</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($depots as $depot)
                                <tr>
                                    <td>{{ $depot->id }}</td>
                                    <td>{{ $depot->name }}</td>
                                    <td>{{ $depot->user ? $depot->user->name : '-' }}</td>
                                    <td>{{ $depot->created_at }}</td>
                                    <td>{{ $depot->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.depot.show', ['id' => $depot->id]) }}"
                                           class="btn btn-primary">Sửa</a>
                                        <a href="{{ route('admin.depot.destroy', ['id' => $depot->id]) }}"
                                           class="btn btn-danger"
                                           onclick="event.preventDefault();
                                                    window.confirm('Bạn đã chắc chắn xóa chưa?') ?
                                                   document.getElementById('depot-delete-{{ $depot->id }}').submit() :
                                                   0;">Xóa</a>
                                        <form action="{{ route('admin.depot.destroy', ['id' => $depot->id]) }}"
                                              method="post" id="depot-delete-{{ $depot->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No data</td>
                                </tr>
                            @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
