// Bu tanımları JavaScript içinde doğrudan kullanın
let rateProductUrl = window.rateProductUrl;
let removeRatingUrl = window.removeRatingUrl;
// Initialize the rating value and product ID
let selectedRating = 0;
let selectedProductId = null;

// Global rateProduct function
window.rateProduct = function (productName,productId) {
    // Kullanıcı giriş yapmışsa rating modalını aç
    selectedProductId = productId;
    openRatingModal(productName, productId);
}

// Function to open the rating modal with the product name and product ID
window.openRatingModal = function (productName, productId) {
    const modalProductName = document.getElementById('modalProductName');
    const selectedRatingDisplay = document.getElementById('selectedRatingDisplay');
    const ratingStars = document.querySelectorAll('.rating-stars i');
    const ratingModalElement = document.getElementById('ratingModal');
    // Modal içeriğini hızlıca güncelleyin
    modalProductName.innerText = productName;
    selectedRatingDisplay.innerText = ''; // Clear previous rating display
    selectedRating = 0; // Reset rating
    selectedProductId = productId; // Set the selected product ID

    // Tüm yıldızların seçimini temizleyin
    ratingStars.forEach(star => {
        star.classList.remove('selected');
    });

    // Kullanıcının oylama durumunu kontrol et ve butonun görünürlüğünü ayarla (asenkron çalıştır)
    checkUserRatingAndToggleRemoveButton(productId);

    // Modal'ı gösterin (beklemeden)
    const ratingModal = new bootstrap.Modal(ratingModalElement, {});
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
                    // DOM'da site_rating değerini güncelle
                    const siteRatingElement = document.querySelector(`.site-rating[data-product-id="${selectedProductId}"]`);
                    if (siteRatingElement && data.new_site_rating !== undefined) {
                        siteRatingElement.innerHTML = `${data.new_site_rating}`;
                    }
                    // Modal'i kapat
                    const ratingModal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                    if (ratingModal) {
                        ratingModal.hide();
                    }

                    // Modal kapandıktan sonra overlay'i ve rating görünümünü temizle
                    setTimeout(() => {
                        // Overlay'i kaldır
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                        // Kullanıcının ürün kartındaki rating bölümünü kaldır
                        const userRatingElement = document.querySelector(`.user-rating[data-product-id="${selectedProductId}"]`);
                        if (userRatingElement) {
                            userRatingElement.innerHTML = '<i class="far fa-star me-1"></i> Rate';
                        }
                    }, 200); // Modal kapanmasını beklemek için biraz daha uzun bir gecikme
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
};


// Global submitRating function (rate ekleme)
window.submitRating = function () {
    // Kullanıcı giriş yapmamışsa giriş sayfasına yönlendir
    if (!isAuthenticated) {
        window.location.href = loginUrl;
        return;
    }
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
                    // DOM'da kullanıcı puanını güncelle
                    const userRatingElement = document.querySelector(`.user-rating[data-product-id="${selectedProductId}"]`);
                    if (userRatingElement) {
                        userRatingElement.innerHTML = `<i class="fas fa-star me-1" style="color: #1e73be;"></i> <span class="fw-bold">${selectedRating}/5</span>`;
                    }

                    // DOM'da site_rating değerini güncelle
                    const siteRatingElement = document.querySelector(`.site-rating[data-product-id="${selectedProductId}"]`);
                    if (siteRatingElement && data.new_site_rating !== undefined) {
                        siteRatingElement.innerHTML = `${data.new_site_rating}`;
                    }

                    // Modali kapat
                    setTimeout(() => {
                        var ratingModal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                        if (ratingModal) {
                            ratingModal.hide();
                        }
                        // Overlay'i manuel olarak kaldır
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

                        // Kullanıcının ürün kartındaki rating bölümünü güncelle
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
    setTimeout(() => {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }, 100); // Delay to ensure backdrop is removed after modal is hidden
}
// Listen for modal hide event to remove overlay
document.getElementById('ratingModal').addEventListener('hide.bs.modal', () => {
    setTimeout(() => {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }, 100); // Delay to ensure backdrop is removed after modal is hidden
});
//disable hover when modal opent
// Modal açıldığında tüm kartlara "card-hover-disabled" sınıfını ekle
const ratingModal = document.getElementById('ratingModal');

ratingModal.addEventListener('show.bs.modal', () => {
    document.querySelectorAll('.card').forEach(card => {
        card.classList.add('card-hover-disabled');
    });
});

// Modal kapandığında "card-hover-disabled" sınıfını kaldır
ratingModal.addEventListener('hidden.bs.modal', () => {
    document.querySelectorAll('.card').forEach(card => {
        card.classList.remove('card-hover-disabled');
    });
});

// Function to check if the user has rated the product and show/hide the remove button
function checkUserRatingAndToggleRemoveButton(productId) {
    const removeButton = document.querySelector('.btn-remove-rating');
    // Butonu hemen gizle (yükleme hissi)
    removeButton.style.visibility = 'hidden';
    removeButton.style.opacity = '0';

    // `fetch` isteğini başlat
    fetch(`/check-user-rating`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.rated) {
                // Butonun data-product-id özelliğini ayarlayın ve görünürlüğünü artırın
                removeButton.setAttribute('data-product-id', productId);
                removeButton.style.visibility = 'visible';
                removeButton.style.opacity = '1';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
