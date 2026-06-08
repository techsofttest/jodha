@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="font-heading mb-4 text-center">Shipping Policy</h1>
            <div class="card border-0 shadow-sm p-4 p-lg-5" style="background-color: var(--c-white);">
                <div class="prose">
                    <p class="lead">We deliver our high-quality furniture across India and select international locations with care.</p>
                    
                    <h4 class="mt-5 mb-3">Ashborn Furnitures Delivery Policy</h4>
                    <p>At Ashborn Furniture, we take pride in delivering beautifully crafted, 100% handmade and handcrafted inlay furniture that exemplifies pure craftsmanship. Due to the intricate nature of our work, delivery timelines vary depending on the type of product ordered.</p>
                    
                    <h4 class="mt-4 mb-3">Delivery Timeframes</h4>
                    <p>
                    
                    <b>Furniture Pieces:</b><br>
Our bespoke furniture pieces require careful attention to detail. Please allow 30-45 days for the crafting and delivery of these items within India.
<br>
<b>Smaller Pieces & Home Decor Items:</b><br>
For smaller items such as home accessories, the delivery time is less than 20 days within India.

<b>International Shipments:</b><br>
For export orders, please allow 45 days for the crafting period. The transportation time will vary depending on the destination.    
                    
                    </p>
                    
                    <h4 class="mt-4 mb-3">Packaging</h4>
                    <p>
                    To ensure the safe arrival of your order:<br>
                    <b>Home Accessories:</b>
                    All home accessories are packed in eco-friendly, state-of-the-art packaging with extra cushioning to minimize any risk of damage.<br>
                    <b>Furniture Pieces:</b><br>
Furniture pieces are securely packed in wooden crates to ensure zero damage during transit.
                    </p>
                    
                    <h4 class="mt-4 mb-3">Delays & Damages</h4>
                    <p>
                    <b>Delays:</b>
                    In the rare event of a delay, we will notify you promptly and include a complimentary gift with your order as a token of our appreciation for your patience.<br>

                    <b>Damaged Products:</b><br>
If your product arrives damaged and cannot be amended, we will arrange for a replacement at no additional cost.


                    </p>
                    
                    <h4 class="mt-4 mb-3">Custom Orders</h4>
                    <p>We welcome customized orders to create something truly unique for your space. If you're interested in a custom piece, please reach out to us at business@jodhafurniture.com or fill out the customization form on our website. Our team will get in touch with you to bring your vision to life.</p>
                    
                    <p>Thank you for choosing Ashborn Furniture!</p>

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
