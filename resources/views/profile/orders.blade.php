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
                <div class="mb-4">
                    <h2 class="font-heading mb-2">My Orders</h2>
                    <p class="text-muted">Review your past and current physical and digital orders.</p>
                </div>

                <div class="card border-0 shadow-sm p-4" style="background-color: var(--c-white);">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Order #</th>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Total</th>
                                        <th class="border-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>#{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge rounded-pill @if($order->status == 'completed') bg-success-subtle text-success @elseif($order->status == 'pending') bg-warning-subtle text-warning @else bg-info-subtle text-info @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>₹{{ number_format($order->grand_total, 2) }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-dark px-3 rounded-0">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">You haven't placed any orders yet.</h5>
                            <a href="{{ route('home') }}" class="btn btn-primary-custom2 mt-3">Start Shopping</a>
                        </div>
                    @endif
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
    .bg-success-subtle { background-color: #e6f7ef; }
    .bg-warning-subtle { background-color: #fff8eb; }
    .bg-info-subtle { background-color: #e7f6f8; }
</style>
@endsection
