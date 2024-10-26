<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Giriş Yap</h2>
    <form action="{{ route('login') }}" method="POST" class="mx-auto" style="max-width: 400px;">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Şifre</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
    </form>
    <div class="text-center mt-3">
        <p>Hesabın yok mu? <a href="{{ route('register') }}" class="btn btn-link">Kayıt Ol</a></p>
    </div>
</div>

<!-- Hata Mesajı Modali -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Eksik veya Hatalı Giriş</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Girdiğiniz bilgiler yanlış. Lütfen tekrar deneyin.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Hata Mesajı İçin Script -->
@if ($errors->any())
    <script>
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    </script>
@endif

</body>
</html>
