<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Token;

class PaymentController extends Controller
{

        public function stripe()
    {
        return view('stripe');
    }


    public function charge(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $token = $request->input('stripeToken');

        $charge = Charge::create([
            'amount' => 1000, // amount in cents
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
        ]);

        // Handle successful payment here

        return redirect('/')->with('success', 'Payment successful.');
    }
}

