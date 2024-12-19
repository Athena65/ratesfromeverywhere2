document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#productRequestForm'); // Form id'si
    const isAuthenticated = window.isAuthenticated || false; // PHP'den değer gelmezse fallback olarak false
    const loginUrl = window.loginUrl || '/login'; // PHP'den route gelmezse fallback

    if (form) {
        form.addEventListener('submit', function (e) {
            if (!isAuthenticated) {
                e.preventDefault(); // Form submit işlemini engelle
                alert('Bu işlemi gerçekleştirmek için lütfen giriş yapın.');
                window.location.href = loginUrl; // Login sayfasına yönlendirme
            }
        });
    }
});
