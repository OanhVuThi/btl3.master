@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">Danh sách quản lý</a>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Thêm quản lý</div>
                <div class="panel-body">
                    <form id="qlForm" action="{{ route('admin.user.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">Họ tên</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Họ tên"
                                value="{{ old('name') }}">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">Địa chỉ Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Địa chỉ Email"
                                value="{{ old('email') }}">
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>
                        <button type="button" class="btn btn-success btn-submit">Tạo quản lý</button>
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
                var email = $("input[name = 'email']").val();
                var name = $("input[name = 'name']").val();
                if ((email == '') || (name == '')) {
                    alert('bạn phải nhập đầy đủ dữ liệu');
                    return;
                }
                if (name.length > 20 ){
                    alert('Tên không vượt quá 20 ký tự');
                    return;
                }

                $("#qlForm").submit()
            })
            
        })
    </script>
@endsection
@section('js')
<script src="{{ asset('js/addql.js') }}" defer></script>
@endsection
