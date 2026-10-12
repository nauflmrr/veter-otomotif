<?php
require_once 'lib.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nama'] = $user['nama'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: " . ($user['role'] === 'admin' ? 'admin.php' : 'index.php'));
        exit;
    } else {
        $error = "Email atau password yang Anda masukkan salah.";
    }
}

renderHeader("Masuk");
?>

<div class="max-w-md mx-auto bg-white p-8 rounded-2xl border border-slate-200 shadow-sm mt-8">
    <h2 class="text-2xl font-bold text-slate-900 mb-1">Masuk Akun</h2>
    <p class="text-xs text-slate-500 mb-6">Akses dashboard PT Veter Otomotif</p>

    <?php if ($error): ?>
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
        </div>
        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 rounded-lg text-sm transition">Masuk</button>
    </form>
    <p class="text-xs text-slate-400 mt-4 text-center">Akun Admin Demo: <b>admin@veter.com</b> | Sandi: <b>password123</b></p>
</div>

<?php renderFooter(); ?>