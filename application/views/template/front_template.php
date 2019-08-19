<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <?php echo $this->layout->get_meta_tags() ?>
    <?php echo $this->layout->get_title() ?>
    <?php echo $this->layout->get_favicon() ?>
    <?php echo $this->layout->get_schema() ?>
    <?php
        $path = [
            'assets/plugins/bootstrap/dist/css/bootstrap.min.css',
            'assets/plugins/AdminLTE/dist/css/AdminLTE.min.css',
            'assets/plugins/AdminLTE/dist/css/skins/skin-'.$this->config->item('skin').'.min.css',
            'assets/plugins/font-awesome/css/font-awesome.min.css',
            'assets/plugins/flag-icon-css/css/flag-icon.min.css',
        ];
        if (isset($css_plugins)) {
            foreach ($css_plugins as $key => $value) {
                $path[] = $value;
            }
        }
        $path[] = 'assets/css/front.css';
    ?>
    <?php $this->layout->set_assets($path, 'styles') ?>
    <?php echo $this->layout->get_assets('styles') ?>
</head>
<body class="hold-transition skin-<?php echo $this->config->item('skin') ?> layout-top-nav">
    <!-- Site wrapper -->
    <div class="wrapper"> 
        <header class="main-header">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <a href="<?php echo site_url() ?>" class="navbar-brand">MENJANGAN-GO</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                      <?php $menus = $this->layout->get_menu('top menu'); ?>
                      <ul class="nav navbar-nav">
                        <?php foreach ($menus as $menu): ?>
                            <?php if (is_array($menu['children'])): ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu['label'] ?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($menu['children'] as $menu2): ?>
                                            <li><a href="<?php echo base_url($menu2['link']) ?>"><?php echo $menu2['label'] ?></a></li>
                                        <?php endforeach ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li><a href="<?php echo base_url($menu['link']) ?>"><?php echo $menu['label'] ?></a></li>
                            <?php endif ?>
                        <?php endforeach ?>
                      </ul>
                    </div><!-- /.navbar-collapse -->

                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <?php if (!$this->ion_auth->logged_in()): ?>
                                <li><a href="<?php echo site_url('login') ?>" title="Login"><i class="fa fa-sign-in fa-fw"></i> <?php echo lang('login') ?></a></li>
                                <li><a href="<?php echo site_url('register') ?>" title="Sign Up"><?php echo lang('signup') ?></a></li>
                            <?php else: ?>
                                <li class="dropdown user user-menu">
                                    <?php $user = $this->ion_auth->user()->row() ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <?php if (filter_var($user->photo,FILTER_VALIDATE_URL)): ?>
                                            <img src="<?php echo $user->photo; ?>" class="user-image" alt="<?php echo $user->full_name ?>"/>
                                        <?php else: ?>
                                            <img src="<?php echo $user->photo == '' ? base_url('assets/img/logo/kotaxdev.png') : base_url('assets/uploads/image/'.$user->photo) ?>" class="user-image" alt="<?php echo $user->full_name ?>"/>
                                        <?php endif; ?>
                                        <span class="hidden-xs"><?php echo $user->username ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="user-header">
                                            <?php if (filter_var($user->photo,FILTER_VALIDATE_URL)): ?>
                                                <img src="<?php echo $user->photo; ?>" class="img-circle" alt="<?php echo $user->full_name ?>"/>
                                            <?php else: ?>
                                                <img src="<?php echo $user->photo == '' ? base_url('assets/img/logo/kotaxdev.png') : base_url('assets/uploads/image/'.$user->photo) ?>" class="img-circle" alt="<?php echo $user->full_name ?>"/>
                                            <?php endif; ?>
                                            <p>
                                              <?php echo $user->full_name ?>
                                              <small><?php echo lang('last_login') ?> <?php echo ' '.date('d/m/Y H:i', $user->last_login); ?></small>
                                            </p>
                                        </li>
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="<?php echo  site_url('myigniter/profile')?>" class="btn btn-default btn-flat"><?php echo lang('profile') ?></a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="<?php echo  site_url('logout')?>" class="btn btn-default btn-flat"><?php echo lang('logout') ?></a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="flag-icon flag-icon-<?php echo $this->session->userdata('lang_code') ? $this->session->userdata('lang_code') : 'us' ?>"></span> <?php echo lang('language') ?>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo site_url('myigniter/sys_lang/english'); ?>"><span class="flag-icon flag-icon-us"></span> US English</a></li>
                                    <li><a href="<?php echo site_url('myigniter/sys_lang/indonesian'); ?>"><span class="flag-icon flag-icon-id"></span> Indonesian</a></li>
                                    <li><a href="<?php echo site_url('myigniter/sys_lang/italian'); ?>"><span class="flag-icon flag-icon-it"></span> Italian</a></li>
                                    <li><a href="<?php echo site_url('myigniter/sys_lang/arabic'); ?>"><span class="flag-icon flag-icon-eg"></span> Arabic</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Full Width Column -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content exspan-bottom">
                <?php echo $this->layout->get_wrapper('page') ?>
            </section><!-- /.content -->
        </div><!-- ./wrapper -->
        <footer class="main-footer">
            <div class="container">            
                <div class="pull-right hidden-xs">
                    
                </div>
                <strong>Copyright &copy; <?php echo date('Y') ?> <a href="">Nash</a>.</strong> All rights reserved.
            </div>
        </footer>
    </div>
    <?php
        $path = [
            'assets/plugins/jquery/dist/jquery.min.js',
            'assets/plugins/bootstrap/dist/js/bootstrap.min.js',
            'assets/plugins/AdminLTE/dist/js/app.min.js',
        ];
        if (isset($js_plugins)) {
            foreach ($js_plugins as $key => $value) {
                $path[] = $value;
            }
        }
        $path[] = 'assets/js/a-design.js';
    ?>
    <?php $this->layout->set_assets($path, 'scripts') ?>
    <?php echo $this->layout->get_assets('scripts') ?>
</body>
</html>