// Initialize the rating value and product ID
let selectedRating = 0;
let selectedProductId = null;

// Function to open the rating modal with the product name and product ID
window.openRatingModal = function(productName, productId) {
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
        star.addEventListener('click', function() {
            selectedRating = this.getAttribute('data-rating');
            document.getElementById('selectedRatingDisplay').innerHTML = `<span style="color: yellow; font-size: 1.7rem;">${selectedRating}</span>`; // Display selected rating
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
// Function to submit the rating and close the modal
window.submitRating = function() {
    if (selectedRating > 0 && selectedProductId) {
        // Perform an AJAX request to send the rating to the server
        fetch(rateProductUrl, {  // Burada doğrudan route değişkenini kullandık
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
                    // Show confirmation message with the rating in yellow
                    document.getElementById('selectedRatingDisplay').innerHTML = `Your rating: <span style="color: yellow; font-size: 1.5rem;">${selectedRating}</span> has been submitted!`;

                    // Close the modal after a brief delay
                    setTimeout(() => {
                        var ratingModal = bootstrap.Modal.getInstance(document.getElementById('ratingModal'));
                        ratingModal.hide();
                    }, 1000); // Delay to allow user to see the message before modal closes
                } else {
                    // Display error message if the request was unsuccessful
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
        // Display error message if no rating is selected
        document.getElementById('selectedRatingDisplay').innerText = 'Please select a rating.';
        document.getElementById('selectedRatingDisplay').style.color = 'red';
    }
};
