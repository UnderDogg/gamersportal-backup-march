@extends('store.master', ['title' => 'Checkout'])

@section('main')

<div class="panel panel-brand">
	<div class="panel-heading"><h3 class="panel-title text-center">Checkout</h3></div>
	<div class="panel-body white-section">
		<ul class="list-group">
			@foreach($cart->content() as $game)
			<li class="list-group-item">{{ $game->name }}, x{{ $game->qty }}, ${{ $game->price * $game->qty }} </li>
			@endforeach
			@if( Cart::total() < 150)
			<li class="list-group-item">Shipping (if order is under $150), $15</li>
			@endif
		</ul>
	</div>
	<div class="panel-footer clearfix">
		<span class="total-price"><strong>Total: ${{ Cart::totalWithShipping() }}</strong></span>
		<span class="pull-right">
			<a href="{{ route('StoreOrder') }}"><button class="btn btn-success">Proceed with order</button></a>
			<a href="/"><button class="btn btn-danger">Continue shopping</button></a>
		</span>
	</div>
</div>

@endsection