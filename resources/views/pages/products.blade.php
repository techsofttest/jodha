@extends('layouts.app')


@section('content')

  <!-- Products listing -->
    <section class="product-listing-section py-3" style="background-color: var(--c-white);">
        <div class="container">

            <div class="shop-toolbar d-flex justify-content-between align-items-center mb-5 pb-3 pt-3 border-bottom-luxury sticky-top"
                style="top: 0; z-index: 100; background-color: var(--c-white); width: 100%;">

                <div class="d-flex align-items-center gap-2 gap-md-4">
                    <button
                        class="btn btn-link text-decoration-none shadow-none d-flex align-items-center text-uppercase"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#shopFilterOffcanvas"
                        aria-controls="shopFilterOffcanvas"
                        style="font-size: 11px; letter-spacing: 1px; color: var(--c-primary); font-weight: 600; padding: 8px 12px; border: 1px solid #0000002d;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        Filters
                    </button>
                </div>


                <div class="d-flex align-items-center gap-3">

                    <!-- Grid Switcher -->
                    <div class="grid-switcher d-flex align-items-center gap-2 me-lg-4"
                        style="font-family: var(--f-body); letter-spacing: 1px;">

                        <button class="btn grid-btn active" data-layout="standard" title="Standard Grid">
                            <i class="fa-solid fa-grip"></i>
                        </button>

                        <button class="btn grid-btn" data-layout="large" title="Large Grid">
                            <i class="fa-regular fa-square"></i>
                        </button>

                        <button class="btn grid-btn" data-layout="list" title="List View">
                            <i class="fa-solid fa-list"></i>
                        </button>

                    </div>

                    <div class="d-none d-md-flex align-items-center gap-3">
                        <span class="text-uppercase"
                            style="font-size: 11px; letter-spacing: 1px; color: var(--c-primary); font-weight: 600;">Sort
                            By:</span>

                        <div class="dropdown luxury-dropdown">
                            <button
                                class="btn btn-link text-decoration-none p-0 shadow-none d-flex align-items-center justify-content-between"
                                type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="selected-text">Best Selling</span>
                                <i class="fa-solid fa-chevron-down ms-3"
                                    style="font-size: 10px; color: var(--c-gold);"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-0 mt-2"
                                aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item active" href="#" data-value="best-selling">Best Selling</a>
                                </li>
                                <li><a class="dropdown-item" href="#" data-value="a-z">Alphabetically, A-Z</a></li>
                                <li><a class="dropdown-item" href="#" data-value="z-a">Alphabetically, Z-A</a></li>
                                <li><a class="dropdown-item" href="#" data-value="low-high">Price, Low to High</a></li>
                                <li><a class="dropdown-item" href="#" data-value="high-low">Price, High to Low</a></li>
                            </ul>
                        </div>
                        <!-- Grid Switcher -->
                        <!-- <div class="grid-switcher d-none d-lg-flex align-items-center gap-2 me-4">
                            <button class="btn grid-btn" data-cols="6" title="2 Columns">
                                <i class="fa-solid fa-table-columns"></i>
                            </button>
                            <button class="btn grid-btn active" data-cols="4" title="3 Columns">
                                <i class="fa-solid fa-grip"></i>
                            </button>
                            <button class="btn grid-btn" data-cols="12" title="List View">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </div> -->



                    </div>
                </div>
            </div>


            <div class="container-fluid px-4 px-lg-5 py-3 mb-4">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 justify-content-center">

                    <div class="col">
                        <a href="#" class="collection-link">
                            <div class="collection-img-wrapper">
                                <img src="assets\images\categories\homedecor\decor01.jpg" alt="Wall Art">
                            </div>
                            <h3 class="collection-title">Wall Art</h3>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="collection-link">
                            <div class="collection-img-wrapper">
                                <img src="assets\images\categories\homedecor\decor02.jpg" alt="Photo Frames">
                            </div>
                            <h3 class="collection-title">Photo Frames</h3>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="collection-link">
                            <div class="collection-img-wrapper">
                                <img src="assets\images\categories\homedecor\decor03.jpg" alt="Planters">
                            </div>
                            <h3 class="collection-title">Planters</h3>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="collection-link">
                            <div class="collection-img-wrapper">
                                <img src="assets\images\categories\homedecor\decor04.jpg" alt="Vases">
                            </div>
                            <h3 class="collection-title">Vases</h3>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="collection-link">
                            <div class="collection-img-wrapper">
                                <img src="assets\images\categories\homedecor\decor05.jpg" alt="Candle Holders">
                            </div>
                            <h3 class="collection-title">Candle Holders</h3>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="collection-link">
                            <div class="collection-img-wrapper">
                                <img src="assets\images\categories\homedecor\decor06.jpg" alt="Gift Boxes">
                            </div>
                            <h3 class="collection-title">Gift Boxes</h3>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Product Listing -->
            <div class="row g-5">
                <div class="col-lg-12">

                    <div class="row row-cols-2 row-cols-md-4 g-4" id="product-grid">

                        <div class="col product-item">
                            <a href="#" class="product-card card-with-hover text-decoration-none">
                                <div class="product-img-wrapper">
                                    <img src="assets/images/categories/diningroom/dine1.jpg" class="img-fluid w-100"
                                        alt="Dining Table">
                                    <div class="card-hover-actions">
                                        <button class="hover-action-btn" title="Quick View"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                        <button class="hover-action-btn" title="Add to Cart"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3 class="grid-product-title font-marcellus">Jodha Bone Inlay Dining Table : Stripe
                                        : Black & White</h3>
                                    <div class="grid-price-row">
                                        <span class="grid-current-price">₹116,100.00</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col product-item">
                            <a href="#" class="product-card card-with-hover text-decoration-none">
                                <div class="product-img-wrapper">
                                    <img src="assets/images/categories/diningroom/dining01.jpg" class="img-fluid w-100"
                                        alt="Dining Table">
                                    <span class="grid-sale-badge">SALE</span>
                                    <div class="card-hover-actions">
                                        <button class="hover-action-btn" title="Quick View"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                        <button class="hover-action-btn" title="Add to Cart"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3 class="grid-product-title font-marcellus">Jodha Olive Rectangular Dining Table
                                    </h3>
                                    <div class="grid-price-row">
                                        <span class="grid-current-price">₹295,200.00</span>
                                        <span
                                            class="grid-old-price text-muted text-decoration-line-through small ms-2">₹449,999.00</span>
                                        <span class="grid-discount ms-2" style="color: var(--gold);">Save 34%</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col product-item">
                            <a href="#" class="product-card card-with-hover text-decoration-none">
                                <div class="product-img-wrapper">
                                    <img src="https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?q=80&w=600&auto=format&fit=crop"
                                        class="img-fluid w-100" alt="Dining Table">
                                    <span class="grid-sale-badge">SALE</span>
                                    <div class="card-hover-actions">
                                        <button class="hover-action-btn" title="Quick View"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                        <button class="hover-action-btn" title="Add to Cart"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="color-swatches mb-2">
                                        <div class="swatch"
                                            style="background-color: #ff0000; width: 15px; height: 15px; border-radius: 50%; display: inline-block;">
                                        </div>
                                        <div class="swatch"
                                            style="background-color: #0000ff; width: 15px; height: 15px; border-radius: 50%; display: inline-block;">
                                        </div>
                                        <div class="swatch"
                                            style="background-color: #008000; width: 15px; height: 15px; border-radius: 50%; display: inline-block;">
                                        </div>
                                        <div class="swatch"
                                            style="background-color: #dcb881; width: 15px; height: 15px; border-radius: 50%; display: inline-block; border: 1px solid #ccc;">
                                        </div>
                                        <span class="swatch-text small ms-1">+3</span>
                                    </div>
                                    <h3 class="grid-product-title font-marcellus">Jodha Napoleon Bone Inlay Round Dining
                                        Table</h3>
                                    <div class="grid-price-row">
                                        <span class="grid-current-price">₹168,300.00</span>
                                        <span
                                            class="grid-old-price text-muted text-decoration-line-through small ms-2">₹449,999.00</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col product-item">
                            <a href="#" class="product-card card-with-hover text-decoration-none">
                                <div class="product-img-wrapper">
                                    <img src="assets/images/categories/diningroom/dining02.jpg" class="img-fluid w-100"
                                        alt="Dining Table">
                                    <span class="grid-sale-badge">SALE</span>
                                    <div class="card-hover-actions">
                                        <button class="hover-action-btn" title="Quick View"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                        <button class="hover-action-btn" title="Add to Cart"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3 class="grid-product-title font-marcellus">Jodha Targua Dining Table In Bone
                                        Inlay</h3>
                                    <div class="grid-price-row">
                                        <span class="grid-current-price">₹164,700.00</span>
                                        <span
                                            class="grid-old-price text-muted text-decoration-line-through small ms-2">₹449,999.00</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col product-item">
                            <a href="#" class="product-card card-with-hover text-decoration-none">
                                <div class="product-img-wrapper">
                                    <img src="assets/images/categories/diningroom/dining03.jpg" class="img-fluid w-100"
                                        alt="Dining Table">
                                    <span class="grid-sale-badge">SALE</span>
                                    <div class="card-hover-actions">
                                        <button class="hover-action-btn" title="Quick View"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                        <button class="hover-action-btn" title="Add to Cart"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h3 class="grid-product-title font-marcellus">Jodha Pippa Oval Dining Table Medium
                                    </h3>
                                    <div class="grid-price-row">
                                        <span class="grid-current-price">₹148,500.00</span>
                                        <span
                                            class="grid-old-price text-muted text-decoration-line-through small ms-2">₹299,999.00</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="d-flex justify-content-center mt-5 pt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-luxury gap-2">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1"><i
                                            class="fa-solid fa-chevron-left"></i></a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const gridBtns = document.querySelectorAll('.grid-btn');
                    const productGrid = document.getElementById('product-grid');
                    const productItems = document.querySelectorAll('#product-grid .product-item');

                    if (gridBtns.length > 0 && productGrid) {
                        gridBtns.forEach(btn => {
                            btn.addEventListener('click', function (e) {
                                e.preventDefault();
                                gridBtns.forEach(b => b.classList.remove('active'));
                                this.classList.add('active');

                                const layout = this.getAttribute('data-layout');
                                productGrid.classList.remove('list-view');

                                productItems.forEach(item => {
                                    item.classList.remove('col-12', 'col-6', 'col-4', 'col-lg-12', 'col-lg-6', 'col-lg-4');

                                    if (layout === 'list') {
                                        item.classList.add('col-12', 'col-lg-12');
                                        productGrid.classList.add('list-view');
                                    }
                                    else if (layout === 'large') {
                                        item.classList.add('col-12', 'col-lg-6');
                                    }
                                    else if (layout === 'standard') {
                                        item.classList.add('col-6', 'col-lg-4');
                                    }
                                });
                            });
                        });
                    }
                });
            </script>
        </div>
    </section>






     <!-- Filter Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="shopFilterOffcanvas"
        aria-labelledby="shopFilterOffcanvasLabel"
        style="width: 350px; border-right: none; box-shadow: 2px 0 15px rgba(0,0,0,0.05);">

        <div class="offcanvas-header border-bottom"
            style="border-color: rgba(0,0,0,0.08) !important; padding: 1.5rem 2rem;">
            <h5 class="offcanvas-title font-heading mb-0" id="shopFilterOffcanvasLabel"
                style="color: var(--c-primary); font-size: 20px;">Filters</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"
                style="filter: grayscale(1);"></button>
        </div>

        <div class="offcanvas-body custom-scrollbar" style="padding: 2rem;">

            <div class="active-filters-container mb-3 pb-4 border-bottom"
                style="border-color: rgba(0,0,0,0.08) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="filter-title mb-0" style="font-size: 14px;">Applied Filters</h6>
                    <a href="#" id="clear-filters-btn" class="text-muted text-decoration-none"
                        style="font-family: var(--f-body); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Clear
                        All</a>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-0 d-flex align-items-center py-2 px-3"
                        style="background-color: var(--c-linen); color: var(--c-primary); font-family: var(--f-body); font-size: 11px; font-weight: 500; border: 1px solid rgba(0,0,0,0.08);">
                        ₹15,000 - ₹85,000
                        <button type="button" class="btn-close ms-2" aria-label="Remove"
                            style="font-size: 8px; filter: grayscale(1);"></button>
                    </span>
                    <span class="badge rounded-0 d-flex align-items-center py-2 px-3"
                        style="background-color: var(--c-linen); color: var(--c-primary); font-family: var(--f-body); font-size: 11px; font-weight: 500; border: 1px solid rgba(0,0,0,0.08);">
                        4+ Stars
                        <button type="button" class="btn-close ms-2" aria-label="Remove"
                            style="font-size: 8px; filter: grayscale(1);"></button>
                    </span>
                </div>
            </div>

            <!-- Sort By -->
            <div class="active-filters-container mb-3 pb-3 border-bottom"
                style="border-color: rgba(0,0,0,0.08) !important;">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-uppercase"
                        style="font-size: 11px; letter-spacing: 1px; color: var(--c-primary); font-weight: 600;">Sort
                        By:</span>

                    <div class="dropdown luxury-dropdown">
                        <button
                            class="btn btn-link text-decoration-none p-0 shadow-none d-flex align-items-center justify-content-between"
                            type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="selected-text">Best Selling</span>
                            <i class="fa-solid fa-chevron-down ms-3" style="font-size: 10px; color: var(--c-gold);"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-0 mt-2"
                            aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item active" href="#" data-value="best-selling">Best Selling</a></li>
                            <li><a class="dropdown-item" href="#" data-value="a-z">Alphabetically, A-Z</a></li>
                            <li><a class="dropdown-item" href="#" data-value="z-a">Alphabetically, Z-A</a></li>
                            <li><a class="dropdown-item" href="#" data-value="low-high">Price, Low to High</a></li>
                            <li><a class="dropdown-item" href="#" data-value="high-low">Price, High to Low</a></li>
                        </ul>
                    </div>
                </div>
            </div>





            <div class="filter-group mb-5">
                <h6 class="filter-title">Category</h6>
                <ul class="list-unstyled luxury-checkbox-list mt-3">
                    <li>
                        <label class="luxury-checkbox">
                            <input type="checkbox" checked>
                            <span class="checkmark"></span>
                            <span class="label-text d-flex justify-content-between w-100">
                                <span>Armchairs</span>
                                <span class="text-muted" style="font-size: 10px;">(24)</span>
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="luxury-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text d-flex justify-content-between w-100">
                                <span>Accent Chairs</span>
                                <span class="text-muted" style="font-size: 10px;">(18)</span>
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="luxury-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text d-flex justify-content-between w-100">
                                <span>Recliners</span>
                                <span class="text-muted" style="font-size: 10px;">(12)</span>
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="luxury-checkbox">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            <span class="label-text d-flex justify-content-between w-100">
                                <span>Lounge Chairs</span>
                                <span class="text-muted" style="font-size: 10px;">(9)</span>
                            </span>
                        </label>
                    </li>
                </ul>
            </div>

            <div class="filter-group mb-5">
                <h6 class="filter-title">Price Range</h6>

                <div class="price-slider-container mt-4">
                    <div class="multi-range-slider">
                        <input type="range" id="input-left" min="0" max="100000" value="15000">
                        <input type="range" id="input-right" min="0" max="100000" value="85000">
                        <div class="slider-track">
                            <div class="track-fill" id="track-fill"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="price-input-box">
                            <span class="currency">₹</span>
                            <input type="number" id="price-min" value="15000" readonly>
                        </div>
                        <span class="mx-2 text-muted">-</span>
                        <div class="price-input-box">
                            <span class="currency">₹</span>
                            <input type="number" id="price-max" value="85000" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="filter-group mb-5">
                <h6 class="filter-title">Customer Rating</h6>
                <ul class="list-unstyled luxury-checkbox-list mt-3">
                    <li>
                        <label class="luxury-checkbox align-items-center">
                            <input type="checkbox">
                            <span class="checkmark mt-0"></span>
                            <span class="label-text d-flex align-items-center">
                                <div class="d-flex text-gold gap-1 me-2" style="font-size: 12px;">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <span style="font-size: 13px;">5 Stars</span>
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="luxury-checkbox align-items-center">
                            <input type="checkbox" checked>
                            <span class="checkmark mt-0"></span>
                            <span class="label-text d-flex align-items-center">
                                <div class="d-flex text-gold gap-1 me-2" style="font-size: 12px;">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-regular fa-star text-muted opacity-50"></i>
                                </div>
                                <span style="font-size: 13px;">4 Stars & Up</span>
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="luxury-checkbox align-items-center">
                            <input type="checkbox">
                            <span class="checkmark mt-0"></span>
                            <span class="label-text d-flex align-items-center">
                                <div class="d-flex text-gold gap-1 me-2" style="font-size: 12px;">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-regular fa-star text-muted opacity-50"></i>
                                    <i class="fa-regular fa-star text-muted opacity-50"></i>
                                </div>
                                <span style="font-size: 13px;">3 Stars & Up</span>
                            </span>
                        </label>
                    </li>
                </ul>
            </div>

        </div>
    </div>












@endsection