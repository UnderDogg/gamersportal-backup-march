@extends('store.primary-master')

@section('content')

<div class="panel panel-brand">
	<div class="panel-heading">
		<h3 class="panel-title">Order #{{ $order->id }}</h3>
	</div>
	<div class="panel-body">
		<div class="category-info">
			<h3>Order information</h3>
			<dl class="dl-horizontal">
				<dt>Customer</dt>
				<dd>#{{ $order->user->id }} {{ $order->user->name }}</dd>

				<dt>Order status</dt>
				<dd>{{ $order->status_code->name }}</dd>

				<dt>Order date and time</dt>
				<dd>{{ $order->created_at->format('d.m.Y.  H:i:s e') }}</dd>

				<dt>Adddress</dt>
				<dd>{{ $order->address->name }}</dd>
				<dd>{{ $order->address->street }}</dd>
				<dd>{{ $order->address->ZIP . ' ' . $order->address->city }}</dd>
				<dd>{{ $order->address->country->name }}{{ $order->address->state_id ? ', ' . $order->address->state->name : '' }}</dd>
				<dt>Payment method</dt>
				<dd>{{ $order->payment_method->name }}</dd>

				<dt>Weight</dt>
				<dd>{{ $order->weight }}</dd>
			</dl>
		</div>

		<ul class="list-group">
			@foreach($order->games as $gameItem)
			<a href="{{ route('StoreGameShow', $gameItem->game->slug) }}" class="inherit" target="_blank">
				<li class="list-group-item">{{ $gameItem->game->name }}, x{{ $gameItem->quantity }}, ${{ $gameItem->price * $gameItem->quantity }} </li>
			</a>
			@endforeach
			@if( $order->full_price < 150 - 15)
			<li class="list-group-item">Shipping (if order is under $150), $15</li>
			@endif
			<li class="list-group-item"><strong>Total: ${{ $order->full_price }}</strong></li>
		</ul>
	</div>
</div>


@endsection