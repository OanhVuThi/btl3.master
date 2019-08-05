@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('product.index') }}" class="btn btn-primary">Danh sách Sản Phẩm</a>
                 
            </div>
            <br>
            <div class="panel panel-default">
                <h2 class="panel-heading">Thêm Sản Phẩm</h2>
                <div class="panel-body">
                    <form  id="spForm" action="{{ route('product.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Tên sản phẩm"
                                   value="{{ old('name') }}">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                        <button type="button" class="btn btn-warning btn-submit">Thêm Sản phẩm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
</script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".btn-submit").click(function(e){
                e.preventDefault();
                var name = $("input[name = 'name']").val();
                if ((name == '')) {
                    alert('bạn phải nhập đầy đủ dữ liệu');
                    return;
                }
                if (name.length > 20 ){
                    alert('Tên sản phẩm không vượt quá 30 ký tự');
                    return;
                }

                $("#spForm").submit()
            })
            
        })
    </script>
@endsection
