<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;


use Session\Session;
use Stripe;
use Stripe\Charge;
use Stripe\Stripe as StripeStripe;


class StripePaymentController extends Controller
{
 

    public function stripePost(Request $request)
    {
        try {

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $res = $stripe->tokens->create([
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $response = $stripe->charges->create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $res->id,
                'description' => $request->description,
            ]);
            return response()->json([$response->status], 201);
        } catch (Exception $ex) {
            return response()->json([['response' => 'Error']], 500);
        }
    }
}
