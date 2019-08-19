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
            <a href="../pasar_rakyat" class="small-box-footer">INFO SELENGKAPNYA<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="../toko_modern" class="small-box-footer">INFO SELENGKAPNYA<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="../pasar_rakyat" class="small-box-footer">INFO SELENGKAPNYA<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="../toko_modern" class="small-box-footer">INFO SELENGKAPNYA<i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>









        <!-- ./col -->
      </div>
      <!-- /.row -->
      


















<div class="row">
    <div class="col-sm-4">
        <a href="<?php echo site_url('myigniter/crud_builder') ?>" title="<?php echo lang('crud_builder') ?>" class="box-feature box-feature-light-blue text-center">
            <i class="fa fa-table fa-3x"></i> <span><?php echo lang('crud_builder') ?></span>
        </a>    
    </div>
    <div class="col-sm-4">
        <a href="<?php echo site_url('myigniter/page_builder') ?>" title="<?php echo lang('page_builder') ?>" class="box-feature box-feature-green text-center">
            <i class="fa fa-file-o fa-3x"></i> <span><?php echo lang('page_builder') ?></span>
        </a>
    </div>
    <div class="col-sm-4">
        <a href="<?php echo site_url('myigniter/modules') ?>" title="<?php echo lang('modular_extension') ?>" class="box-feature box-feature-orange text-center">
            <i class="fa fa-th fa-3x"></i> <span><?php echo lang('modular_extension') ?></span>
        </a>
    </div>
</div>

<div class="row margin-top">
    <div class="col-sm-4">
        <a href="<?php echo site_url('myigniter/database') ?>" title="Add Table" class="box-feature box-feature-green text-center">
            <i class="fa fa-database fa-3x"></i> <span>Database</span>
        </a>
    </div>
</div>










<div class="row margin-top">
    <div class="col-md-4">
        <!-- USERS LIST -->
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Users</h3>
                <div class="box-tools pull-right">
                    <span class="label label-danger"><?php echo $total_users ?> New Users</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="users-list clearfix">
                    <?php foreach ($users as $key => $user) { ?>
                    <li>
                        <?php if (filter_var($user->photo,FILTER_VALIDATE_URL)): ?>
                            <img src="<?php echo $user->photo; ?>" class="img-circle" alt="<?php echo $user->full_name ?>"/>
                        <?php else: ?>
                            <img src="<?php echo $user->photo == '' ? base_url('assets/img/logo/kotaxdev.png') : base_url('assets/uploads/image/'.$user->photo) ?>" class="img-circle" alt="<?php echo $user->full_name ?>"/>
                        <?php endif; ?>
                        <a class="users-list-name" title="<?php echo $user->full_name ?>" href="#"><?php echo $user->full_name ?></a>
                        <span class="users-list-date"><?php echo time_elapsed_string($user->created_on) ?></span>
                    </li>
                    <?php } ?>
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <a href="<?php echo site_url('myigniter/users') ?>" class="uppercase">View All Users</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!--/.box -->
    </div>
</div>