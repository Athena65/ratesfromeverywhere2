// Bu tanımları JavaScript içinde doğrudan kullanın
const rateProductUrl = window.rateProductUrl;
const removeRatingUrl = window.removeRatingUrl;
// Initialize the rating value and product ID
let selectedRating = 0;
let selectedProductId = null;

// Global rateProduct function
window.rateProduct = function (productId) {
    selectedProductId = productId;
    openRatingModal("Product Name", productId);
}

// Function to open the rating modal with the product name and product ID
window.openRatingModal = function (productName, productId) {
    document.getElementById('modalProductName').innerText = productName;
    document.getElementById('selectedRatingDisplay').innerText = ''; // Clear previous rating display
    selectedRating = 0; // Reset rating
    selectedProductId = productId; // Set the selected product ID
    document.querySelectorAll('.rating-stars i').forEach(star => {
        star.classList.remove('selected'); // Reset star selection
    });
    var ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'), {});
    ratingModal.show();
};

// Function to handle star selection with hover effect
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rating-stars i').forEach(star => {
        star.addEventListener('click', function () {
            selectedRating = this.getAttribute('data-rating');
            document.getElementById('selectedRatingDisplay').innerHTML = `<span style="color: yellow; font-size: 1.7rem;">${selectedRating}</span>`; // Display selected rating
            document.querySelectorAll('.rating-stars i').forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-rating') <= selectedRating) {
                    s.classList.add('selected');
                }
            });
        });

        star.addEventListener('mouseover', function () {
            document.querySelectorAll('.rating-stars i').forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-rating') <= this.getAttribute('data-rating')) {
                    s.classList.add('selected');
                }
            });
        });

        star.addEventListener('mouseleave', function () {
            document.querySelectorAll('.rating-stars i').forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-rating') <= selectedRating) {
                    s.classList.add('selected');
                }
            });
        });
    });
});

// Global removeRating function (rate kaldirma)
window.removeRating = function () {
    if (selectedProductId) {
        fetch(removeRatingUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: selectedProductId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Modal'i kapat
                    var ratingModal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                    if (ratingModal) {
                        ratingModal.hide();
                    }

                    // Overlay'i manuel olarak kaldır
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                    // Kullanıcının ürün kartındaki rating bölümünü kaldır
                    const userRatingElement = document.querySelector(`.user-rating[data-product-id="${selectedProductId}"]`);
                    if (userRatingElement) {
                        userRatingElement.innerHTML = '<i class="far fa-star me-1"></i> Rate';
                    }
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
}

// Global submitRating function (rate ekleme)
window.submitRating = function () {
    if (selectedRating > 0 && selectedProductId) {
        fetch(rateProductUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: selectedProductId,
                user_rate: selectedRating
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('selectedRatingDisplay').innerHTML = `Your rating: <span style="color: yellow; font-size: 1.5rem;">${selectedRating}</span> has been submitted!`;

                    setTimeout(() => {
                        var ratingModal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                        if (ratingModal) {
                            ratingModal.hide();
                        }

                        // Overlay'i manuel olarak kaldır
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                        // Kullanıcının ürün kartındaki rating bölümünü güncelle
                        const userRatingElement = document.querySelector(`.user-rating[data-product-id="${selectedProductId}"]`);
                        if (userRatingElement) {
                            userRatingElement.innerHTML = `<i class="fas fa-star me-1" style="color: #1e73be;"></i> <span class="fw-bold">${selectedRating}/5</span>`;
                        }
                    }, 1000);
                } else {
                    document.getElementById('selectedRatingDisplay').innerText = 'An error occurred. Please try again.';
                    document.getElementById('selectedRatingDisplay').style.color = 'red';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('selectedRatingDisplay').innerText = 'An error occurred. Please try again.';
                document.getElementById('selectedRatingDisplay').style.color = 'red';
            });
    } else {
        document.getElementById('selectedRatingDisplay').innerText = 'Please select a rating.';
        document.getElementById('selectedRatingDisplay').style.color = 'red';
    }
};

//close Modal
window.closeModal = function () {
    var ratingModal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
    if (ratingModal) {
        ratingModal.hide();
    }
    // Overlay'i manuel olarak kaldır
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
}
