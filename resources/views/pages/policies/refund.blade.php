@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="font-heading mb-4 text-center">Refund Policy</h1>
            <div class="card border-0 shadow-sm p-4 p-lg-5" style="background-color: var(--c-white);">
                <div class="prose">
                
                <p>
                At Ashborn Furniture, customer satisfaction is our priority. Our Exchange, Return, and Refund Policy is designed to ensure a smooth and transparent shopping experience. We are committed to providing fair and hassle-free support whenever you need assistance with your purchase.
Exchange Policy
We understand that occasionally a product may not meet your expectations or may arrive with an issue. In such cases, we offer a simple exchange process to help resolve the concern efficiently.
Eligibility:
You are eligible for an exchange if:
•	The product received is damaged or defective 
•	The item delivered is different from what was ordered 
Timeframe:
Exchange requests must be raised within 7 days of receiving the order. Requests made after this period will not be accepted.
How to Request an Exchange:
To initiate an exchange, please contact our customer support team through:
•	Email: ashbornfurniture@gmail.com 
•	Phone: +91 98955 99002 
Kindly share your order details along with clear photographs showing the issue.
Verification Process:
Our team will review and verify the request. Once approved, the exchange will be arranged at no additional cost.
Conditions:
•	The product must be unused 
•	It should be returned in its original packaging 
•	Original invoice or proof of purchase must be provided 
AshbornFurniture reserves the right to decline exchange requests if these conditions are not met.
</p>


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
