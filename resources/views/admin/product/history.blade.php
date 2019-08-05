@extends('admin.master')
@section('content')
    <div class="container">
        <h1>Lịch Sử Nhập Xuất Hàng Hóa </h1>
        <div style="margin: 20px 0">
                <a href ="{{route('depotProduct.export')}}" class="btn btn-primary export" id="export-button"> Xuất file excel</a>
        </div>
        <div class="tables container">
            <div class="table-responsive bs-example widget-shadow">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>ID kho</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($historys as $history)
                        <tr>
                            <td>{{ $history->product_id}}</td>
                            <td>{{ number_format($history->count)}}</td>
                            <td>{{ $history->depot_id}}</td>
                        </tr>     
                        @empty  
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection