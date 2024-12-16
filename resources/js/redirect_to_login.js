document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#productRequestForm'); // Form id'si

    if (form) {
        form.addEventListener('submit', function (e) {
            if (!isAuthenticated) {
                e.preventDefault(); // Formun submit olmasını engelle
                alert('Bu işlemi gerçekleştirmek için lütfen giriş yapın.'); // Kullanıcıya uyarı ver
                window.location.href = loginUrl; // Login sayfasına yönlendir
            }
        });
    }
});

