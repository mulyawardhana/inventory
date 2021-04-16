@extends('layouts.master')
@section('content')
	<div class="card">
		<div class="card-header"><h4>Tambah Master</h4></div>
		<div class="card-body">
			@if(count($errors) > 0)
			<ul class="alert alert-danger">
				@foreach($errors->all() as $error)
				<li>{{$error}}</li>
				@endforeach
			</ul>
			@endif
			<form action="{{route('user.update', $users->id)}}" method="POST">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="name">Nama User</label>
					<input type="text" name="name" class="form-control" value="{{$users->name}}">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" name="email" class="form-control" value="{{$users->email}}">
				</div>
				<div class="form-group">
					<label for="level">Level</label>
					<div class="form-check">
						<input type="radio" name="level" value="operator" class="form-check-input" checked value="{{$users->level}}">
						<label class="form-check-label" for="level">Operator</label>
					</div>
					<div class="form-check">
						<input type="radio" name="level" value="admin" class="form-check-input" checked value="{{$users->level}}">
						<label class="form-check-label" for="level">Admin</label>
					</div>	
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="text" name="password" class="form-control">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Simpan</button>
					<a href="/user" class="btn btn-warning">Batal</a>
				</div>

			</form>
		</div>
	</div>
@endsection