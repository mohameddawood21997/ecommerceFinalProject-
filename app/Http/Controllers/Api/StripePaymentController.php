<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use Exception;

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
            $order=\App\Models\Order::where('user_id',1)->latest()->first();
            $order->payment_status='paid';
            $order->save();
            // $order->update(['statue'=>'paid']);
            //  $lastOrder = DB::table('orders')->orderBy('created_at', 'desc')->limit(1);
            return response()->json([$response->status], 201);
        } catch (Exception $ex) {
            return response()->json([['response' => 'Error']], 500);
        }
    }



}
