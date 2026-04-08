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
                            <a href="{{ route('profile.dashboard') }}" class="d-flex align-items-center gap-3 text-gold text-decoration-none">
                                <i class="fa-solid fa-gauge-high" style="width: 20px;"></i>
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
                    <h2 class="font-heading mb-2">Welcome, {{ explode(' ', $customer->name)[0] }}!</h2>
                    <p class="text-muted">From your account dashboard, you can easily check and view your recent orders, manage your shipping and billing addresses, and edit your password and account details.</p>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm p-4 text-center h-100" style="background-color: var(--c-white);">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-bag-shopping text-gold"></i>
                            </div>
                            <h3 class="mb-1 fw-bold">{{ $totalOrders }}</h3>
                            <p class="text-muted small mb-0 uppercase-tracking">Total Orders</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm p-4 text-center h-100" style="background-color: var(--c-white);">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-clock-rotate-left text-gold"></i>
                            </div>
                            <h3 class="mb-1 fw-bold">{{ $pendingOrders }}</h3>
                            <p class="text-muted small mb-0 uppercase-tracking">Pending Orders</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm p-4 text-center h-100" style="background-color: var(--c-white);">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-indian-rupee-sign text-gold"></i>
                            </div>
                            <h3 class="mb-1 fw-bold">₹{{ number_format($totalSpent, 0) }}</h3>
                            <p class="text-muted small mb-0 uppercase-tracking">Total Spent</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Area -->
                <div class="mb-4 d-flex justify-content-between align-items-end">
                    <h4 class="font-heading mb-0">Recent Orders</h4>
                    <a href="{{ route('profile.orders') }}" class="text-gold small text-decoration-none fw-bold hover-underline">View All</a>
                </div>

                <div class="card border-0 shadow-sm p-0 overflow-hidden mb-5" style="background-color: var(--c-white);">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background-color: #fcfbf9;">
                                    <tr>
                                        <th class="px-4 py-3 border-0 small uppercase-tracking">Order #</th>
                                        <th class="px-4 py-3 border-0 small uppercase-tracking">Date</th>
                                        <th class="px-4 py-3 border-0 small uppercase-tracking">Status</th>
                                        <th class="px-4 py-3 border-0 small uppercase-tracking">Total</th>
                                        <th class="px-4 py-3 border-0 small uppercase-tracking text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td class="px-4 py-3 border-bottom-light fw-bold">#{{ $order->order_number }}</td>
                                            <td class="px-4 py-3 border-bottom-light">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-3 border-bottom-light">
                                                <span class="badge rounded-pill @if($order->status == 'completed') bg-success-subtle text-success @elseif($order->status == 'pending') bg-warning-subtle text-warning @else bg-info-subtle text-info @endif" style="font-size: 11px;">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 border-bottom-light fw-bold">₹{{ number_format($order->grand_total, 2) }}</td>
                                            <td class="px-4 py-3 border-bottom-light text-end">
                                                <a href="#" class="btn btn-sm btn-outline-dark px-3 rounded-0 border-gold-hover transition-all">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted mb-0">No recent orders found.</p>
                        </div>
                    @endif
                </div>

                <!-- Account Settings Overview -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm p-4 h-100" style="background-color: var(--c-white);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="font-heading mb-0">Profile Info</h4>
                                <a href="#" class="text-gold small text-decoration-none fw-bold hover-underline">Edit</a>
                            </div>
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-user text-gold"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $customer->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $customer->email }}</p>
                                </div>
                            </div>
                            @if($customer->phone)
                            <div class="d-flex align-items-center gap-3 mt-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-phone text-gold"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Phone</h6>
                                    <p class="text-muted small mb-0">{{ $customer->phone }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm p-4 h-100" style="background-color: var(--c-white);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="font-heading mb-0">Default Address</h4>
                                <a href="{{ route('profile.addresses') }}" class="text-gold small text-decoration-none fw-bold hover-underline">Change</a>
                            </div>
                            @php $defaultAddress = $customer->addresses()->where('is_default', 1)->first(); @endphp
                            @if($defaultAddress)
                                <h6 class="mb-1 fw-bold">{{ $defaultAddress->name }}</h6>
                                <p class="text-muted small mb-0">
                                    {{ $defaultAddress->address_line1 }}, {{ $defaultAddress->address_line2 ? $defaultAddress->address_line2 . ',' : '' }}<br>
                                    {{ $defaultAddress->city }}, {{ $defaultAddress->state }} - {{ $defaultAddress->postal_code }}<br>
                                    {{ $defaultAddress->country }}
                                </p>
                            @else
                                <p class="text-muted small mt-2">No default address set.</p>
                                <a href="{{ route('profile.addresses') }}" class="btn btn-sm btn-outline-dark px-3 rounded-0 mt-2 d-inline-block">Add Address</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Password Change Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-4" style="background-color: var(--c-white);">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="font-heading mb-0">Security</h4>
                                <button class="btn btn-sm btn-outline-gold px-3 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#changePasswordForm">
                                    Change Password
                                </button>
                            </div>
                            
                            <div class="collapse" id="changePasswordForm">
                                <hr class="my-4 opacity-10">
                                <form id="passwordUpdateForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="small text-muted mb-2 uppercase-tracking">Current Password</label>
                                            <input type="password" name="current_password" class="form-control luxury-input-minimal w-100 py-2" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small text-muted mb-2 uppercase-tracking">New Password</label>
                                            <input type="password" name="new_password" class="form-control luxury-input-minimal w-100 py-2" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="small text-muted mb-2 uppercase-tracking">Confirm New Password</label>
                                            <input type="password" name="new_password_confirmation" class="form-control luxury-input-minimal w-100 py-2" required>
                                        </div>
                                    </div>
                                    <div class="text-end mt-2">
                                        <button type="submit" class="btn-luxury-solid px-4 py-2" id="updatePassBtn" style="font-size: 13px;">Update Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .btn-outline-gold {
        color: var(--c-gold);
        border: 1px solid var(--c-gold);
        background: transparent;
        transition: all 0.3s ease;
    }
    .btn-outline-gold:hover {
        background-color: var(--c-gold);
        color: var(--c-primary);
    }
</style>


<style>
    .font-heading {
        font-family: var(--f-head);
    }
    .text-gold {
        color: var(--c-gold) !important;
    }
    .bg-gold {
        background-color: var(--c-gold) !important;
    }
    .hover-gold:hover {
        color: var(--c-gold) !important;
        transform: translateX(5px);
    }
    .hover-underline:hover {
        text-decoration: underline !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .uppercase-tracking {
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        font-size: 10px;
    }
    .border-bottom-light {
        border-bottom: 1px solid rgba(0,0,0,0.03) !important;
    }
    .border-gold-hover:hover {
        background-color: var(--c-gold) !important;
        color: var(--c-primary) !important;
        border-color: var(--c-gold) !important;
    }
    .bg-success-subtle { background-color: #e6f7ef; color: #198754 !important; }
    .bg-warning-subtle { background-color: #fff8eb; color: #ffc107 !important; }
    .bg-info-subtle { background-color: #e7f6f8; color: #0dcaf0 !important; }
</style>
@endsection

@section('footer_extras')
<script>
    document.getElementById('passwordUpdateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('updatePassBtn');
        const originalText = btn.innerText;
        btn.innerText = 'Updating...';
        btn.disabled = true;

        fetch('{{ route("profile.change-password") }}', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alertify.success(data.message);
                this.reset();
                bootstrap.Collapse.getInstance(document.getElementById('changePasswordForm')).hide();
            } else {
                if(data.errors) {
                    const firstError = Object.values(data.errors)[0][0];
                    alertify.error(firstError);
                } else {
                    alertify.error(data.message || 'Verification failed');
                }
            }
            btn.innerText = originalText;
            btn.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            alertify.error('An error occurred. Please try again.');
            btn.innerText = originalText;
            btn.disabled = false;
        });
    });
</script>
@endsection