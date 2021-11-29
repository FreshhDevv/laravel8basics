@extends('admin.admin_master')

@section('admin')


<div class="card card-default">
    <div class="card-header card-header-border-bottom">
        <h2>Update User Profile</h2>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{session('success')}}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card-body">
        <form method="POST" action="{{ route('update.user.profile') }}" class="form-pill" enctype="multipart/form-data">
            <!-- If the csrf token is not added to the form, the data won't be saved in the databse. -->
            @csrf
            <div class="form-group">
                <label for="exampleFormControlInput3">User Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user['name'] }}">

            </div>

            <div class="form-group">
                <label for="exampleFormControlInput3">User Email</label>
                <input type="text" name="email" class="form-control" value="{{ $user['email'] }}">

            </div>

            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">Update Brand Image</label>
                <input type="file" name="profile_photo_path" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $user->profile_photo }}">

                @error('profile_photo')
                <span class="text-danger">{{$message}}</span>
                @enderror

            </div class="form-group">
            <img src="{{ Auth::user()->profile_photo_url }}" style="width: 400px; height: 200px;">
            <br><br>



            <div>
            <button type="submit" class="btn btn-primary btn-default">Update</button>
            </div>

        </form>
    </div>
</div>


@endsection