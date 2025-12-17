<!-- Modal for Viewing Images -->
<div class="modal fade" id="productImagesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-images me-2"></i>Product Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="productImagesContainer" class="d-flex flex-wrap justify-content-center gap-3">
                    <!-- Images will load dynamically here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Variants -->
<div class="modal fade" id="productVariantsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-layer-group me-2"></i>Product Variants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="productVariantsContainer" class="table-responsive">
                    <!-- Variants will load dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Product Details -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content product-details-modal">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-box-open me-2"></i>Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="productDetailsContainer">
                    <!-- Product details will load dynamically -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="create-btn-white" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <a href="#" id="editProductBtn" class="create-btn-base">
                    <i class="fas fa-edit me-2"></i>Edit Product
                </a>
            </div>
        </div>
    </div>
</div>