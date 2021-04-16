@extends('layouts.master')
@section('content')

<div class="card">
  <div class="card-header">
    <h4>Data User
    <a href="{{route('user.create')}}" class="btn btn-primary mb-2" style="float: right"><i class="fa fa-plus"></i> Tambah Master</a>
  </h4>
  </div>
  <div class="card-body">
    @if(Session::has('pesan'))
      <div class="alert alert-success mt-2">
        {{Session::get('pesan')}}
      </div>
    @endif
    <table id="dataTable" class="table table-bordered" cellspacing="0">
      <thead>
        <tr>
          <th>No</th>
          <th>Aksi</th>
          <th>Nama User</th>
          <th>Email</th>
          <th>level</th>
        </tr>
        <tbody>
          @foreach($users as $i => $u)
          <tr>
            <td>{{++$i}}</td>
            <td>
              <form action="{{route('user.destroy', $u->id)}}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{route('user.edit', $u->id)}}" class="btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                <button onclick="return confirm('Mau di Hapus?')" class="btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
              </form>
            </td>
            <td>{{$u->name}}</td>
            <td>{{$u->email}}</td>
            <td>{{$u->level}}</td>
   
          </tr>
          @endforeach
        </tbody>
      </thead>
    </table>
  </div>
</div>
@endsection