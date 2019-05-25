@extends('layouts.admin')

@section('content')
    <h1 class="page-heading">Tag</h1>
    <div class="row">
        <div class="panel panel-red">
            <div class="panel-heading">Edit Tag : {{$tag->tag_name}}</div>
            <div class="panel-body">
                <form action="{{route('tag.update', ['id'=>$tag->tag_id])}}" method="post">
                    {{ csrf_field() }}
                    @method('put')
                    <div class="form-group">
                        <label>Tag Name</label>
                        <input type="text" name="tag_name" class="form-control" value="{{$errors->isEmpty() ? $tag->tag_name : old('tag_name')}}" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Edit</button>
                </form>
                <hr>
                <a href="{{ route('tag.index') }}" class="btn btn-warning btn-block">Back</a>
            </div>
        </div>
    </div>
@endsection