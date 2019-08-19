<?php

  //database configuration
    $host       = "localhost";
    $user       = "root";
    $pass       = "";
    $database   = "menjangan_go";

    $connect = new mysqli($host, $user, $pass, $database);

    if (!$connect) {
        die ("connection failed: " . mysqli_connect_error());
    } else {
        $connect->set_charset('utf8');
    }
    
    $GLOBALS['config'] = $connect;


    $ENABLE_RTL_MODE = 'false';

?>



<?php



  $sql_pasar = "SELECT COUNT(*) as num FROM pasar_rakyat";
  $total_pasar = mysqli_query($connect, $sql_pasar);
  $total_pasar = mysqli_fetch_array($total_pasar);
  $total_pasar = $total_pasar['num'];

  $sql_toko = "SELECT COUNT(*) as num FROM toko_modern";
  $total_toko = mysqli_query($connect, $sql_toko);
  $total_toko = mysqli_fetch_array($total_toko);
  $total_toko = $total_toko['num'];

  $sql_gudang = "SELECT COUNT(*) as num FROM gudang";
  $total_gudang = mysqli_query($connect, $sql_gudang);
  $total_gudang = mysqli_fetch_array($total_gudang);
  $total_gudang = $total_gudang['num'];


  $sql_kios_pupuk = "SELECT COUNT(*) as num FROM kios_pupuk";
  $total_kios_pupuk = mysqli_query($connect, $sql_kios_pupuk);
  $total_kios_pupuk = mysqli_fetch_array($total_kios_pupuk);
  $total_kios_pupuk = $total_kios_pupuk['num'];

  $sql_kios_klontongan = "SELECT COUNT(*) as num FROM kios_klontongan";
  $total_kios_klontongan = mysqli_query($connect, $sql_kios_klontongan);
  $total_kios_klontongan = mysqli_fetch_array($total_kios_klontongan);
  $total_kios_klontongan = $total_kios_klontongan['num'];

  $sql_pangkalan = "SELECT COUNT(*) as num FROM pangkalan";
  $total_pangkalan = mysqli_query($connect, $sql_pangkalan);
  $total_pangkalan = mysqli_fetch_array($total_pangkalan);
  $total_pangkalan = $total_pangkalan['num'];

  

?>






 <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>PASAR RAKYAT</h3>

              <H3><?php echo $total_pasar; ?></H3>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="././pasar_rakyat" class="small-box-footer">INFO SELENGKAPNYA  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>TOKO MODERN</h3>

           <H3><?php echo $total_toko; ?></H3>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="././toko_modern" class="small-box-footer">INFO SELENGKAPNYA  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>GUDANG</h3>

                <H3><?php echo $total_gudang; ?></H3>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="././gudang" class="small-box-footer">INFO SELENGKAPNYA  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>PANGKALAN</h3>

              <H3><?php echo $total_pangkalan; ?></H3>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="././pangkalan" class="small-box-footer">INFO SELENGKAPNYA<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>KIOS PUPUK</h3>

           <H3><?php echo $total_kios_pupuk; ?></H3>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="././kios_pupuk" class="small-box-footer">INFO SELENGKAPNYA<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>KIOS KLONTONGAN</h3>

                <H3><?php echo $total_kios_klontongan; ?></H3>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="././kios_klontongan" class="small-box-footer">INFO SELENGKAPNYA <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>









        <!-- ./col -->
      </div>
      <!-- /.row -->
      






