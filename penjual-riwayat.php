<?php 
session_start();

require 'functions.php';

if ($_SESSION["login"]) {
  if (isset($_SESSION["user"]) && $_SESSION["user"] == "penjual") {
    $id_penjual = $_SESSION["id_penjual"];
    $result = mysqli_query($conn, "SELECT * FROM penjual WHERE id_penjual = '$id_penjual'");

    $penjual = mysqli_fetch_assoc($result);

    $now = query("SELECT YEAR(NOW()) as tahun, MONTH(NOW()) as bulan")[0];
    if (isset($_GET['cari'])) {
      if (isset($_GET['bulan'])) {
        $bulan = $_GET['bulan'];
        $tahun = $_GET['tahun'];
      }
    } else {
      $bulan = $now['bulan'];
      $tahun = $now['tahun'];
    }
    
    // join tabel 4 tabel dengan nama column yang sama menggunakan as

    $riwayat = query("SELECT * FROM pesanan p INNER JOIN item_pesanan ip ON p.id_pesanan = ip.id_pesanan INNER JOIN makanan m ON m.id_makanan = ip.id_makanan WHERE p.id_pesanan IN (SELECT id_pesanan FROM transaksi) AND MONTH(tanggal_pesanan) = '$bulan' AND YEAR(tanggal_pesanan)= '$tahun'");
    $result2 = mysqli_query($conn, "SELECT MONTH(tanggal_transaksi) as 'bulan' FROM transaksi GROUP BY MONTH(tanggal_transaksi)");
    $result = mysqli_query($conn, "SELECT YEAR(tanggal_transaksi) as 'tahun' FROM transaksi GROUP BY YEAR(tanggal_transaksi)");
    $bulanDB = mysqli_fetch_assoc($result2);
    $tahunDB = mysqli_fetch_row($result)[0];
    $tahuns[] = $now['tahun'];
    $tahuns[] = $tahunDB;
    // var_dump($tahun);
    // var_dump($tahuns);
    //var_dump($riwayat);
    //var_dump($data);
    // if (isset($now)) {
    //   var_dump($now);
    // }
    // var_dump($bulan);
    // var_dump($bulanDB);
    if (isset($_GET['report'])) {
      outputCsv('expenses2.csv', $riwayat);
      die();
    }
    // var_dump($riwayat);
    
  } else {
    header("Location: login.php");
  }

} else {
  header("Location: login.php");
}

 ?>

<!DOCTYPE html>
<html>
<?php include "assets/html/head-penjual.html"?>
<body>
  <section class="is-fullwidth">

   <?php include "assets/html/nav-penjual.html"?>

  </section>

  <div class="container">

   <div class="columns is-marginless">

    <div class="column is-2">
    <?php include 'assets/html/leftpanel-penjual.php'?>
    </div>

    <div class="column is-10">
    <div class="columns is-marginless is-variable is-1 is-centered v-center">
      <div class="select">
        <form action="" method="" name="">
          <select name="bulan" id="" class="select">
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
        </div>
        <div class="select">
          <select name="tahun" required>
            <?php foreach ($tahuns as $t) :?>
            <option value="<?= $t?>"><?=$t?></option>
            <?php endforeach;?>
          </select>
        </div>
        <div class="column is-2">
          <button type="submit" class="button is-primary is-fullwidth" name="cari">Proses</i></button>
          
        </form>
        </div>      
        <div class="column no-pesan">
          <h1 class="has-text-weight-bold"><?php echo "Bulan/Tahun : $bulan/$tahun" ?></h1>
        </div>
    </div>

     <div class="box content is-fullwidth">
      <div class="pesanan" id="tabel-pesanan">
       <table style="100%">
        <thead>
        <?php $i = 1;?>
         <tr>
           <th>#</th>
           <th>No. Order</th>
           <th>Pesanan</th>
           <th>Jumlah</th>
           <th>Meja</th>
           <th>Id Pelanggan</th>
           <th>Subtotal</th>
           <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($riwayat as $r) :?>
            <tr><td><?php echo $i; $id_makanan = $r['id_makanan']; $id_pesanan = $r['id_pesanan']; $i++?></td><td><?php echo $r['id_pesanan']?></td><td><?php echo $r['nama'] ?></td><td><?php echo $r['jumlah']?></td><td><?php echo $r['id_meja']?></td><td><?= $r['id_pelanggan']?></td><td><?= $r['subtotal']?></td><td><span class="button is-success">Selesai</span></td></tr>
          <?php endforeach; ?>
        </tbody>
       </table> 
      </div>
     </div>
     <a class="button is-info" style="margin-left: 50%; margin-right:50%" href="?report=true&cari=&bulan=<?= $bulan?>&tahun=<?= $tahun?>">Download Laporan</a>
    </div>

   </div>
  </div>
</body>
</html>
<script src="assets/js/bulma.js"></script>
<script src="assets/js/script.js"></script>
<script>

var tombolAntar = document.getElementById('antar');
//var interval = setInterval(pesanan, 1000);
var tabelPesanan = document.getElementById('tabel-pesanan');

function pesanan() {

  //buat objek ajax
  var xhr = new XMLHttpRequest();

  //cek kesiapan ajax
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      tabelPesanan.innerHTML = xhr.response;
    }
  }
  //eksekusi ajax
  xhr.open('GET', 'assets/ajax/ajax-penjual-riwayat.php', true);
  xhr.send();
}

</script>
<script >

</script>

</html>