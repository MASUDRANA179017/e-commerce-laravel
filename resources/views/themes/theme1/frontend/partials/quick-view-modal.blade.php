<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0" id="quickViewModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openQuickView(productId) {
        const modalElement = document.getElementById('quickViewModal');
        const modal = new bootstrap.Modal(modalElement);
        const modalBody = document.getElementById('quickViewModalBody');
        
        // Reset content to loading state
        modalBody.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        
        modal.show();
        
        // Fetch product data
        fetch(`/product/${productId}/quick-view`)
            .then(response => response.text())
            .then(html => {
                modalBody.innerHTML = html;
                
                // Re-execute scripts in the injected HTML
                // The script is self-executing (IIFE) so it runs automatically
                const scripts = modalBody.querySelectorAll("script");
                scripts.forEach(oldScript => {
                    const newScript = document.createElement("script");
                    Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                    newScript.textContent = oldScript.textContent;
                    oldScript.parentNode.replaceChild(newScript, oldScript);
                });
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="alert alert-danger">Failed to load product details.</div>';
                console.error('Error:', error);
            });
    }
</script>