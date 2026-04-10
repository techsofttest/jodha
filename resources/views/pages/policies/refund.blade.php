@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="font-heading mb-4 text-center">Refund Policy</h1>
            <div class="card border-0 shadow-sm p-4 p-lg-5" style="background-color: var(--c-white);">
                <div class="prose">
                    <p class="lead">At Jodha Furniture, customer satisfaction is our priority. If you are not entirely satisfied with your purchase, we're here to help.</p>
                    
                    <h4 class="mt-5 mb-3">1. Return Eligibility</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed porttitor lectus nibh. Nulla porttitor accumsan tincidunt. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.</p>
                    
                    <h4 class="mt-4 mb-3">2. Refund Process</h4>
                    <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur aliquet quam id dui posuere blandit.</p>
                    
                    <h4 class="mt-4 mb-3">3. Damaged Items</h4>
                    <p>Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Donec sollicitudin molestie malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</p>
                    
                    <h4 class="mt-4 mb-3">4. Custom Orders</h4>
                    <p>Quisque velit nisi, pretium ut lacinia in, elementum id enim. Cras ultricies ligula sed magna dictum porta. Vivamus suscipit tortor eget felis porttitor volutpat.</p>
                    
                    <h4 class="mt-4 mb-3">5. Return Shipping</h4>
                    <p>Cras ultricies ligula sed magna dictum porta. Pellentesque in ipsum id orci porta dapibus. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.</p>
                    
                    <h4 class="mt-4 mb-3">6. Contact Us</h4>
                    <p>If you have any questions on how to return your item to us, contact us at <a href="mailto:support@jodhafurniture.com">support@jodhafurniture.com</a>.</p>
                    
                    <p class="mt-5 text-muted small">Last updated: {{ date('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-heading { font-family: var(--f-head); }
    .prose p { margin-bottom: 1.5rem; line-height: 1.8; color: #555; font-family: var(--f-body); }
    .prose h4 { font-family: var(--f-head); color: var(--c-primary); }
</style>
@endsection
