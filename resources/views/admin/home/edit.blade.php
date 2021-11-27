@extends('admin.admin_master')

@section('admin')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="py-12">

    <div class="container">
        <div class="row">




            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit About</div>
                    <div class="card-body">
                        <form action="{{ url('about/update/'.$abouts->id) }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Update About Title</label>
                                <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $abouts->title }}">

                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Update About Short Description</label>
                                
                                <input type="text" name="short_description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $abouts->short_description }}">

                                @error('short_description')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Update About Long Description</label>
                                <input type="text" name="long_description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $abouts-> long_description }}">

                                @error('long_description')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>

                            
                            <div class="form-group">

                            </div>

                            <button type="submit" class="btn btn-primary">Update About</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection