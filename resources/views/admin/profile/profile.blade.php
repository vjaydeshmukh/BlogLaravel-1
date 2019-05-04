@extends('layouts.admin')

@section('content')
    
<h1 class="page-header">Profile</h1>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Profile
            </div>
            <div class="panel-body">
                <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" type="text" value="{{$errors->isEmpty() ? $user->name : old('name')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" type="email" value="{{$errors->isEmpty() ? $user->email : old('email')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Avatar | Max : 2 MB | Width : 100px | Height : 100px</label><br>
                        <img src="{{asset($user->profile->avatar)}}" width="100px" height="100px">
                        <input name="avatar" type="file" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label>About</label>
                        <textarea name="user_about" cols="30" rows="10" class="form-control" required>{{$errors->isEmpty() ? $user->profile->user_about: old('user_about')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" cols="30" rows="10" required>{{$errors->isEmpty() ? $user->profile->address : old('address')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" value="{{$errors->isEmpty() ? $user->profile->contact_number : old('contact_number')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input type="email" name="contact_email" value="{{$errors->isEmpty() ? $user->profile->contact_email : old('contact_email')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" name="instagram" value="{{$errors->isEmpty() ? $user->profile->instagram : old('instagram')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" name="facebook" value="{{$errors->isEmpty() ? $user->profile->facebook : old('facebook')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Twitter</label>
                        <input type="text" name="twitter" value="{{$errors->isEmpty() ? $user->profile->twitter : old('twitter')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>LinkedIn</label>
                        <input type="text" name="linkedin" value="{{$errors->isEmpty() ? $user->profile->linkedin : old('linkedin')}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Github</label>
                        <input type="text" name="github" value="{{$errors->isEmpty() ? $user->profile->github : old('github')}}" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection