@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.depot.index') }}" class="btn btn-primary">Danh sách kho</a>
            </div>
            <br>
            <div class="panel panel-default">
                <h2 class="panel-heading">Cập nhật kho</h2>
                <div class="panel-body">
                    <form id="kForm"action="{{ route('admin.depot.update', ['id' => $depot->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">Tên kho</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Tên kho"
                                   value="{{ $depot->name }}">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                       <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                <label for="user">Người Quản Lý</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    @if(count($users) > 0)
                                    @foreach($users as $user)
                                <option value="{{ $user->id }}" @if($depot->user_id == $user->id) selected 
                                    @endif
                                    >{{ $user->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            </div>

                        <button type="button" class="btn btn-danger btn-submit">Cập nhật</button>
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

                $("#kForm").submit()
            })
            
        })
    </script>
@endsection
