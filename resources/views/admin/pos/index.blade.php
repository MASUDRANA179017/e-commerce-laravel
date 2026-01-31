@extends('layouts.master')

@section('title', 'POS System')

@section('content')
<div class="row h-100">
    <!-- Product Section (Left Side) -->
    <div class="col-lg-8 h-100 d-flex flex-column">
        <div class="overflow-hidden card flex-grow-1">
            <div class="py-3 bg-white card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">Products</h4>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchProduct" class="form-control" placeholder="Search by name or SKU...">
                    </div>
                </div>
            </div>
            <div class="overflow-auto card-body bg-light" style="max-height: calc(100vh - 180px);">
                <div class="row g-3" id="productList">
                    @foreach($products as $product)
                        <div class="col-md-4 col-sm-6 product-card-wrapper" data-name="{{ strtolower($product->title) }}" data-id="{{ $product->id }}">
                            <div class="shadow-sm card h-100 product-card">
                                <div class="position-relative">
                                    @php
                                        $img = $product->coverImage ? $product->coverImage->path : ($product->images->first() ? $product->images->first()->path : null);
                                        $imgSrc = $img ? asset('storage/'.$img) : asset('assets/images/placeholder.png');

                                        if ($product->variants->count() > 0) {
                                            $totalStock = $product->variants->sum('stock_quantity');
                                        } else {
                                            $totalStock = $product->stock_quantity;
                                        }
                                    @endphp
                                    <img src="{{ $imgSrc }}"
                                         class="card-img-top" alt="{{ $product->title }}" style="height: 150px; object-fit: cover;">

                                    <span class="position-absolute top-0 end-0 badge {{ $totalStock > 0 ? 'bg-success' : 'bg-danger' }} m-2">
                                        {{ $totalStock }} left
                                    </span>
                                </div>
                                <div class="p-2 text-center card-body d-flex flex-column">
                                    <h6 class="mb-1 card-title text-truncate" title="{{ $product->title }}">{{ $product->title }}</h6>

                                    <p class="mb-1 fw-bold text-primary">
                                        @php
                                            if ($product->variants->count() > 0) {
                                                $minPrice = $product->variants->min('price');
                                                $maxPrice = $product->variants->max('price');
                                            } else {
                                                $minPrice = $product->price;
                                                $maxPrice = $product->price;
                                            }
                                        @endphp
                                        @if($minPrice != $maxPrice)
                                            ৳{{ number_format($minPrice, 2) }} - ৳{{ number_format($maxPrice, 2) }}
                                        @else
                                            ৳{{ number_format($minPrice, 2) }}
                                        @endif
                                    </p>

                                    <div class="mb-2">
                                        @if($totalStock > 0)
                                            <span class="text-success small fw-bold"><i class="ri-checkbox-circle-line"></i> In Stock ({{ $totalStock }})</span>
                                        @else
                                            <span class="text-danger small fw-bold"><i class="ri-close-circle-line"></i> Sold Out</span>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        @if($product->variants->count() > 0)
                                            <div class="mb-2">
                                                <select class="form-select form-select-sm" id="variant-select-{{ $product->id }}">
                                                    @foreach($product->variants as $variant)
                                                        <option value="{{ $variant->id }}"
                                                                data-price="{{ $variant->price }}"
                                                                data-stock="{{ $variant->stock_quantity }}"
                                                                data-name="{{ addslashes($product->title) }} ({{ $variant->combination_key }})"
                                                                {{ $variant->stock_quantity <= 0 ? 'disabled' : '' }}>
                                                            {{ $variant->combination_key }} - ৳{{ number_format($variant->price, 2) }} ({{ $variant->stock_quantity }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="btn btn-sm btn-primary w-100" onclick="addToCartFromCard({{ $product->id }})">
                                                <i class="ri-shopping-cart-line me-1"></i> Add Item
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary w-100"
                                                onclick="addToCartSimple({{ $product->id }}, '{{ addslashes($product->title) }}', {{ $product->price }}, {{ $totalStock }})"
                                                {{ $totalStock <= 0 ? 'disabled' : '' }}>
                                                <i class="ri-shopping-cart-line me-1"></i> Add Item
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Section (Right Side) -->
    <div class="col-lg-4 h-100">
        <div class="shadow card h-100 d-flex flex-column">
            <div class="py-3 text-white card-header bg-primary">
                <h5 class="mb-0 text-white"><i class="ri-shopping-cart-line me-2"></i>Current Order</h5>
            </div>

            <!-- Customer Selection -->
            <div class="p-3 bg-white border-bottom">
                <div class="input-group">
                    <select class="form-select select2" id="customerSelect">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <i class="ri-add-line"></i>
                    </button>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="overflow-auto p-0 card-body flex-grow-1 bg-light" id="cartContainer" style="max-height: 400px;">
                <table class="table mb-0 table-hover">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Item</th>
                            <th width="70">Qty</th>
                            <th class="text-end">Price</th>
                            <th width="30"></th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        <!-- Items will be added here -->
                    </tbody>
                </table>
                <div id="emptyCartMessage" class="p-5 text-center text-muted">
                    <i class="ri-shopping-basket-2-line fs-1"></i>
                    <p class="mt-2">Cart is empty</p>
                </div>
            </div>

            <!-- Totals & Actions -->
            <div class="p-3 bg-white card-footer border-top">
                <div class="mb-2 d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span class="fw-bold" id="cartSubtotal">৳0.00</span>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span>Tax (0%):</span>
                    <span>৳0.00</span>
                </div>
                <div class="mb-3 d-flex justify-content-between fs-5">
                    <span class="fw-bold">Total:</span>
                    <span class="fw-bold text-primary" id="cartTotal">৳0.00</span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cash Received</label>
                    <input type="number" class="form-control" id="cashReceived" placeholder="Enter amount">
                </div>

                <div class="gap-2 d-grid">
                    <button class="btn btn-success btn-lg" onclick="processSale()">
                        <i class="ri-check-double-line me-2"></i>Complete Sale
                    </button>
                    <button class="btn btn-outline-danger" onclick="clearCart()">
                        <i class="ri-delete-bin-line me-2"></i>Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCustomerForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" id="newCustomerPhone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="newCustomerEmail">
                        <small class="text-muted">Auto-generated if empty</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2"></textarea>
                    </div>
                    <input type="hidden" name="password" value="123456">
                    <input type="hidden" name="password_confirmation" value="123456">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">Save Customer</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .product-card {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        border-color: var(--primary-color);
    }
    .qty-input {
        width: 50px;
        text-align: center;
        padding: 2px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }
</style>
@endpush

@push('scripts')
<script>
    let cart = [];

    // Search Functionality
    document.getElementById('searchProduct').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let items = document.querySelectorAll('.product-card-wrapper');

        items.forEach(function(item) {
            let name = item.getAttribute('data-name');
            if (name.indexOf(value) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });

    function addToCartSimple(id, name, price, stock) {
        addToCart(id, null, name, price, stock);
    }

    function addToCart(id, variantId, name, price, stock) {
        if (stock <= 0) {
            toastr.error('Out of stock!');
            return;
        }

        // For simple products, variantId is null.
        // For variant products, variantId is a number.
        // cart.find needs to match correctly.
        let existingItem = cart.find(item => item.id === id && item.variant_id === variantId);

        if (existingItem) {
            if (existingItem.quantity + 1 > stock) {
                toastr.warning('Cannot add more than available stock.');
                return;
            }
            existingItem.quantity++;
        } else {
            cart.push({
                id: id,
                variant_id: variantId,
                name: name,
                price: parseFloat(price),
                quantity: 1,
                stock: stock
            });
        }
        renderCart();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function updateQuantity(index, newQty) {
        if (newQty < 1) {
            removeFromCart(index);
            return;
        }
        if (newQty > cart[index].stock) {
            toastr.warning('Cannot exceed available stock.');
            renderCart(); // Reset input
            return;
        }
        cart[index].quantity = parseInt(newQty);
        renderCart();
    }

    function renderCart() {
        let tbody = document.getElementById('cartTableBody');
        let emptyMsg = document.getElementById('emptyCartMessage');
        tbody.innerHTML = '';

        if (cart.length === 0) {
            emptyMsg.style.display = 'block';
        } else {
            emptyMsg.style.display = 'none';

            cart.forEach((item, index) => {
                let row = `
                    <tr>
                        <td>
                            <div class="small fw-bold">${item.name}</div>
                        </td>
                        <td>
                            <input type="number" class="qty-input" value="${item.quantity}"
                                   onchange="updateQuantity(${index}, this.value)">
                        </td>
                        <td class="text-end">৳${(item.price * item.quantity).toFixed(2)}</td>
                        <td class="text-end">
                            <button class="p-0 btn btn-sm btn-link text-danger" onclick="removeFromCart(${index})">
                                <i class="ri-close-circle-line"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }
        updateTotals();
    }

    function updateTotals() {
        let subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('cartSubtotal').innerText = '৳' + subtotal.toFixed(2);
        document.getElementById('cartTotal').innerText = '৳' + subtotal.toFixed(2);
    }

    function clearCart() {
        if(confirm('Are you sure you want to clear the cart?')) {
            cart = [];
            renderCart();
        }
    }

    function processSale() {
        if (cart.length === 0) {
            toastr.warning('Cart is empty!');
            return;
        }

        let total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        let cash = parseFloat(document.getElementById('cashReceived').value);
        let customerId = document.getElementById('customerSelect').value;

        if (cash && cash < total) {
            toastr.error('Insufficient cash received!');
            return;
        }

        let data = {
            cart: cart,
            subtotal: total,
            total: total,
            cash_received: cash || total,
            customer_id: customerId,
            _token: '{{ csrf_token() }}'
        };

        // Disable button
        let btn = event.target;
        let originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

        fetch('{{ route("admin.pos.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                cart = [];
                renderCart();
                document.getElementById('cashReceived').value = '';

                // Auto print invoice
                 if (data.order_id) {
                     let printUrl = "{{ route('admin.orders.print', 999999) }}";
                     printUrl = printUrl.replace('999999', data.order_id);
                     window.open(printUrl, '_blank');
                 }
            } else {
                toastr.error(data.message || 'Something went wrong');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Server error occurred');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    // Add New Customer Logic
    document.getElementById('saveCustomerBtn').addEventListener('click', function() {
        let form = document.getElementById('addCustomerForm');
        let formData = new FormData(form);

        // Validation
        if (!formData.get('name') || !formData.get('phone')) {
            toastr.error('Name and Phone are required');
            return;
        }

        // Auto-fill dummy data if empty
        let phone = formData.get('phone');
        if (!formData.get('email')) {
            formData.set('email', phone + '@noemail.com');
        }
        if (!formData.get('address')) {
            formData.set('address', 'N/A');
        }

        let btn = this;
        let originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Saving...';

        fetch("{{ route('admin.customers.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let customer = data.customer;
                // Add to select and select it
                let newOption = new Option(customer.name + ' (' + customer.phone + ')', customer.id, true, true);
                $('#customerSelect').append(newOption).trigger('change');

                // Close modal
                var modal = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
                modal.hide();
                form.reset();
                toastr.success('Customer added successfully');
            } else {
                let msg = data.message;
                if(data.errors) {
                    msg = Object.values(data.errors).flat().join('\n');
                }
                toastr.error(msg || 'Failed to add customer. Check if email/phone exists.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error adding customer. Check inputs.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });

    function addToCartFromCard(productId) {
        let select = document.getElementById('variant-select-' + productId);
        if (!select) return;

        let selectedOption = select.options[select.selectedIndex];
        if (!selectedOption) return;

        if (selectedOption.disabled) {
            toastr.error('Selected variant is out of stock');
            return;
        }

        let variantId = select.value;
        let price = parseFloat(selectedOption.getAttribute('data-price'));
        let stock = parseInt(selectedOption.getAttribute('data-stock'));
        let name = selectedOption.getAttribute('data-name');

        addToCart(productId, variantId, name, price, stock);
    }
</script>
@endpush
@endsection
