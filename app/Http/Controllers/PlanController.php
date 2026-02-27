<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use Stripe\Checkout\Session;

use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function  index() {

        return view('main.content.plans.index');
    }

   public function processSubscription(Request $request)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    // Map your plan types to Stripe Prices (Create these in Stripe Dashboard > Products)
    // For now, we'll use a dynamic price for testing
    $checkout_session = Session::create([
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => ($request->plan == 'yearly' ? 'Yearly Premium' : 'Monthly Premium'),
                ],
                'unit_amount' => ($request->plan == 'yearly' ? 9500 : 999), // Amount in cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment', // Use 'subscription' if you set up recurring products in Stripe
        'success_url' => route('subscribe.success') . '?plan=' . $request->plan,
        'cancel_url' => route('profile.index'),
    ]);

    return redirect($checkout_session->url);
}

public function success(Request $request)
{
    $user = auth()->user();
    $user->update([
        'is_subscribed' => true,
        'plan_type' => $request->plan,
        'subscription_ends_at' => ($request->plan == 'yearly') ? now()->addYear() : now()->addMonth(),
    ]);

    return redirect()->route('profile.index')->with('success', 'Payment successful! Welcome to Premium.');
}
}
