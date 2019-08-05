
@extends('admin.master')
@section('content')
    <div class="container">
        <h1>Thêm {{$product->name}}</h1>
        <div class="row">
            <div class="form-three widget-shadow">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form name="user" action="{{route('depotProduct.update', $product->id)}}" method="POST" class="form-horizontal">
                     @csrf
                     @method('PATCH')
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Số Lượng Nhập</label>
                        <div class="col-sm-8">
                            <input type="text" name="count" value="{{$product->count}}" class="form-control1" id="focusedinput" placeholder="Default Input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="depot">Kho</label>
                        <select name="depot_id" id="depot_id" class="form-control">
                            @if(count($depots) > 0)
                            @foreach($depots as $depot)
                        <option value="{{ $depot->id }}">{{ $depot->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                    <div class="col-sm-offset-2">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
