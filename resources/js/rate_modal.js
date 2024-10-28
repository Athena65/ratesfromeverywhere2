// Initialize the rating value
let selectedRating = 0;

// Function to open the rating modal with the product name
window.openRatingModal = function(productName) {
    document.getElementById('modalProductName').innerText = productName;
    var ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'), {});
    ratingModal.show();
};

// Function to handle star selection with hover effect
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rating-stars i').forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = this.getAttribute('data-rating');
            document.querySelectorAll('.rating-stars i').forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-rating') <= selectedRating) {
                    s.classList.add('selected');
                }
            });
        });

        star.addEventListener('mouseover', function() {
            document.querySelectorAll('.rating-stars i').forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-rating') <= this.getAttribute('data-rating')) {
                    s.classList.add('selected');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            document.querySelectorAll('.rating-stars i').forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-rating') <= selectedRating) {
                    s.classList.add('selected');
                }
            });
        });
    });
});

// Function to submit the rating
window.submitRating = function() {
    if (selectedRating > 0) {
        alert(`You rated this product ${selectedRating} out of 5 stars!`);
        var ratingModal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
        ratingModal.hide();
    } else {
        alert('Please select a rating before submitting.');
    }
};
