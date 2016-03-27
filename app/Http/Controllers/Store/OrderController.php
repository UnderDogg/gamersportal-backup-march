<?php

namespace App\Http\Controllers\Store;

use App\Events\OrderWasPlaced;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Shopping\ShippingAddressRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderGame;
use Auth;
use Cart;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderController extends Controller
{	

	/**
	 * Shows form for selecting shipping address
	 * @return Response
	 */
    public function show()
    {	
    	\Session::forget('addressData');

    	return view('store.shopping.order-shipping');
    }

    /**
     * Proccess shipping address and returns form for paying and payment method
     * @param  ShippingAddressRequest $request
     * @return Response
     */
    public function proccessShipping(ShippingAddressRequest $request)
    {
    	if($request['shippingAddress'] == 'otherAddress')
    	{
    		$input = $request->all();

	        if($input['country_id'] != 840)
	        {
	            $input['state_id'] = null;
	        }

	        $address = Address::create($input);

    		$request->session()->put('addressId', $address->id);
    	} else {
    		$address = Auth::user()->address;
    	}

    	return view('store.shopping.confirm')->with(compact('address'));
    }


    public function confirm(Request $request)
    {
    	return view('store.shopping.confirm');
    }

    /**
     * Proccess payment
     * @param  Request $request
     * @return Response
     */
    public function pay(Request $request)
    {
    	$user = Auth::user();

    	if($request->session()->has('addressId'))
    	{
    		$address = Address::find($request->session()->get('addressId'));
    		$request->session()->forget('addressId');
    	} else {
    		$address = $user->address;
    	}

    	// array for order data
    	$orderData = [];
    	$orderData['full_price'] = Cart::totalWithShipping();
    	$orderData['user_id'] = $user->id;
    	$orderData['address_id'] = $address->id;

    	if($request->has('stripeToken'))
    	{	
    		\Stripe\Stripe::setApiKey(env('STRIPE_TEST_SECRET_KEY'));
    		$orderData['stripeToken'] = $request->get('stripeToken');
    		$orderData['payment_method_id'] = 1;

    		try
    		{
    			$charge = \Stripe\Charge::create(array(
					"amount" => $orderData['full_price'] * 100,
					"currency" => "usd",
					"source" => $orderData['stripeToken'],
					"description" => "Test charge; user e-mail: " . $user->email)
    			);
    		} catch(\Stripe\Error\Card $e) {
    			$request->session()->flash('status', 'Card declined, please fill your card and try again later.');

    			return redirect('/');
    		}
    	} else {
    		$orderData['payment_method_id'] = 2;
    	}

    	$cartGames = \Cart::associate('Game', 'App\Models')->content();
		$games = new Collection;
		foreach($cartGames as $item)
		{
			$games->push(['game' => \App\Models\Game::find($item->id),
				'quantity' => $item->qty]);
		}

		// Get the order weight
		$orderData['weight'] = 0;
		foreach ($games as $game)
		{
			$orderData['weight'] += $game['game']->weight * $game['quantity'];
		}

		$order = Order::create($orderData);
		foreach ($games as $game)
		{
			OrderGame::create([
				'order_id' => $order->id,
				'game_id' => $game['game']->id,
				'quantity' => $game['quantity'],
				'price' => (float) $game['game']->price * $game['quantity']
			]);
		}

        Event::fire(new OrderWasPlaced($order));

		Cart::destroy();

		$request->session()->flash('status', 'Order recieved.');

		return redirect('/');
    }
}
