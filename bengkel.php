<?php
require_once 'lib.php';

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_servis'])) {
    $nama = trim($_POST['nama_pemilik']);
    $telepon = trim($_POST['telepon']);
    $nopol = trim($_POST['nomor_polisi']);
    $tipe = trim($_POST['tipe_kendaraan']);
    $jenis = $_POST['jenis_servis'];
    $tanggal = $_POST['tanggal_servis'];
    $keluhan = trim($_POST['keluhan']);
    $user_id = $_SESSION['user_id'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO services (user_id, nama_pemilik, telepon, nomor_polisi, tipe_kendaraan, jenis_servis, tanggal_servis, keluhan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $nama, $telepon, $nopol, $tipe, $jenis, $tanggal, $keluhan])) {
        $pesan = "Pendaftaran servis terkonfirmasi. Silakan datang sesuai jadwal ke bengkel resmi PT Veter Otomotif.";
    }
}

renderHeader("Layanan Bengkel & Servis");
?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
    <h2 class="text-2xl font-bold text-slate-900 mb-2">Penjadwalan Servis Kendaraan</h2>
    <p class="text-slate-500 text-sm mb-6">Booking antrean perbaikan berkala dan penggantian suku cadang tanpa antre.</p>

    <?php if ($pesan): ?>
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm">
            <?= htmlspecialchars($pesan); ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pemilik</label>
                <input type="text" name="nama_pemilik" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp</label>
                <input type="tel" name="telepon" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Polisi (Plat)</label>
                <input type="text" name="nomor_polisi" placeholder="B 1234 ABC" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Model / Tipe Mobil</label>
                <input type="text" name="tipe_kendaraan" placeholder="Fortuner 2022" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Paket Servis</label>
                <select name="jenis_servis" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
                    <option value="Servis Berkala 10.000 KM">Servis Berkala 10.000 KM</option>
                    <option value="Ganti Oli & Tune Up">Ganti Oli & Tune Up</option>
                    <option value="Pengecekan Rem & Kaki-kaki">Pengecekan Rem & Kaki-kaki</option>
                    <option value="General Overhaul">General Overhaul</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Rencana Servis</label>
                <input type="date" name="tanggal_servis" required class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan / Keluhan Tambahan</label>
            <textarea name="keluhan" rows="3" class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-500" placeholder="Deskripsikan kendala mesin atau kebutuhan perbaikan"></textarea>
        </div>

        <button type="submit" name="submit_servis" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition shadow-md">Konfirmasi Booking Bengkel</button>
    </form>
</div>

<?php renderFooter(); ?>