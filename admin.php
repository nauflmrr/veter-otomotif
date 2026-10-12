<?php
require_once 'lib.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$testDrives = $pdo->query("SELECT t.*, c.nama_mobil FROM test_drive t LEFT JOIN cars c ON t.car_id = c.id ORDER BY t.id DESC")->fetchAll();
$services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();

renderHeader("Admin Dashboard");
?>

<div class="mb-8">
    <h2 class="text-3xl font-extrabold text-slate-900">Dashboard Pusat Kontrol Admin</h2>
    <p class="text-slate-500 text-sm">Monitoring permohonan test drive dan antrean perbaikan unit bengkel.</p>
</div>

<div class="mb-12">
    <h3 class="text-lg font-bold text-slate-800 mb-4 border-l-4 border-red-600 pl-3">Jadwal Masuk Test Drive</h3>
    <div class="overflow-x-auto bg-white rounded-xl border border-slate-200">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-800 font-semibold border-b">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">WhatsApp</th>
                    <th class="p-3">Unit Mobil</th>
                    <th class="p-3">Jadwal</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($testDrives)): ?>
                    <tr><td colspan="5" class="p-4 text-center text-slate-400">Belum ada booking test drive.</td></tr>
                <?php else: foreach ($testDrives as $t): ?>
                    <tr>
                        <td class="p-3 font-medium text-slate-900"><?= htmlspecialchars($t['nama_lengkap']); ?></td>
                        <td class="p-3"><?= htmlspecialchars($t['telepon']); ?></td>
                        <td class="p-3"><?= htmlspecialchars($t['nama_mobil'] ?? '-'); ?></td>
                        <td class="p-3"><?= $t['tanggal'] . ' (' . substr($t['jam'], 0, 5) . ')'; ?></td>
                        <td class="p-3"><span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800"><?= $t['status']; ?></span></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div>
    <h3 class="text-lg font-bold text-slate-800 mb-4 border-l-4 border-slate-800 pl-3">Antrean Servis Bengkel</h3>
    <div class="overflow-x-auto bg-white rounded-xl border border-slate-200">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-800 font-semibold border-b">
                <tr>
                    <th class="p-3">Pemilik</th>
                    <th class="p-3">Plat / Model</th>
                    <th class="p-3">Paket Servis</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Keluhan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($services)): ?>
                    <tr><td colspan="5" class="p-4 text-center text-slate-400">Belum ada antrean servis.</td></tr>
                <?php else: foreach ($services as $s): ?>
                    <tr>
                        <td class="p-3 font-medium text-slate-900"><?= htmlspecialchars($s['nama_pemilik']); ?></td>
                        <td class="p-3"><?= htmlspecialchars($s['nomor_polisi'] . ' - ' . $s['tipe_kendaraan']); ?></td>
                        <td class="p-3"><?= htmlspecialchars($s['jenis_servis']); ?></td>
                        <td class="p-3"><?= $s['tanggal_servis']; ?></td>
                        <td class="p-3 text-xs max-w-xs truncate"><?= htmlspecialchars($s['keluhan'] ?: '-'); ?></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php renderFooter(); ?>