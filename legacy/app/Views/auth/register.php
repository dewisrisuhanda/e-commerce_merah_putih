<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar — Parigi Market</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height:100vh">
    <div class="card shadow-sm" style="width:100%;max-width:460px">
        <div class="card-body p-4">
            <h4 class="fw-bold text-success mb-1">Daftar Akun</h4>
            <p class="text-muted mb-4">Buat akun untuk mulai belanja</p>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $e): ?>
                            <li><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Pengiriman</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?= old('alamat') ?></textarea>
                </div>
                <button type="submit" class="btn w-100 text-white" style="background:#2e7d32">Daftar Sekarang</button>
            </form>
            <hr>
            <p class="text-center mb-0 small">Sudah punya akun? <a href="<?= base_url('login') ?>">Login</a></p>
        </div>
    </div>
</body>

</html>