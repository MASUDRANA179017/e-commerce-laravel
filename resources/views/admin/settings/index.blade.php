@extends('layouts.master')

@section('title', 'Settings')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h3 class="fw-bold mb-0">Settings</h3>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 mb-4">
            <div class="list-group list-group-flush">
                <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">settings</i> General
                </a>
                <a href="#store" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">store</i> Store Info
                </a>
                <a href="#email" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">mail</i> Email
                </a>
                <a href="#payment" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">credit_card</i> Payment
                </a>
                <a href="#shipping" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">local_shipping</i> Shipping
                </a>
                <a href="#tax" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">receipt</i> Tax
                </a>
                <a href="#social" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">share</i> Social Media
                </a>
                <a href="#seo" class="list-group-item list-group-item-action" data-bs-toggle="list">
                    <i class="material-symbols-outlined fs-14 me-2">search</i> SEO
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="tab-content">
            <!-- General Settings -->
            <div class="tab-pane fade show active" id="general">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">General Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Site Name</label>
                                    <input type="text" class="form-control" value="GrowUp E-Commerce">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tagline</label>
                                    <input type="text" class="form-control" value="Your Ultimate Shopping Destination">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Timezone</label>
                                    <select class="form-select">
                                        <option>Asia/Dhaka (UTC+6)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select">
                                        <option>BDT (৳)</option>
                                        <option>USD ($)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date Format</label>
                                <select class="form-select">
                                    <option>M d, Y (Dec 01, 2025)</option>
                                    <option>d/m/Y (01/12/2025)</option>
                                    <option>Y-m-d (2025-12-01)</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Store Info -->
            <div class="tab-pane fade" id="store">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Store Information</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Logo</label>
                                    <input type="file" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Favicon</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Store Address</label>
                                <textarea class="form-control" rows="2">123 Commerce Street, Dhaka-1000, Bangladesh</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="+880 1713-269591">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="info@growup.com">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="tab-pane fade" id="email">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Email Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Mail Driver</label>
                                <select class="form-select">
                                    <option>SMTP</option>
                                    <option>Mailgun</option>
                                    <option>SendGrid</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" placeholder="smtp.gmail.com">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Port</label>
                                    <input type="text" class="form-control" placeholder="587">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-outline-secondary ms-2">Send Test Email</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payment Settings -->
            <div class="tab-pane fade" id="payment">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Payment Methods</h5>
                    </div>
                    <div class="card-body">
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Cash on Delivery</h6>
                                    <small class="text-muted">Accept payment on delivery</small>
                                </div>
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">bKash</h6>
                                    <small class="text-muted">Accept bKash mobile payments</small>
                                </div>
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Nagad</h6>
                                    <small class="text-muted">Accept Nagad mobile payments</small>
                                </div>
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Card Payment (SSLCommerz)</h6>
                                    <small class="text-muted">Accept Visa, Mastercard, etc.</small>
                                </div>
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Settings -->
            <div class="tab-pane fade" id="shipping">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Shipping Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Default Shipping Method</label>
                                <select class="form-select">
                                    <option>Flat Rate</option>
                                    <option>Free Shipping</option>
                                    <option>Weight Based</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shipping Cost (Inside Dhaka)</label>
                                    <input type="number" class="form-control" value="60">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shipping Cost (Outside Dhaka)</label>
                                    <input type="number" class="form-control" value="120">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Free Shipping Threshold</label>
                                <input type="number" class="form-control" value="5000" placeholder="Order amount for free shipping">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tax Settings -->
            <div class="tab-pane fade" id="tax">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Tax Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enableTax">
                                    <label class="form-check-label" for="enableTax">Enable Tax</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tax Rate (%)</label>
                                    <input type="number" class="form-control" value="0" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tax Label</label>
                                    <input type="text" class="form-control" value="VAT">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="taxIncluded">
                                    <label class="form-check-label" for="taxIncluded">Prices include tax</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Social Media Settings -->
            <div class="tab-pane fade" id="social">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">Social Media Links</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-facebook text-primary me-2"></i>Facebook</label>
                                <input type="url" class="form-control" placeholder="https://facebook.com/yourpage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-twitter text-info me-2"></i>Twitter</label>
                                <input type="url" class="form-control" placeholder="https://twitter.com/yourpage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-instagram text-danger me-2"></i>Instagram</label>
                                <input type="url" class="form-control" placeholder="https://instagram.com/yourpage">
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="fab fa-youtube text-danger me-2"></i>YouTube</label>
                                <input type="url" class="form-control" placeholder="https://youtube.com/yourchannel">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="tab-pane fade" id="seo">
                <div class="card border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" value="GrowUp E-Commerce - Your Ultimate Shopping Destination">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" rows="3">Shop the latest products at the best prices. GrowUp E-Commerce offers quality products with fast delivery across Bangladesh.</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" placeholder="e-commerce, online shopping, bangladesh">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Google Analytics ID</label>
                                <input type="text" class="form-control" placeholder="UA-XXXXXXXXX-X">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

