@extends('admin.master', ['title' => 'Admin panel - Create new category'])

@section('content')
<div class="col-sm-6">
	@include('errors.list')
	<div class="form">
		{!! Form::open(['method' => 'POST', 'url'=> route('AdminCategoryStore')]) !!}
		<div class="form-group">
			{!! Form::label('name', 'Name:') !!}
			{!! Form::text('name', null, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('parent_id', 'Parent Category:') !!}
			{!! Form::select('parent_id', $categories, null, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('slug', 'Slug:') !!}
			{!! Form::text('slug', null, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Create category',  ['class' => 'btn btn-primary form-control']) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection