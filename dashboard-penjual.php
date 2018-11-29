<?php 
session_start();

require 'functions.php';

if ($_SESSION["login"]) {

$id_penjual = $_SESSION["id_penjual"];
$result = mysqli_query($conn, "SELECT * FROM penjual WHERE id_penjual = '$id_penjual'");

$penjual = mysqli_fetch_assoc($result);

} else {
  header("Location: login.php");
}

 ?>

<!DOCTYPE html>
<html>

<head>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1" />
 <title>Dashboard!</title>
 <link rel="stylesheet" href="assets/css/bulma.min.css" />
 <link rel="stylesheet" href="assets/css/style.css" />
 <script defer src="assets/js/all.js"></script>
</head>

<body>
  <section class="is-fullwidth">

   <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
     <a class="navbar-item brand-text" href="../">
      <img src="assets/img/logo.png" alt="" srcset="">
     </a>
     <div class="navbar-burger burger " data-target="navMenu">
      <span></span>
      <span></span>
      <span></span>
     </div>
    </div>

    <div id="navMenu" class="navbar-menu">
     <div class="navbar-start">
      <div class="navbar-item">
       <a class="navbar-item" href="">Home</a>
       <a class="navbar-item" href="">Makanan</a>
      </div>
     </div>
     <div class="navbar-end">
      <div class="navbar-item">
       <a class="button is-danger" href="functionLogout.php">Logout</a>
      </div>
     </div>
    </div>

   </nav>

  </section>

  <div class="container">

   <div class="columns is-marginless">

    <div class="column is-2">
     <aside class="sidebar menu is-hidden-mobile is-uppercase has-text-weight-bold ">
      <div class="avatar has-text-centered">
       <figure class="img-avatar">
        <img src="assets/img/avatar.png" alt="">
       </figure>
       <div class="id-admin"><?= $penjual["username"] ?></div>
      </div>
      <hr>
      <p class="menu-label">General</p>
      <ul class="menu-list">
       <li><a href="">Edit Profil</a></li>
      </ul>
      <p class="menu-label">Transaction</p>
      <ul class="menu-list">
       <li><a href="">Riwayat</a></li>
      </ul>

     </aside>
    </div>

    <div class="column is-10">

     <div class="box content is-fullwidth">
      <div class="pesanan">
       <table style="100%">
        <thead>
         <tr><th>#</th><th>Pesanan</th><th>Jumlah</th><th>Meja</th><th>Aksi</th></tr>
        </thead>
        <tbody>
         <tr><td>1</td><td>Tahu Kupat</td><td>10</td><td>5</td><td><button class="button is-small is-success"><i class="fas fa-check"></i></button></td></tr>
         <tr><td>2</td><td>Mie Ayam</td><td>10</td><td>5</td><td><button class="button is-small is-success"><i class="fas fa-check"></i></button></td></tr>
         <tr><td>3</td><td>Good Day</td><td>10</td><td>5</td><td><button class="button is-small is-success"><i class="fas fa-check"></i></button></td></tr>
         <tr><td>4</td><td>Mie Dok Dok</td><td>10</td><td>5</td><td><button class="button is-small is-success"><i class="fas fa-check"></i></button></td></tr>
        </tbody>
       </table>
      </div>
     </div>

    </div>

   </div>
  </div>
</body>

<script src="assets/js/bulma.js"></script>

</html>