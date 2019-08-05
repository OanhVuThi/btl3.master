@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">Danh sách Người Quản Lý</a>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Cập nhật thông tin</div>
                <div class="panel-body">
                    <form id="uForm"action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST">
                        {{ csrf_field() }}
                         <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>" />
                        {{ method_field('put') }}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">Họ tên</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Họ tên"
                                   value="{{ $user->name }}">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                        <button type="button" class="btn btn-success btn-submit">Cập nhật </button>
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

                $("#uForm").submit()
            })
            
        })
    </script>
@endsection
