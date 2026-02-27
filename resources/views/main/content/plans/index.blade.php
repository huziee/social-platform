@extends('main.body.master')

@section('title', 'subscription')

@section('main')

<div class="card bg-dark border-secondary">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h4 class="text-white">Get Verified</h4>
            <p class="text-secondary small">Establish your presence and get exclusive features.</p>
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