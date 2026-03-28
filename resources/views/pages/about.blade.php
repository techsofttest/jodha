@extends('layouts.app')

@section('content')



<!-- hero section -->
    <section class="about-hero position-relative vh-100 overflow-hidden d-flex align-items-center">

        <div class="hero-bg-fixed">
            <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover shadow-inset">
                <source src="assets/videos/about banner/about-banner1.mp4" type="video/mp4">
            </video>
            <div class="video-overlay"
                style="background: linear-gradient(to bottom, rgba(26, 21, 20, 0.4), rgba(26, 21, 20, 0.7));"></div>
        </div>

        <div class="container position-relative z-2">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center text-white">

                    <span class="text-gold text-uppercase letter-spacing-5 mb-4 d-block animate-reveal"
                        style="font-family: var(--f-body); font-weight: 500; font-size: 13px;">
                        Established 2023 [cite: 120]
                    </span>

                    <h1 class="display-2 font-heading mb-4 animate-reveal delay-1" style="line-height: 1.1;">
                        The Unparalleled <br> Guardian of Grandeur
                    </h1>

                    <div class="mx-auto border-top-gold pt-4 mt-2 animate-reveal delay-2" style="max-width: 600px;">
                        <p class="lead opacity-75 mb-0"
                            style="font-family: var(--f-body); font-weight: 300; letter-spacing: 0.5px;">
                            At Jodha, we believe that furniture should do more than just fill a room—it should transform
                            a space, tell a story, and elevate the atmosphere of a home.
                        </p>
                    </div>

                    <div class="scroll-indicator mt-5 pt-4 animate-bounce">
                        <svg width="24" height="40" viewBox="0 0 24 40" fill="none" stroke="var(--c-gold)"
                            stroke-width="1">
                            <rect x="1" y="1" width="22" height="38" rx="11" />
                            <path d="M12 8V16" stroke-linecap="round" />
                        </svg>
                    </div>

                </div>
            </div>
        </div>
    </section>



    <!-- origin-section -->
    <section class="origin-section py-10" style="background-color: var(--c-linen);">
        <div class="container">

            <div class="row align-items-center gx-lg-5">

                <div class="col-lg-5 mb-5 mb-lg-0">
                    <span class="text-gold text-uppercase letter-spacing-2 mb-3 d-block"
                        style="font-family: var(--f-body); font-weight: 600; font-size: 11px;">
                        Our Story
                    </span>
                    <h2 class="font-heading mb-4" style="color: var(--c-primary); font-size: 42px; line-height: 1.2;">
                        Born from a <br> Simple Frustration
                    </h2>
                    <div class="origin-text-wrapper pe-lg-4">
                        <p class="mb-4"
                            style="font-family: var(--f-body); font-size: 16px; line-height: 1.8; color: var(--c-body);">
                            The idea for Jodha took root from a simple realization: too many homes lacked individuality
                            and personality. We believe that furniture should do more than just fill a
                            room—it should transform a space and elevate the atmosphere of a home.
                        </p>
                        <p class="mb-0"
                            style="font-family: var(--f-body); font-size: 16px; line-height: 1.8; color: var(--c-body);">
                            Established in 2023, Jodha was born out of a shared vision to create furniture that stands
                            out and adds character to every corner. We exist to change the narrative of
                            modern living, one beautifully crafted piece at a time.
                        </p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-8">
                            <div class="origin-img-large overflow-hidden">
                                <img src="{{asset('images\banner\living-room.jpg')}}"
                                    class="w-100 h-100 object-fit-cover hover-zoom" alt="The Vision">
                            </div>
                        </div>
                        <div class="col-4 d-flex flex-column gap-3">
                            <div class="origin-img-small overflow-hidden flex-grow-1">
                                <img src="{{asset('images\banner\living-room2.jpg')}}"
                                    class="w-100 h-100 object-fit-cover hover-zoom" alt="The Craft">
                            </div>
                            <div class="bg-linen p-4 d-flex align-items-center justify-content-center border"
                                style="border-color: rgba(0,0,0,0.05) !important;">
                                <div class="text-center">
                                    <h4 class="font-heading mb-0" style="color: var(--c-gold); font-size: 36px;">2023
                                    </h4>
                                    <span class="small text-uppercase letter-spacing-1 text-muted"
                                        style="font-size: 14px;">The Founding Year</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>





    <!-- story-monumental-section -->
    <section class="story-monumental-section py-10" style="background-color: var(--c-white);">
        <div class="container">

            <div class="row align-items-center mb-10">
                <div class="col-lg-6 mb-5 mb-lg-0 order-2 order-lg-1">
                    <div class="pe-lg-5 text-center text-lg-start">
                        <span class="text-gold text-uppercase letter-spacing-5 mb-3 d-block"
                            style="font-size: 11px; font-weight: 600;">
                            A Monumental Vision
                        </span>
                        <h2 class="font-heading mb-4"
                            style="color: var(--c-primary); font-size: 48px; line-height: 1.1;">
                            Character Over <br> Contentment
                        </h2>
                        <p class="lead-text mb-4"
                            style="font-family: var(--f-body); font-size: 18px; line-height: 1.8; color: var(--c-primary); font-weight: 300;">
                            Jodha was born out of a shared vision: to create furniture that stands out and adds
                            character to every home. At Jodha, we believe that furniture should do more than just fill a
                            room—it should transform a space, tell a story, and elevate the atmosphere of a home.
                        </p>
                        <div class="divider-gold w-25 mb-4 mx-auto mx-lg-0"></div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 mb-5 mb-lg-0">
                    <div class="reveal-img-container shadow-luxury overflow-hidden">
                        <img src="{{asset('images/about-us/jodha2.png')}}" class="w-100 h-100 object-fit-cover hover-zoom"
                            alt="The Vision">
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-10">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="reveal-img-container shadow-luxury overflow-hidden" style="height: 500px;">
                        <img src="{{asset('images/about-us/jodha3.png')}}" class="w-100 h-100 object-fit-cover hover-zoom"
                            alt="Detailed Craftsmanship">
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="ps-lg-5 text-center text-lg-start">
                        <h3 class="font-heading mb-4" style="color: var(--c-primary); font-size: 32px;">The Root of
                            Creation</h3>
                        <p class="mb-4 text-muted"
                            style="font-family: var(--f-body); font-size: 16px; line-height: 1.9;">
                            The idea took root from a simple frustration—seeing too many homes that lacked individuality
                            and personality. Jodha exists to change that, one beautifully crafted piece at a time,
                            combining years of expertise in interior design with a love for craftsmanship.
                        </p>
                        <p class="mb-0 text-muted"
                            style="font-family: var(--f-body); font-size: 16px; line-height: 1.9;">
                            Established in 2023, our mission is simple: to bring exquisite, handcrafted furniture to
                            homes and businesses worldwide.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center pt-5">
                <div class="col-lg-10 text-center">
                    <div class="inlay-specialization p-5 border-delicate" style="background-color: var(--c-linen);">
                        <span class="text-gold text-uppercase letter-spacing-2 d-block mb-3"
                            style="font-size: 10px; font-weight: 700;">Artistry in Detail</span>
                        <h4 class="font-heading mb-4" style="color: var(--c-primary); font-size: 28px;">The Inlay
                            Heritage</h4>
                        <p class="mb-0 mx-auto"
                            style="max-width: 800px; font-family: var(--f-body); font-size: 16px; line-height: 1.8; color: var(--c-body);">
                            Specializing in intricate inlays using mother of pearl, bone, and marble, each of our pieces
                            blends traditional techniques with modern aesthetics, making them not just functional but
                            also works of art. We are committed to continuous research and innovation, ensuring our
                            collections are timeless, yet relevant to modern tastes.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>








    <!-- TRUST SECTION -->
    <section class="trust-section bg-light overflow-hidden pt-5 pb-5">
        <div class="container-fluid p-0">
            <div class="row g-0 align-items-stretch">

                <div class="col-lg-6">
                    <div class="trust-video-wrapper position-relative h-100 w-100">
                        <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover">
                            <source src="{{asset('videos/banner/v1.mp4')}}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-10"></div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="trust-content p-5 p-lg-6 d-flex flex-column justify-content-center h-100">
                        <span class="text-gold text-uppercase letter-spacing-2 text-small mb-2 d-block">The Jodha
                            Standard</span>
                        <h2 class="font-heading display-5 mb-4">We Rethought Royal Living.<br>Starting with Quality.
                        </h2>
                        <p class="text-muted mb-5 lead-sm">
                            Furniture shouldn't just look regal; it should last for generations. We combine
                            centuries-old woodworking techniques with modern modularity.
                        </p>

                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box text-gold">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M12 2L12 22"></path>
                                            <path d="M12 22L7 17"></path>
                                            <path d="M12 22L17 17"></path>
                                            <path d="M12 2L4 12H9L7 17"></path>
                                            <path d="M12 2L20 12H15L17 17"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="font-heading mb-1">Solid Teak Wood</h6>
                                        <p class="text-muted small mb-0">Sourced responsibly.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box text-gold">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                            <polyline points="2 17 12 22 22 17"></polyline>
                                            <polyline points="2 12 12 17 22 12"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="font-heading mb-1">Modular Design</h6>
                                        <p class="text-muted small mb-0">Easy to expand.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box text-gold">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="font-heading mb-1">Free Shipping</h6>
                                        <p class="text-muted small mb-0">White glove delivery.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="icon-box text-gold">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h6 class="font-heading mb-1">10-Year Warranty</h6>
                                        <p class="text-muted small mb-0">Guaranteed quality.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>




    <!-- Trusted Partners -->
    <section class="partners-section ">
        <div class="container-fluid px-0">

            <div class="text-center mb-5">
                <span class="text-gold text-uppercase letter-spacing-3 text-small d-block mb-3">In Collaboration
                    With</span>
                <h2 class="font-heading" style="color: var(--c-primary); font-size: 2.5rem; font-weight: 400;">
                    Our Trusted Partners
                </h2>
            </div>

            <div class="partners-marquee-wrapper pt-4">
                <div class="partners-track">

                    <div class="partners-group">
                        @foreach($partners as $partner)
                        <div class="partner-logo">
                            <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->title }}">
                        </div>
                        @endforeach
                    </div>

                    <div class="partners-group" aria-hidden="true">
                        @foreach($partners as $partner)
                        <div class="partner-logo">
                            <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->title }}">
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </section>





    <!-- Featured In -->
    <section class="featured-in-section">
        <div class="container">

            <div class="text-center mb-5">
                <span class="text-gold text-uppercase letter-spacing-3 text-small d-block mb-3">Featured In</span>
                <h2 class="font-heading" style="color: var(--c-primary); font-size: 2.5rem; font-weight: 400;">
                    Recognition That Matters
                </h2>
            </div>

            <div
                class="row row-cols-2 row-cols-md-4 g-5 mt-5 mb-5 align-items-center justify-content-center text-center">

                @foreach($recognitions as $item)
                <div class="col">
                    <div class="featured-logo">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>




    <!-- REVIEWS SECTION -->
    <section class="reviews-section py-5">
        <div class="container-fluid px-0">

            <div class="text-center mb-5">
                <h4 class="fw-normal mb-1 font-marcellus">Excellent</h4>
                <div class="google-stars mb-1">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-muted small mb-2 font-jost">Based on 24 Reviews</p>
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google"
                    width="80">
            </div>

            <div class="reviews-carousel-wrapper">
                <button class="review-control prev" id="prevBtn"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="review-control next" id="nextBtn"><i class="fa-solid fa-chevron-right"></i></button>

                <div class="reviews-grab-container" id="scrollContainer">
                    <div class="reviews-track" id="reviewTrack">
                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">A</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Ananya Sharma</h6>
                                        <span class="review-date">Feb 14, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">The Mother of Pearl tray is the center of attention in my
                                living room. The iridescence is even more beautiful in person than on the website.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">R</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Rajesh Iyer</h6>
                                        <span class="review-date">Jan 28, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">Incredible attention to detail. I ordered a custom bedside
                                table and the bone inlay patterns are perfectly symmetrical. Worth every penny.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">M</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Meera Kapoor</h6>
                                        <span class="review-date">Mar 02, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">Packaging was extremely secure. I was worried about the
                                mirror frame traveling so far, but it arrived in pristine condition. Highly recommend!
                            </p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">V</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Vikram Seth</h6>
                                        <span class="review-date">Feb 22, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">You can really feel the 'individually handmade' aspect of
                                these pieces. There’s a soul to this furniture that mass-produced items lack.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">P</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Priya Nair</h6>
                                        <span class="review-date">Jan 05, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">Absolutely love the ethically sourced mission of Jodha. It
                                makes owning such a luxury item feel even better. The quality is world-class.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">A</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Arjun Das</h6>
                                        <span class="review-date">Dec 20, 2025</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">The custom floral pattern on my tissue box holder is a work
                                of art. The artisans at Jodha are truly masters of their craft.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">S</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Sneha Gupta</h6>
                                        <span class="review-date">Feb 09, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">A true statement piece! Every guest who comes over asks
                                about our new dining table. It has completely transformed our space.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">R</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Rohan Mehta</h6>
                                        <span class="review-date">Jan 15, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">The customer support was helpful throughout the design
                                process. They shared progress photos of my chest of drawers. Exceptional service.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">K</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Kavita Rao</h6>
                                        <span class="review-date">Mar 10, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">Elegant finish and very sturdy. You can tell this isn't
                                just furniture; it’s an heirloom that will be in our family for generations.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">A</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Aditya Verma</h6>
                                        <span class="review-date">Dec 12, 2025</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">Fast shipping and the product matches the photos exactly.
                                Often bone inlay looks different in person, but Jodha's quality is consistent.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">N</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Neha Reddy</h6>
                                        <span class="review-date">Feb 28, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">I ordered the serving platters for a dinner party and they
                                were a huge hit. They add such a sophisticated touch to the table setting.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="user-info">
                                    <div class="avatar">S</div>
                                    <div>
                                        <h6 class="m-0 font-jost">Sanjay Pillai</h6>
                                        <span class="review-date">Jan 30, 2026</span>
                                    </div>
                                </div>
                                <img src="{{asset('images\icons\icons_google.svg')}}" alt="G" width="18">
                            </div>
                            <div class="review-stars">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <p class="review-text font-jost">The depth of the design in the bone inlay is remarkable.
                                It’s clear these are made by artisans who take immense pride in their heritage.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>






@endsection