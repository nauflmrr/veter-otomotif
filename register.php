<?php require 'lib.php'; $err='';
if ($_SERVER['REQUEST_METHOD']==='POST') { csrf_check();
  $n=trim($_POST['nama']); $m=trim($_POST['email']); $t=trim($_POST['telp']); $p=$_POST['password'];
  if (!$n || !filter_var($m, FILTER_VALIDATE_EMAIL) || strlen($p)<6) $err='Isi nama, email valid, dan kata sandi minimal 6 karakter.';
  else try {
    db()->prepare('INSERT INTO users(nama,email,telp,password) VALUES(?,?,?,?)')->execute([$n,$m,$t,password_hash($p,PASSWORD_DEFAULT)]);
    header('Location: login.php?ok=1'); exit;
  } catch (PDOException $x) { $err='Email sudah terdaftar.'; }
}
head('Daftar'); ?>
<form class="card narrow" method="post"><h1>Buat akun</h1><?php if($err): ?><p class="err"><?= e($err) ?></p><?php endif; ?>
<input type="hidden" name="csrf" value="<?= csrf() ?>">
<label>Nama lengkap<input name="nama" required></label>
<label>Email<input type="email" name="email" required></label>
<label>No. HP<input name="telp"></label>
<label>Kata sandi<input type="password" name="password" minlength="6" required></label>
<button class="btn">Daftar</button></form><?php foot();
