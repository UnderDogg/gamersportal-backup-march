@extends('store.master', ['title' => 'Order - Pay and confirm'])

@section('main')

<div class="panel panel-brand">
	<div class="panel-heading"><h3 class="panel-title text-center">Game(s)</h3></div>
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
	</div>
</div>

<div class="panel panel-brand">
	<div class="panel-heading"><h3 class="panel-title text-center">Shipping adress</h3></div>
	<div class="panel-body white-section">
		<dl>
			<dd>{{ $address->name }}</dd>
			<dd>{{ $address->street }}</dd>
			<dd>{{ $address->ZIP . ' ' . $address->city }}</dd>
			<dd>{{ $address->country->name }}{{ $address->state_id ? ', ' . $address->state->name : '' }}</dd>
		</dl>
	</div>
</div>

<div class="panel panel-brand">
	<div class="panel-heading"><h3 class="panel-title text-center">Confirmation and payment method</h3></div>
	<div class="panel-body white-section">
		<form action="{{ route('StoreOrderPay') }}" method="POST">
			{!! csrf_field() !!}
			<script
				src="https://checkout.stripe.com/checkout.js" class="stripe-button"
				data-key="pk_test_Z1xHfrj7X6ngwa8MhtnB97TD"
				data-amount="{{ $cart->totalWithShipping() * 100}}"
				data-name="Gameshop"
				data-description="{{ $cart->count() }} game(s) - ${{ $cart->totalWithShipping() }}"
				data-image="{{ asset('favicon.png') }}"
				data-locale="auto">
			</script>
		</form>
		<div style="margin-top: 1em;">
		<form id="confirmOrder" action="{{ route('StoreOrderPay')}}" method="POST">
			{!! csrf_field() !!}
			<input type="hidden" name="cashOnDelivery" value="cashOnDelivery">
		</form>
			<button class="btn btn-primary btn-md" type="submit" form="confirmOrder">Cash on delivery</button>
		</div>
	</div>
</div>

@endsection