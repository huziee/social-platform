@extends('main.body.master')

@section('title', 'subscription')

@section('main')

<div class="card bg-dark border-secondary">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            
           @if(Auth::user()->is_subscribed)
            <div class="py-5">
                <div class="mb-3">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="#0095F6">
                        <path d="M10.5 1.75L12 0.25L13.5 1.75L15.42 1.45L16.25 3.12L18.12 3.58L18.25 5.5L19.85 6.6L19.25 8.42L20.35 10L19.25 11.58L19.85 13.4L18.25 14.5L18.12 16.42L16.25 16.88L15.42 18.55L13.5 18.25L12 19.75L10.5 18.25L8.58 18.55L7.75 16.88L5.88 16.42L5.75 14.5L4.15 13.4L4.75 11.58L3.65 10L4.75 8.42L4.15 6.6L5.75 5.5L5.88 3.58L7.75 3.12L8.58 1.45L10.5 1.75Z" />
                        <path d="M8 10L11 13L16 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h4 class="text-white">You are Verified!</h4>
                <p class="text-secondary">Your {{ ucfirst(Auth::user()->plan_type) }} plan is active until {{ \Carbon\Carbon::parse(Auth::user()->subscription_ends_at)->format('M d, Y') }}.</p>
                
                <form action="{{ route('subscribe.cancel') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove your blue tick?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Cancel Subscription</button>
                </form>
            </div>
        @else
            <h4 class="text-white">Get Verified</h4>
            <p class="text-secondary small">Choose a plan to get your blue tick.</p>
            
            <div class="row g-3 mt-2">
                </div>
        @endif
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 rounded-3 bg-light bg-opacity-10 border border-secondary h-100">
                    <h6 class="text-white">Monthly</h6>
                    <h2 class="text-white mb-3">$9.99 <span class="fs-6 fw-light text-secondary">/mo</span></h2>
                    <ul class="list-unstyled small mb-4 text-secondary">
                        <li><i class="bi bi-check2 text-primary me-2"></i> Blue verification badge</li>
                        <li><i class="bi bi-check2 text-primary me-2"></i> Priority in comments</li>
                        <li><i class="bi bi-check2 text-primary me-2"></i> Exclusive stickers</li>
                    </ul>
                    <form action="{{ route('subscribe.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="monthly">
                        <button type="submit" class="btn btn-primary w-100">Get Started</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 rounded-3 border border-success h-100 position-relative" style="background: rgba(25, 135, 84, 0.05);">
                    <span class="badge bg-success position-absolute top-0 end-0 m-2">Save 20%</span>
                    <h6 class="text-white">Annual</h6>
                    <h2 class="text-white mb-3">$95.00 <span class="fs-6 fw-light text-secondary">/yr</span></h2>
                    <ul class="list-unstyled small mb-4 text-secondary">
                        <li><i class="bi bi-check2 text-success me-2"></i> All Monthly features</li>
                        <li><i class="bi bi-check2 text-success me-2"></i> 2 months free</li>
                        <li><i class="bi bi-check2 text-success me-2"></i> Early access to tools</li>
                    </ul>
                    <form action="{{ route('subscribe.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="yearly">
                        <button type="submit" class="btn btn-success w-100">Subscribe Yearly</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection