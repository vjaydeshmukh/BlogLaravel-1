@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Created At</th>
                                <th>Readed</th>
                                <th colspan="3" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($message->count() > 0)
                            @foreach ($message as $row)
                            <tr>
                                <td>{{$row->msg_name}}</td>
                                <td>{{$row->msg_email}}</td>
                                <td>{{$row->msg_body}}</td>
                                <td>{{date('j F Y', strtotime($row->created_at))}}</td>
                                <td>
                                    @if ($row->readed == 1)
                                    Readed
                                    @else
                                    UnRead
                                    @endif
                                </td>
                                <td width="80px" class="text-center">
                                    <a href="{{route('message.reply', ['id'=>$row->msg_id])}}" class="btn btn-primary">Reply</a>
                                </td>
                                <td width="90px" class="text-center">
                                    <a href="{{route('message.delete', ['id'=>$row->msg_id])}}" class="btn btn-danger">Hapus</a>
                                </td>
                                <td width="100px" class="text-center">
                                    @if ($row->readed == 1)
                                    <a href="{{route('message.read', ['id'=>$row->msg_id])}}" class="btn btn-secondary">Mark As UnRead</a>
                                    @else
                                    <a href="{{route('message.read', ['id'=>$row->msg_id])}}" class="btn btn-secondary">Mark As Read</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                            @else
                            <tr>
                                <td colspan="6" class="text-center text-danger">No message Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="text-center">
                        {{$message->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection