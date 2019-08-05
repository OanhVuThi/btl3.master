@extends('admin.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div>
                <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Thêm Người Quản Lý</a>
                <a href="{{ route('admin.user.export') }}" class="btn btn-primary">Bảng Excel Quản Lý</a>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Danh Sách Người Quản Lý</div>
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
                        <form method="POST" action="{{ route('admin.user.reset-password') }}">
                        @csrf
                        <button type="submit" class="btn btn-link"> Reset Password </button>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Check</th>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhật</th>
                                <th>Chức năng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><input type="checkbox" name="reset[]" value="{{ $user->id }}"></td>
                                    <td>{{ $user->id }}</td>
                                    <td data-id="{{$user->id}}">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <a href="#" data-id="{{ $user->id }}" class="btn btn-info edit-user">Edit</a>
                                        <a href="{{ route('admin.user.destroy', ['id' => $user->id]) }}"
                                           class="btn btn-danger"
                                           onclick="event.preventDefault();
                                                    window.confirm('Bạn đã chắc chắn xóa chưa?') ?
                                                   document.getElementById('user-delete-{{ $user->id }}').submit() :
                                                   0;">Xóa</a>
                                        <form action="{{ route('admin.user.destroy', ['id' => $user->id]) }}?_method=DELETE"
                                              method="post" id="user-delete-{{ $user->id }}">
                                            @csrf
                                        </form>                                   
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="userCrudModal"></h4>
        </div>
        <div class="modal-body">
            <form id="userForm" name="userForm" class="form-horizontal">
               <input type="hidden" name="user_id" id="user_id">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                    </div>
                </div>
             </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="create">Save changes
            </button>
        </div>
    </div>
  </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script>
    $(document).ready(function () {
        'use strict';
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const EDIT_URL = "{{route('user.root.edit')}}";
        $('body').on('click', '.edit-user', function () {
            var user_id = $(this).data('id');
            $.get('/ajax-crud/' + user_id +'/edit', function (data) {
                $('#userCrudModal').html("Edit User");
                $('#btn-save').val("edit-user");
                $('#ajax-crud-modal').modal('show');
                $('#user_id').val(data.id);
                $('#name').val(data.name);
            })
        })
        $(document).on('click', '#btn-save', function () {
            $.ajax({
                data: $('#userForm').serialize(),
                url:  EDIT_URL,
                method: "POST",
                dataType: "JSON",
                success: function (data) {
                    let element = $(`td[data-id=${data.id}]`)
                    element.text(data.name)
                    $('#ajax-crud-modal').modal('hide');
                    alert('Sửa Quản Lý Thành Công')     
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#btn-save').html('Save Changes');
                }
            });           
        })
    });
</script>
@can('root')
    {{ 'admin' }}
@endcan
@endsection
