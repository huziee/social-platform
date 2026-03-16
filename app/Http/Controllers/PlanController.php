<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PlanController extends Controller
{

    public function index()
    {
        return view('main.content.plans.index');
    }

    public function processSubscription(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $plan = $request->plan;

        $amount = ($plan == 'yearly') ? 9500 : 999;
        $name = ($plan == 'yearly') ? 'Yearly Premium' : 'Monthly Premium';

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $name,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('subscribe.success') . '?plan=' . $plan,
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
            'subscription_ends_at' => $request->plan == 'yearly'
                ? now()->addYear()
                : now()->addMonth(),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Payment successful! Welcome to Premium.');
    }

    public function cancelSubscription()
    {
        $user = auth()->user();

        $user->update([
            'is_subscribed' => false,
            'plan_type' => null,
            'subscription_ends_at' => null,
        ]);

        return back()->with('success', 'Subscription cancelled.');
    }
}