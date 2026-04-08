@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background-color: var(--c-linen); min-height: 80vh;">
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm p-4 h-100" style="background-color: var(--c-white);">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; border: 1px solid var(--c-gold);">
                            <i class="fa-solid fa-user fa-2x text-gold"></i>
                        </div>
                        <h5 class="font-heading mb-1">{{ $customer->name }}</h5>
                        <p class="text-muted small mb-0">{{ $customer->email }}</p>
                    </div>
                    
                    <hr class="my-4 opacity-10">
                    
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <a href="{{ route('profile.dashboard') }}" class="d-flex align-items-center gap-3 text-dark text-decoration-none">
                                <i class="fa-solid fa-gauge-high text-gold" style="width: 20px;"></i>
                                <span class="fw-bold">Dashboard</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('profile.orders') }}" class="d-flex align-items-center gap-3 text-muted text-decoration-none hover-gold transition-all">
                                <i class="fa-solid fa-box" style="width: 20px;"></i>
                                <span>My Orders</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('profile.addresses') }}" class="d-flex align-items-center gap-3 text-muted text-decoration-none hover-gold transition-all">
                                <i class="fa-solid fa-location-dot" style="width: 20px;"></i>
                                <span>My Addresses</span>
                            </a>
                        </li>
                        <li class="mt-5">
                            <form action="/customer/logout" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item p-0 d-flex align-items-center gap-3 text-danger border-0 bg-transparent">
                                    <i class="fa-solid fa-right-from-bracket" style="width: 20px;"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-heading mb-2">My Addresses</h2>
                        <p class="text-muted">Manage your shipping and billing addresses.</p>
                    </div>
                    <button class="btn btn-primary-custom2 rounded-0">
                        <i class="fa-solid fa-plus me-2"></i> Add New Address
                    </button>
                </div>

                <div class="row">
                    @forelse($addresses as $address)
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm p-4 h-100" style="background-color: var(--c-white);">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h6 class="font-heading mb-0">{{ $address->name }} @if($address->is_default) <span class="badge bg-gold ms-2" style="font-size: 10px;">DEFAULT</span> @endif</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><a class="dropdown-item py-2" href="#"><i class="fa-solid fa-pen-to-square me-2 small"></i> Edit</a></li>
                                            <li><a class="dropdown-item py-2 text-danger" href="#"><i class="fa-solid fa-trash me-2 small"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="text-muted small mb-1">{{ $address->phone }}</p>
                                <p class="text-dark small mb-3">
                                    {{ $address->address_line1 }}, {{ $address->address_line2 ? $address->address_line2 . ',' : '' }}<br>
                                    {{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}<br>
                                    {{ $address->country }}
                                </p>
                                <div class="mt-auto">
                                    @if(!$address->is_default)
                                        <button class="btn btn-sm btn-link p-0 text-gold text-decoration-none small">Set as Default</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card border-0 shadow-sm p-5 text-center" style="background-color: var(--c-white);">
                                <i class="fa-solid fa-location-dot fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">You haven't saved any addresses yet.</h5>
                                <div class="mt-3">
                                    <button class="btn btn-primary-custom2 rounded-0">Add Your First Address</button>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-gold:hover {
        color: var(--c-gold) !important;
        transform: translateX(5px);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .text-gold {
        color: var(--c-gold) !important;
    }
    .font-heading {
        font-family: var(--f-head);
    }
    .bg-gold {
        background-color: var(--c-gold);
    }
</style>
@endsection
