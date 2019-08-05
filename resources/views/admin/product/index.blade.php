@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('product.create') }}" class="btn btn-primary">Tạo Sản Phẩm</a>
                <a href="{{ route('product.index') }}" class="btn btn-primary">Kho Quản Lý</a>
                <a href="{{ route('depotProduct.index') }}" class="btn btn-primary">Lịch Sử Xuất- Nhập</a>
                <a href="{{ route('product.export') }}" class="btn btn-primary">Bảng Excel Sản Phẩm</a>
            </div>
            <br>
            <div class="panel panel-default">
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
                                <th>Số Lượng</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                                <th>Cài Đặt</th>
                                <th>Chức Năng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{number_format($product->count)}}</td>
                                    <td>{{ $product->created_at }}</td>
                                    <td>{{ $product->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('product.show', ['id' => $product->id]) }}"
                                           class="btn btn-primary">Sửa</a>
                                        <a href="{{ route('product.destroy', ['id' => $product->id]) }}"
                                           class="btn btn-danger"
                                           onclick="event.preventDefault();
                                                    window.confirm('Bạn đã chắc chắn xóa chưa?') ?
                                                   document.getElementById('product-delete-{{ $product->id }}').submit() :
                                                   0;">Xóa</a>
                                        <form action="{{ route('product.destroy', ['id' => $product->id]) }}"
                                              method="post" id="product-delete-{{ $product->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('depotProduct.show', ['id' => $product->id]) }}" class="btn btn-success">Nhập vào kho</a>
                                        <a href="{{ route('depotProduct.edit', ['id' => $product->id]) }}" class="btn btn-success">Xuất ra từ kho</a>
                                       
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
