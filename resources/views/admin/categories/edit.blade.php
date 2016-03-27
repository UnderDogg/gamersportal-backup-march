@extends('admin.master', ['title' => 'Edit category'])

@section('content')
<div class="col-sm-8">
	@include('errors.list')
	<div class="form">
		{!! Form::model($category, ['method' => 'PATCH', 'url'=> route('AdminCategoryUpdate', $category->slug)]) !!}
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
			{!! Form::submit('Update category',  ['class' => 'btn btn-primary form-control']) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>

@endsection