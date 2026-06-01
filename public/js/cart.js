/**
 * Jodha Cart - AJAX Cart Management
 */
const JodhaCart = {

    /**
     * Initialize cart on page load
     */
    init() {
        this.loadCart();
        this.bindCartIcon();
        this.bindQuickAdd();
        this.bindQuickView();
    },

    /**
     * Bind quick add to cart buttons (+ button on product cards)
     */
    bindQuickAdd() {
        document.body.addEventListener('click', async (e) => {
            const btn = e.target.closest('.js-add-to-cart-btn');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = btn.dataset.productId;
            const hasVariants = btn.dataset.hasVariants === 'true';

            if (!hasVariants) {
                // Add directly to cart
                this.addToCart(productId, 1);
            } else {
                // Open variant selector popup
                this.openVariantModal(productId);
            }
        });
    },

    /**
     * Bind quick view buttons (magnifier icon on product cards)
     */
    bindQuickView() {
        document.body.addEventListener('click', async (e) => {
            const btn = e.target.closest('.js-quick-view-btn');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = btn.dataset.productId;
            if (productId) {
                this.openQuickViewModal(productId);
            }
        });
    },

    /**
     * Open the full Quick View detail modal
     */
    async openQuickViewModal(productId) {
        const modalEl = document.getElementById('quickViewDetailModal');
        if (!modalEl) return;

        const modalBody = document.getElementById('quickViewDetailBody');
        if (!modalBody) return;

        // Show loading spinner
        modalBody.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-dark" role="status" style="width: 2.5rem; height: 2.5rem; border-width: 0.2em;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        try {
            const res = await fetch(`/products/${productId}/quick-info`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            if (data.success) {
                this.renderQuickViewContent(data.product, modalEl, modal);
            } else {
                modalBody.innerHTML = `<div class="alert alert-danger font-marcellus text-center">Failed to load product details.</div>`;
            }
        } catch (err) {
            console.error('Error fetching quick view info:', err);
            modalBody.innerHTML = `<div class="alert alert-danger font-marcellus text-center">Something went wrong. Please try again.</div>`;
        }
    },

    /**
     * Render full product detail content inside the Quick View modal
     */
    renderQuickViewContent(product, modalEl, modal) {
        const modalBody = document.getElementById('quickViewDetailBody');
        if (!modalBody) return;

        // Build gallery images array (main + additional)
        let allImages = [product.prod_image];
        if (product.images && product.images.length > 0) {
            product.images.forEach(img => allImages.push(img.image_path));
        }

        // Gallery thumbnails HTML
        const thumbsHtml = allImages.map((img, i) => `
            <div class="qv-thumb ${i === 0 ? 'active' : ''}" data-index="${i}" style="width: 60px; height: 70px; flex-shrink: 0; cursor: pointer; border: 2px solid ${i === 0 ? 'var(--c-primary, #222)' : 'transparent'}; transition: border-color 0.2s;">
                <img src="${img}" alt="${product.prod_name}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null;this.src='images/placeholder.png';">
            </div>
        `).join('');

        // Colors HTML
        let colorsHtml = '';
        if (product.colors && product.colors.length > 0) {
            colorsHtml = `
                <div class="mb-4">
                    <label class="text-uppercase mb-2 d-block" style="font-size: 11px; font-weight: 600; letter-spacing: 1.5px; color: var(--c-primary);">Colors</label>
                    <div id="qvColorPills" class="d-flex flex-wrap gap-2">
                        ${product.colors.map((color, index) => `
                            <button type="button" class="qv-color-pill btn-color-pill"
                                    data-color-id="${color.id}"
                                    data-color-name="${color.color_name}"
                                    title="${color.color_name}"
                                    style="background-color: transparent; color: #222; border: 2px solid ${index === 0 ? 'var(--c-primary)' : '#bbb'}; font-weight: ${index === 0 ? '600' : 'normal'}; padding: 6px 14px; border-radius: 20px; font-size: 12px; transition: all 0.2s ease; cursor: pointer;">
                                ${color.color_name}
                            </button>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        // Sizes HTML
        let sizesHtml = '';
        if (product.sizes && product.sizes.length > 0) {
            sizesHtml = `
                <div class="mb-4">
                    <label class="text-uppercase mb-2 d-block" style="font-size: 11px; font-weight: 600; letter-spacing: 1.5px; color: var(--c-primary);">Sizes</label>
                    <select id="qvSizeSelect" class="form-select rounded-0 border-dark" style="width: auto; min-width: 150px; font-size: 13px; font-weight: 500; box-shadow: none;">
                        ${product.sizes.map((size, index) => `
                            <option value="${size.id}" data-price="${size.offer_price || size.price}" ${index === 0 ? 'selected' : ''}>
                                ${size.size}
                            </option>
                        `).join('')}
                    </select>
                </div>
            `;
        }

        // Description accordion
        let descriptionHtml = '';
        if (product.prod_description) {
            descriptionHtml = `
                <div class="accordion-item" style="border: none; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qvCollapseDesc" style="background: transparent; box-shadow: none; padding: 12px 0; font-family: var(--f-body); font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--c-primary);">
                            Product Details
                        </button>
                    </h2>
                    <div id="qvCollapseDesc" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted" style="font-family: var(--f-body); font-size: 13px; line-height: 1.8; padding: 0 0 12px;">
                            ${product.prod_description}
                        </div>
                    </div>
                </div>
            `;
        }

        // Material accordion
        let materialHtml = '';
        if (product.prod_material || (product.material && product.material.name)) {
            materialHtml = `
                <div class="accordion-item" style="border: none; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qvCollapseMaterial" style="background: transparent; box-shadow: none; padding: 12px 0; font-family: var(--f-body); font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--c-primary);">
                            Materials & Care
                        </button>
                    </h2>
                    <div id="qvCollapseMaterial" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted" style="font-family: var(--f-body); font-size: 13px; line-height: 1.8; padding: 0 0 12px;">
                            ${product.material ? `<p class="mb-2"><strong>${product.material.name}</strong></p>` : ''}
                            ${product.prod_material || ''}
                        </div>
                    </div>
                </div>
            `;
        }

        // Measurements accordion
        let measurementsHtml = '';
        if (product.prod_measurements) {
            measurementsHtml = `
                <div class="accordion-item" style="border: none; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qvCollapseMeasure" style="background: transparent; box-shadow: none; padding: 12px 0; font-family: var(--f-body); font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--c-primary);">
                            Measurements
                        </button>
                    </h2>
                    <div id="qvCollapseMeasure" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted" style="font-family: var(--f-body); font-size: 13px; line-height: 1.8; padding: 0 0 12px;">
                            ${product.prod_measurements}
                        </div>
                    </div>
                </div>
            `;
        }

        const hasAccordions = descriptionHtml || materialHtml || measurementsHtml;

        modalBody.innerHTML = `
            <div class="row g-4">
                <!-- Left: Image Gallery -->
                <div class="col-lg-6">
                    <div class="qv-gallery">
                        <div class="qv-main-image mb-3" style="width: 100%; aspect-ratio: 3/4; background-color: var(--c-linen, #f5f0ea); overflow: hidden;">
                            <img id="qvMainImg" src="${allImages[0]}" alt="${product.prod_name}" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.3s ease;" onerror="this.onerror=null;this.src='images/placeholder.png';">
                        </div>
                        ${allImages.length > 1 ? `
                            <div class="qv-thumbs d-flex gap-2 overflow-auto" style="scrollbar-width: none;">
                                ${thumbsHtml}
                            </div>
                        ` : ''}
                    </div>
                </div>

                <!-- Right: Product Info -->
                <div class="col-lg-6">
                    <div class="qv-info-panel">
                        ${product.prod_sku_code ? `<span class="text-muted d-block mb-2" style="font-family: var(--f-body); font-size: 11px; letter-spacing: 1px;">SKU: ${product.prod_sku_code}</span>` : ''}

                        <h2 class="font-marcellus mb-3" style="font-size: 1.6rem; line-height: 1.3; color: var(--c-primary);">${product.prod_name}</h2>

                        <!-- Price Block -->
                        <div class="mb-4 pb-3" style="border-bottom: 1px solid rgba(0,0,0,0.08);">
                            <div class="d-flex align-items-center gap-3">
                                <span id="qvCurrentPrice" class="fs-4 fw-bold" style="color: var(--c-primary);"></span>
                                <span id="qvOldPrice" class="text-decoration-line-through text-muted" style="font-size: 15px;"></span>
                                <span id="qvSaveBadge" class="badge bg-gold text-dark rounded-0 px-2 py-1" style="font-size: 10px; letter-spacing: 1px; display: none;"></span>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size: 11px;">Inclusive of all taxes. Shipping calculated at checkout.</p>
                        </div>

                        ${colorsHtml}
                        ${sizesHtml}

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label class="text-uppercase mb-2 d-block" style="font-size: 11px; font-weight: 600; letter-spacing: 1.5px; color: var(--c-primary);">Quantity</label>
                            <div class="qty-selector d-inline-flex align-items-center justify-content-between">
                                <button type="button" class="btn-qty" id="qvQtyMinus">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                </button>
                                <input class="qty-input text-center" min="1" name="quantity" value="1" type="number" id="qvQuantity">
                                <button type="button" class="btn-qty" id="qvQtyPlus">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column gap-2 mb-4">
                            <button type="button" class="btn-luxury-solid w-100 font-marcellus fs-6" id="qvAddToCart" style="height: 48px;">Add to Cart</button>
                            <button type="button" class="btn-luxury-outline w-100 font-marcellus fs-6" id="qvBuyNow" style="height: 48px;">Buy Now</button>
                        </div>

                        <!-- View Full Details Link -->
                        ${product.url ? `
                            <div class="text-center mb-4">
                                <a href="${product.url}" class="text-decoration-underline" style="font-family: var(--f-body); font-size: 12px; letter-spacing: 1px; color: var(--c-primary); text-transform: uppercase; font-weight: 500;">View Full Details →</a>
                            </div>
                        ` : ''}

                        <!-- Accordions -->
                        ${hasAccordions ? `
                            <div class="accordion" id="qvAccordion" style="border-top: 1px solid rgba(0,0,0,0.08);">
                                ${descriptionHtml}
                                ${materialHtml}
                                ${measurementsHtml}
                            </div>
                        ` : ''}

                        <!-- Perks -->
                        <div class="mt-4 pt-3" style="border-top: 1px solid rgba(0,0,0,0.08);">
                            <div class="d-flex align-items-center mb-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="me-2 flex-shrink-0"><rect x="3" y="8" width="18" height="4" rx="1" ry="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/></svg>
                                <span style="font-family: var(--f-body); font-size: 11px; color: var(--c-primary); font-weight: 500;">White Glove Delivery</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="me-2 flex-shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <span style="font-family: var(--f-body); font-size: 11px; color: var(--c-primary); font-weight: 500;">Eco-Certified Materials</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="me-2 flex-shrink-0"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <span style="font-family: var(--f-body); font-size: 11px; color: var(--c-primary); font-weight: 500;">Lifetime Service Warranty</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // --- Wire up interactivity ---

        // Price display helper
        const updatePrice = (price, salePrice, offerPct) => {
            const cur = document.getElementById('qvCurrentPrice');
            const old = document.getElementById('qvOldPrice');
            const badge = document.getElementById('qvSaveBadge');
            const fmt = (v) => parseFloat(v).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            if (salePrice && parseFloat(price) > parseFloat(salePrice)) {
                cur.textContent = `₹${fmt(salePrice)}`;
                old.textContent = `₹${fmt(price)}`;
                old.style.display = 'inline';
                if (offerPct > 0) {
                    badge.textContent = `SAVE ${offerPct}%`;
                    badge.style.display = 'inline-block';
                } else badge.style.display = 'none';
            } else {
                cur.textContent = `₹${fmt(salePrice || price)}`;
                old.style.display = 'none';
                badge.style.display = 'none';
            }
        };

        let selectedColorId = product.colors && product.colors.length > 0 ? product.colors[0].id : null;
        let selectedSizeId = product.sizes && product.sizes.length > 0 ? product.sizes[0].id : null;

        // Set initial price
        if (selectedSizeId && product.sizes.length > 0) {
            const sz = product.sizes[0];
            updatePrice(sz.price, sz.offer_price, sz.offer);
        } else {
            updatePrice(product.prod_price, product.prod_sale_price, product.offer_percentage);
        }

        // Thumbnail click
        const thumbs = modalBody.querySelectorAll('.qv-thumb');
        const mainImg = document.getElementById('qvMainImg');
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function () {
                const idx = parseInt(this.dataset.index);
                if (mainImg && allImages[idx]) {
                    mainImg.style.opacity = '0';
                    setTimeout(() => {
                        mainImg.src = allImages[idx];
                        mainImg.style.opacity = '1';
                    }, 150);
                }
                thumbs.forEach(t => t.style.borderColor = 'transparent');
                this.style.borderColor = 'var(--c-primary, #222)';
            });
        });

        // Color pills
        const colorPills = modalBody.querySelectorAll('.qv-color-pill');
        colorPills.forEach(pill => {
            pill.addEventListener('click', function () {
                selectedColorId = this.dataset.colorId;
                colorPills.forEach(x => { x.style.borderColor = '#bbb'; x.style.fontWeight = 'normal'; });
                this.style.borderColor = 'var(--c-primary)';
                this.style.fontWeight = '600';
            });
        });

        // Size selector
        const sizeSelect = document.getElementById('qvSizeSelect');
        if (sizeSelect) {
            sizeSelect.addEventListener('change', function () {
                selectedSizeId = this.value;
                const sz = product.sizes.find(s => s.id == selectedSizeId);
                if (sz) updatePrice(sz.price, sz.offer_price, sz.offer);
            });
        }

        // Quantity buttons
        const qtyInput = document.getElementById('qvQuantity');
        document.getElementById('qvQtyMinus')?.addEventListener('click', () => { if (qtyInput && parseInt(qtyInput.value) > 1) qtyInput.value = parseInt(qtyInput.value) - 1; });
        document.getElementById('qvQtyPlus')?.addEventListener('click', () => { if (qtyInput) qtyInput.value = parseInt(qtyInput.value) + 1; });

        // Add to Cart
        document.getElementById('qvAddToCart')?.addEventListener('click', async () => {
            if (product.colors && product.colors.length > 0 && !selectedColorId) { this.showToast('Please select a color', 'error'); return; }
            if (product.sizes && product.sizes.length > 0 && !selectedSizeId) { this.showToast('Please select a size', 'error'); return; }
            const qty = parseInt(qtyInput?.value) || 1;
            modal.hide();
            await this.addToCart(product.id, qty, selectedSizeId || null, selectedColorId || null);
        });

        // Buy Now
        document.getElementById('qvBuyNow')?.addEventListener('click', async () => {
            if (product.colors && product.colors.length > 0 && !selectedColorId) { this.showToast('Please select a color', 'error'); return; }
            if (product.sizes && product.sizes.length > 0 && !selectedSizeId) { this.showToast('Please select a size', 'error'); return; }
            const qty = parseInt(qtyInput?.value) || 1;
            modal.hide();
            await this.buyNow(product.id, qty, selectedSizeId || null, selectedColorId || null);
        });
    },

    /**
     * Open dynamic variant selector modal
     */
    async openVariantModal(productId) {
        const modalEl = document.getElementById('quickVarModal');
        if (!modalEl) return;

        const modalBody = document.getElementById('quickVarModalBody');
        if (!modalBody) return;

        // Show elegant loading spinner
        modalBody.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-dark" role="status" style="width: 2.5rem; height: 2.5rem; border-width: 0.2em;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        try {
            const res = await fetch(`/products/${productId}/quick-info`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            if (data.success) {
                this.renderVariantModalContent(data.product, modalEl, modal);
            } else {
                modalBody.innerHTML = `<div class="alert alert-danger font-marcellus text-center">Failed to load product details.</div>`;
            }
        } catch (err) {
            console.error('Error fetching quick info:', err);
            modalBody.innerHTML = `<div class="alert alert-danger font-marcellus text-center">Something went wrong. Please try again.</div>`;
        }
    },

    /**
     * Render the variant selector modal content and handle user selection/actions
     */
    renderVariantModalContent(product, modalEl, modal) {
        const modalBody = document.getElementById('quickVarModalBody');
        if (!modalBody) return;

        // Colors pills html
        let colorsHtml = '';
        if (product.colors && product.colors.length > 0) {
            colorsHtml = `
                <div class="mb-4">
                    <label class="text-uppercase mb-2 d-block" style="font-size: 11px; font-weight: 600; letter-spacing: 1.5px; color: var(--c-primary);">Colors</label>
                    <div id="quickModalColorPills" class="d-flex flex-wrap gap-2">
                        ${product.colors.map((color, index) => `
                            <button type="button" class="quick-color-pill btn-color-pill" 
                                    data-color-id="${color.id}" 
                                    data-color-name="${color.color_name}" 
                                    title="${color.color_name}" 
                                    style="background-color: transparent; color: #222; border: 2px solid ${index === 0 ? 'var(--c-primary)' : '#bbb'}; font-weight: ${index === 0 ? '600' : 'normal'}; padding: 6px 14px; border-radius: 20px; font-size: 12px; transition: all 0.2s ease;">
                                ${color.color_name}
                            </button>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        // Sizes selection html
        let sizesHtml = '';
        if (product.sizes && product.sizes.length > 0) {
            sizesHtml = `
                <div class="mb-4">
                    <label class="text-uppercase mb-2 d-block" style="font-size: 11px; font-weight: 600; letter-spacing: 1.5px; color: var(--c-primary);">Sizes</label>
                    <select id="quickModalSizeSelect" class="form-select rounded-0 border-dark" style="width: 100%; font-size: 13px; font-weight: 500; padding: 10px 15px; box-shadow: none;">
                        ${product.sizes.map((size, index) => `
                            <option value="${size.id}" data-price="${size.offer_price || size.price}" ${index === 0 ? 'selected' : ''}>
                                ${size.size}
                            </option>
                        `).join('')}
                    </select>
                </div>
            `;
        }

        modalBody.innerHTML = `
            <div class="row g-4 align-items-center">
                
                <div class="col-md-12 d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="font-marcellus mb-2" style="font-size: 20px; line-height: 1.3; color: var(--c-primary);">${product.prod_name}</h3>
                        
                        <div class="quick-modal-price-block mb-4 pb-3 border-bottom-delicate">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span id="quickModalCurrentPrice" class="fs-4 fw-bold" style="color: var(--c-primary);"></span>
                                <span id="quickModalOldPrice" class="text-decoration-line-through text-muted" style="font-size: 15px;"></span>
                                <span id="quickModalSaveBadge" class="badge bg-gold text-dark rounded-0 px-2 py-1" style="font-size: 10px; letter-spacing: 1px; display: none;">SAVE</span>
                            </div>
                        </div>

                        ${colorsHtml}
                        ${sizesHtml}
                    </div>

                    <div class="d-flex flex-column gap-2 mt-3">
                        <button type="button" class="btn-luxury-solid w-100 font-marcellus fs-6" id="quickModalAddToCart" style="height: 48px;">
                            Add to Cart
                        </button>
                        <button type="button" class="btn-luxury-outline w-100 font-marcellus fs-6" id="quickModalBuyNow" style="height: 48px;">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Price display logic helper
        const updatePriceDisplay = (price, salePrice, offerPercentage) => {
            const currentEl = document.getElementById('quickModalCurrentPrice');
            const oldEl = document.getElementById('quickModalOldPrice');
            const badgeEl = document.getElementById('quickModalSaveBadge');

            if (salePrice && parseFloat(price) > parseFloat(salePrice)) {
                currentEl.textContent = `₹${parseFloat(salePrice).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                oldEl.textContent = `₹${parseFloat(price).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                oldEl.style.display = 'inline';
                if (offerPercentage > 0) {
                    badgeEl.textContent = `SAVE ${offerPercentage}%`;
                    badgeEl.style.display = 'inline-block';
                } else {
                    badgeEl.style.display = 'none';
                }
            } else {
                currentEl.textContent = `₹${parseFloat(price || salePrice).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                oldEl.style.display = 'none';
                badgeEl.style.display = 'none';
            }
        };

        let selectedColorId = product.colors && product.colors.length > 0 ? product.colors[0].id : null;
        let selectedSizeId = product.sizes && product.sizes.length > 0 ? product.sizes[0].id : null;

        // Initialize display prices
        if (selectedSizeId) {
            const sizeModel = product.sizes[0];
            updatePriceDisplay(sizeModel.price, sizeModel.offer_price, sizeModel.offer);
        } else {
            updatePriceDisplay(product.prod_price, product.prod_sale_price, product.offer_percentage);
        }

        // Color pills event bindings
        const colorPills = modalBody.querySelectorAll('.quick-color-pill');
        colorPills.forEach(pill => {
            pill.addEventListener('click', function () {
                selectedColorId = this.dataset.colorId;
                colorPills.forEach(x => {
                    x.style.borderColor = '#bbb';
                    x.style.fontWeight = 'normal';
                });
                this.style.borderColor = 'var(--c-primary)';
                this.style.fontWeight = '600';
            });
        });

        // Size selector event bindings
        const sizeSelect = document.getElementById('quickModalSizeSelect');
        if (sizeSelect) {
            sizeSelect.addEventListener('change', function () {
                selectedSizeId = this.value;
                const sizeModel = product.sizes.find(s => s.id == selectedSizeId);
                if (sizeModel) {
                    updatePriceDisplay(sizeModel.price, sizeModel.offer_price, sizeModel.offer);
                }
            });
        }

        // Add to Cart
        const addBtn = document.getElementById('quickModalAddToCart');
        addBtn.addEventListener('click', async () => {
            if (product.colors && product.colors.length > 0 && !selectedColorId) {
                this.showToast('Please select a color', 'error');
                return;
            }
            if (product.sizes && product.sizes.length > 0 && !selectedSizeId) {
                this.showToast('Please select a size', 'error');
                return;
            }

            modal.hide();
            await this.addToCart(product.id, 1, selectedSizeId || null, selectedColorId || null);
        });

        // Buy Now
        const buyBtn = document.getElementById('quickModalBuyNow');
        buyBtn.addEventListener('click', async () => {
            if (product.colors && product.colors.length > 0 && !selectedColorId) {
                this.showToast('Please select a color', 'error');
                return;
            }
            if (product.sizes && product.sizes.length > 0 && !selectedSizeId) {
                this.showToast('Please select a size', 'error');
                return;
            }

            modal.hide();
            await this.buyNow(product.id, 1, selectedSizeId || null, selectedColorId || null);
        });
    },

    /**
     * Bind cart icon click to open drawer
     */
    bindCartIcon() {
        const cartLink = document.getElementById('headerCartLink');
        if (cartLink) {
            cartLink.addEventListener('click', function (e) {
                e.preventDefault();
                const drawer = new bootstrap.Offcanvas(document.getElementById('cartDrawer'));
                drawer.show();
            });
        }
    },

    /**
     * Get CSRF token from meta tag
     */
    getToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    },

    /**
     * Load cart from server
     */
    async loadCart() {
        try {
            const res = await fetch('/cart', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            if (data.success) {
                this.renderCart(data);
            }
        } catch (err) {
            console.error('Failed to load cart:', err);
        }
    },

    /**
     * Add item to cart
     */
    async addToCart(productId, quantity = 1, sizeId = null, colorId = null) {
        try {
            const body = {
                product_id: productId,
                quantity: quantity,
            };
            if (sizeId) body.size_id = sizeId;
            if (colorId) body.color_id = colorId;

            const res = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(body),
            });

            const data = await res.json();

            if (data.success) {
                this.renderCart(data);
                this.showToast(data.message, 'success');
                // Open cart drawer
                const drawer = new bootstrap.Offcanvas(document.getElementById('cartDrawer'));
                drawer.show();
            } else {
                this.showToast('Failed to add item to cart.', 'error');
            }
        } catch (err) {
            console.error('Add to cart error:', err);
            this.showToast('Something went wrong.', 'error');
        }
    },

    /**
     * Add item to cart and redirect to checkout
     */
    async buyNow(productId, quantity = 1, sizeId = null, colorId = null) {
        try {
            const body = {
                product_id: productId,
                quantity: quantity,
            };
            if (sizeId) body.size_id = sizeId;
            if (colorId) body.color_id = colorId;

            const res = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(body),
            });

            const data = await res.json();

            if (data.success) {
                window.location.href = '/checkout';
            } else {
                this.showToast('Failed to process.', 'error');
            }
        } catch (err) {
            console.error('Buy now error:', err);
            this.showToast('Something went wrong.', 'error');
        }
    },

    /**
     * Update cart item quantity
     */
    async updateQuantity(cartKey, quantity) {
        if (quantity < 1) {
            this.removeItem(cartKey);
            return;
        }

        try {
            const res = await fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ cart_key: cartKey, quantity: quantity }),
            });

            const data = await res.json();

            if (data.success) {
                this.renderCart(data);
            }
        } catch (err) {
            console.error('Update cart error:', err);
        }
    },

    /**
     * Remove item from cart
     */
    async removeItem(cartKey) {
        try {
            const res = await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ cart_key: cartKey }),
            });

            const data = await res.json();

            if (data.success) {
                this.renderCart(data);
                this.showToast(data.message, 'success');
            }
        } catch (err) {
            console.error('Remove from cart error:', err);
        }
    },

    /**
     * Render the cart drawer contents
     */
    renderCart(data) {
        // Update header badge
        const badges = document.querySelectorAll('.cart-badge');
        badges.forEach(badge => {
            badge.textContent = data.count;
            badge.style.display = data.count > 0 ? 'flex' : 'none';
        });

        // Update drawer count
        const drawerCount = document.getElementById('cartDrawerCount');
        if (drawerCount) drawerCount.textContent = data.count;

        // Update subtotal
        const subtotalEl = document.getElementById('cartSubtotal');
        const checkoutTotal = document.getElementById('cartCheckoutTotal');
        if (subtotalEl) subtotalEl.textContent = data.subtotal_formatted;
        if (checkoutTotal) checkoutTotal.textContent = data.subtotal_formatted;

        // Show/hide empty state and footer
        const emptyState = document.getElementById('cartEmptyState');
        const itemsContainer = document.getElementById('cartItemsContainer');
        const footer = document.getElementById('cartDrawerFooter');

        if (data.cart.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            if (itemsContainer) itemsContainer.innerHTML = '';
            if (footer) footer.style.display = 'none';
        } else {
            if (emptyState) emptyState.style.display = 'none';
            if (footer) footer.style.display = 'block';

            let html = '';
            data.cart.forEach(item => {
                html += this.buildCartItemHtml(item);
            });
            if (itemsContainer) itemsContainer.innerHTML = html;
        }

        // Update main cart page elements if they exist
        const mainCount = document.getElementById('mainCartCount');
        if (mainCount) mainCount.textContent = data.count;

        const mainSubtotal = document.getElementById('mainCartSubtotal');
        if (mainSubtotal) mainSubtotal.textContent = data.subtotal_formatted;

        const mainTotal = document.getElementById('mainCartTotal');
        if (mainTotal) mainTotal.textContent = data.subtotal_formatted;

        const mainEmptyState = document.getElementById('mainCartEmptyState');
        const mainItemsContainer = document.getElementById('mainCartItemsContainer');
        const mainSummaryBox = document.getElementById('mainCartSummaryBox');

        if (mainItemsContainer && mainEmptyState) {
            if (data.cart.length === 0) {
                mainEmptyState.style.display = 'block';
                mainItemsContainer.innerHTML = '';
                if (mainSummaryBox) mainSummaryBox.style.display = 'none';
            } else {
                mainEmptyState.style.display = 'none';
                if (mainSummaryBox) mainSummaryBox.style.display = 'block';

                let html = '';
                data.cart.forEach(item => {
                    html += this.buildMainCartItemHtml(item);
                });
                mainItemsContainer.innerHTML = html;
            }
        }
    },

    /**
     * Build HTML for a single cart item on the MAIN cart page
     */
    buildMainCartItemHtml(item) {
        return `
            <div class="cart-page-item d-flex gap-3 gap-md-4 py-4 border-bottom-delicate" data-cart-key="${item.cart_key}">
                <a href="${item.url}" class="cart-img-wrap flex-shrink-0" style="width: 100px; height: 100px;">
                    <img onerror="this.onerror=null;this.src='images/placeholder.png';" src="${item.image}" alt="${item.name}" class="w-100 h-100 object-fit-cover rounded">
                </a>

                <div class="cart-item-info d-flex flex-column justify-content-between w-100">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2">
                        <div>
                            <h5 class="mb-1" style="font-size: 16px;">
                                <a href="${item.url}" class="text-decoration-none font-heading" style="color: var(--c-primary);">${item.name}</a>
                            </h5>
                            ${item.variant ? `<p class="text-muted mb-1" style="font-family: var(--f-body); font-size: 12px;">${item.variant}</p>` : ''}
                        </div>
                        <span class="fs-6 fw-bold" style="color: var(--c-primary);">${item.price_formatted}</span>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-3">
                        <div class="qty-selector d-inline-flex align-items-center justify-content-between border rounded" style="width: 100px; height: 35px; background: #fff;">
                            <button type="button" class="btn-qty border-0 bg-transparent px-2 text-dark" onclick="JodhaCart.updateQuantity('${item.cart_key}', ${item.quantity - 1})">
                                <i class="fa-solid fa-minus" style="font-size: 10px;"></i>
                            </button>

                            <input class="qty-input text-center border-0 bg-transparent p-0 w-100" min="1" value="${item.quantity}" type="number" style="font-size: 14px; pointer-events: none;">

                            <button type="button" class="btn-qty border-0 bg-transparent px-2 text-dark" onclick="JodhaCart.updateQuantity('${item.cart_key}', ${item.quantity + 1})">
                                <i class="fa-solid fa-plus" style="font-size: 10px;"></i>
                            </button>
                        </div>

                        <button class="btn p-0 text-dark text-decoration-none letter-spacing-1 d-flex align-items-center gap-2" onclick="JodhaCart.removeItem('${item.cart_key}')" style="font-family: var(--f-body); font-size: 11px; text-transform: uppercase; font-weight: 500;">
                            <i class="fa-regular fa-trash-can" style="font-size: 14px;"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        `;
    },

    /**
     * Build HTML for a single cart item
     */
    buildCartItemHtml(item) {
        return `
            <div class="cart-item d-flex gap-4 mb-4 pb-4 border-bottom-delicate" data-cart-key="${item.cart_key}">
                <a href="${item.url}" class="cart-item-img-wrapper flex-shrink-0">
                    <img onerror="this.onerror=null;this.src='images/placeholder.png';" src="${item.image}" alt="${item.name}" class="cart-item-img">
                </a>

                <div class="cart-item-details d-flex flex-column justify-content-between w-100">
                    <div>
                        <h6 class="mb-1 text-uppercase"
                            style="font-family: var(--f-body); font-size: 11px; letter-spacing: 1px;">
                            <a href="${item.url}" class="text-decoration-none" style="color: var(--c-primary);">${item.name}</a>
                        </h6>
                        ${item.variant ? `<span class="d-block text-muted mb-2" style="font-family: var(--f-body); font-size: 11px;">${item.variant}</span>` : ''}
                        <span class="fw-bold" style="font-size: 13px; color: var(--c-primary);">${item.price_formatted}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div class="qty-selector mini d-inline-flex align-items-center justify-content-between">
                            <button type="button" class="btn-qty" onclick="JodhaCart.updateQuantity('${item.cart_key}', ${item.quantity - 1})">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                            </button>
                            <input class="qty-input text-center" min="1" value="${item.quantity}" type="number"
                                onchange="JodhaCart.updateQuantity('${item.cart_key}', parseInt(this.value))"
                                style="pointer-events: none;">
                            <button type="button" class="btn-qty" onclick="JodhaCart.updateQuantity('${item.cart_key}', ${item.quantity + 1})">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                            </button>
                        </div>

                        <a href="javascript:void(0)" onclick="JodhaCart.removeItem('${item.cart_key}')" class="text-muted text-decoration-underline"
                            style="font-family: var(--f-body); font-size: 11px; letter-spacing: 1px;">Remove</a>
                    </div>
                </div>
            </div>
        `;
    },

    /**
     * Show a toast notification
     */
    showToast(message, type = 'success') {
        // Remove existing toast
        const existing = document.getElementById('jodhaToast');
        if (existing) existing.remove();

        const bgColor = type === 'success' ? 'var(--c-primary, #1a1a1a)' : '#dc3545';

        const toast = document.createElement('div');
        toast.id = 'jodhaToast';
        toast.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 99999;
                padding: 14px 24px;
                background: ${bgColor};
                color: white;
                font-family: var(--f-body, sans-serif);
                font-size: 13px;
                letter-spacing: 0.5px;
                border-radius: 0;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                display: flex;
                align-items: center;
                gap: 10px;
                animation: slideInToast 0.3s ease-out;
                max-width: 350px;
            ">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    ${type === 'success'
                ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'
                : '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
            }
                </svg>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            if (toast.firstElementChild) {
                toast.firstElementChild.style.animation = 'slideOutToast 0.3s ease-in forwards';
            }
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
};


// Initialize cart when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
    JodhaCart.init();
});
