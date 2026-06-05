@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="font-heading mb-4 text-center">Privacy Policy</h1>
            <div class="card border-0 shadow-sm p-4 p-lg-5" style="background-color: var(--c-white);">
                <div class="prose">

               <p class="lead">
    At Jodha, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy outlines how we collect, use, disclose, and protect the information you provide to us when you use our website or interact with us in any other way. By accessing or using our services, you agree to the terms of this Privacy Policy.
</p>

<h4 class="mt-5 mb-3">Information We Collect</h4>
<p>When you visit our website or communicate with us through email or phone, we may collect various types of information, including:</p>
<ul>
    <li><strong>Personal Information:</strong> Your name, email address, phone number, and postal address, which you provide to us when you make a purchase, create an account, or sign up for our newsletter.</li>
    <li><strong>Payment Information:</strong> Such as credit card details, which you provide when making a purchase through our website. Please note that we do not store your payment information; it is securely processed by our payment service providers.</li>
    <li><strong>Device and Usage Information:</strong> Such as your IP address, browser type, operating system, and other technical information collected automatically when you visit our website.</li>
    <li><strong>Cookies:</strong> We use cookies and similar tracking technologies to enhance your experience on our website, analyze trends, and gather information about how you interact with our site.</li>
</ul>

<h4 class="mt-4 mb-3">How We Use Your Information</h4>
<p>We use the information we collect for various purposes, including:</p>
<ul>
    <li>Providing and improving our products and services.</li>
    <li>Processing and fulfilling your orders.</li>
    <li>Communicating with you about your orders, inquiries, and other requests.</li>
    <li>Sending you promotional offers, newsletters, and other marketing communications.</li>
    <li>Customizing your experience on our website and optimizing our site's performance.</li>
    <li>Complying with legal obligations and enforcing our terms and policies.</li>
</ul>

<h4 class="mt-4 mb-3">How We Share Your Information</h4>
<p>We may share your personal information with third parties in the following circumstances:</p>
<ul>
    <li><strong>Service Providers:</strong> We may share your information with third-party service providers who help us operate our business, such as payment processors, shipping carriers, and IT service providers.</li>
    <li><strong>Legal Compliance:</strong> We may disclose your information when required by law or in response to lawful requests from government authorities or law enforcement agencies.</li>
    <li><strong>Business Transfers:</strong> If we are involved in a merger, acquisition, or sale of assets, your information may be transferred to the acquiring entity as part of the transaction.</li>
    <li><strong>With Your Consent:</strong> We may share your information with third parties if you give us consent to do so.</li>
</ul>

<h4 class="mt-4 mb-3">Your Choices</h4>
<p>You have the following choices regarding your personal information:</p>
<ul>
    <li>You can update or correct your personal information by logging into your account on our website or contacting us directly.</li>
    <li>You can opt out of receiving marketing communications from us by following the unsubscribe instructions provided in the emails we send you.</li>
    <li>You can disable cookies in your browser settings, although this may affect your ability to access certain features of our website.</li>
</ul>

<h4 class="mt-4 mb-3">Data Security</h4>
<p>We take the security of your personal information seriously and implement appropriate technical and organizational measures to protect it against unauthorized access, disclosure, alteration, or destruction.</p>

<h4 class="mt-4 mb-3">Children's Privacy</h4>
<p>Our website and services are not intended for children under the age of 18, and we do not knowingly collect personal information from individuals under 18 years of age.</p>

<h4 class="mt-4 mb-3">Data Retention</h4>
<p>We will retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law. When we no longer need to retain your information, we will securely dispose of it in accordance with our data retention policies.</p>

<h4 class="mt-4 mb-3">International Transfers</h4>
<p>If you are accessing our website from outside of India, please be aware that your information may be transferred to, stored, and processed in India or other countries where our servers are located and our central database is operated. By using our website or providing us with your information, you consent to the transfer of your information to India and other countries as described in this Privacy Policy.</p>

<h4 class="mt-4 mb-3">Third-Party Links</h4>
<p>Our website may contain links to third-party websites or services that are not owned or controlled by Jodha. We are not responsible for the privacy practices or content of these third-party sites. We encourage you to review the privacy policies of those sites before providing any personal information.</p>

<h4 class="mt-4 mb-3">Consent</h4>
<p>By using our website or providing us with your personal information, you consent to the collection, use, and sharing of your information as described in this Privacy Policy.</p>

<h4 class="mt-4 mb-3">Your Rights</h4>
<p>Depending on your jurisdiction, you may have certain rights regarding your personal information, such as the right to access, correct, or delete your information, the right to object to the processing of your information, and the right to data portability. If you would like to exercise any of these rights, please contact us using the information provided in this Privacy Policy.</p>

<h4 class="mt-4 mb-3">Changes to This Privacy Policy</h4>
<p>We may update this Privacy Policy occasionally to reflect changes in our practices or legal requirements. We will notify you of any material changes by posting the updated Privacy Policy on our website.</p>

<h4 class="mt-4 mb-3">Contact Us</h4>
<p>If you have any questions or concerns about this Privacy Policy or our privacy practices, you can contact us at:</p>

<p>
    <strong>Jodha</strong><br>
    8th Cross, Street B,<br>
    Ambikapuram Rd, Panampilly Nagar,<br>
    Ernakulam, Kerala 682036<br><br>

    <strong>Email:</strong> business@jodhafurniture.com<br>
    <strong>Phone:</strong> +91 98955 99002
</p>


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
