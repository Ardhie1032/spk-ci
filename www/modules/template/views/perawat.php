<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?=$title;?></title>
        <!-- Bootstrap framework -->
        <?= css('bootstrap.min.css')?>
        <?= css('bootstrap-responsive.min.css')?>
        <!-- breadcrumbs-->
        <link rel="stylesheet" href="<?=asset_url()?>lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- gebo blue theme-->
        <?= css('green.css')?>
        <!-- splashy icons -->
        <link rel="stylesheet" href="<?=base_url();?>assets/img/splashy/splashy.css" />
        
        <!-- tooltips-->
        <?= css('jquery.qtip.min.css')?>
        <!-- main styles -->
        <?= css('style.css')?>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
	
        <!-- Favicon -->
            <link rel="shortcut icon" href="favicon.ico" />
		
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/ie.css" />
            <?= js('html5.js')?>
            <?= js('respond.min.js')?>
            <?= js('excanvas.min.js')?>
        <![endif]-->
		
		<script>
			//* hide all elements & show preloader
			document.getElementsByTagName('html')[0].className = 'js';
		</script>
				
    </head>
    <body>
   		<!-- SOME LOADING -->
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="brand" href="<?php echo base_url();?>">Dashboard Panel</a>
                            
                            <ul class="nav user_menu pull-right">
                            <li class="divider-vertical hidden-phone hidden-tablet"></li>
                            	<li class="dropdown">
                                	<div class="btn-group pull-right">
										<button class="btn btn-success"><i class="icon-user icon-white"></i> <?php echo $welcome;?></button>
										<button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>
										</button>
                                    <ul class="dropdown-menu">
										<li><a href="<?=base_url()?>index.php/auth/change_password"><i class="splashy-contact_blue_edit"></i> Pengaturan Akun</a></li>
										<li><a href="<?=base_url()?>index.php/auth/edit_user"><i class="splashy-view_list"></i> Manajemen User</a></li>
										<li class="divider"></li>
										<li><a href="<?=base_url()?>auth/logout"><i class="icon-off"></i> Log Out</a></li>
                                    </ul>
           							</div>
                                </li>
                            </ul>
							<a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu">
								<span class="icon-align-justify icon-white"></span>
							</a>
                            <nav>
                                <div class="nav-collapse">
                                    <ul class="nav">
                                    	<li class="divider-vertical hidden-phone hidden-tablet"></li>
                                    	<li>
                                            <a href="<?=site_url();?>/"><i class="icon-home icon-white"></i> Home</a>
                                        </li>
                                        	<li class="divider-vertical hidden-phone hidden-tablet"></li>
                                        <li>
                                            <a href="<?=base_url();?>kesimpulan/index"><i class="icon-th icon-white"></i> Kesimpulan</a>
                                        </li>
                                        	<li class="divider-vertical hidden-phone hidden-tablet"></li>
										<li>
                                            <a href="#"> <i class="splashy-documents"></i> Hasil</a>
                                        </li>
                                       
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div> <!-- end navbar navbar-fixed-top -->
            </header>
            
            <!-- main content -->
             <div id="contentwrapper">
                <div class="main_content">
				<nav>
					<div id="jCrumbs" class="breadCrumb module">
					<?= '<a href="#"><i class="icon-home"></i></a>'.' > '.set_breadcrumb()?>
					</div>
				</nav>
				<?php 
 					$this->load->view($module.'/'.$view);
 				?>
                </div>
                    
            <!--  Place Sidebar Here! -->

            <!-- ttip_r -->
            <a href="javascript:void(0)" class="sidebar_switch on_switch" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<div class="antiScroll">
					<div class="antiscroll-inner">
						<div class="antiscroll-content">
							<div class="sidebar_inner">
							<!-- search action -->
								<form action="#" class="input-append" method="post" >
									<input autocomplete="off" name="query" class="search_query input-medium" size="16" type="text" placeholder="Cari.. " />
									<button type="submit" class="btn"><i class="icon-search"></i></button>
								</form>
								
								<div id="side_accordion" class="accordion">

									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseFour" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												<i class="splashy-calendar_month"></i> INFO
											</a>
										</div>
									<div class="accordion-body collapse in" id="collapseFour">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li>
													&copy; 2013 by M.Desta Fadilah
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
									<div class="push"></div>
							</div> <!-- END SIDEBAR INNER -->
							
							<!-- BISA BUAT NOTIFIKASI
							<div class="sidebar_info">
								<ul class="unstyled">
									<li>
										<span class="act act-warning">65</span>
										<strong>New comments</strong>
									</li>
									<li>
										<span class="act act-success">10</span>
										<strong>New articles</strong>
									</li>
									<li>
										<span class="act act-danger">85</span>
										<strong>New registrations</strong>
									</li>
								</ul>
							</div>
							-->
						</div> <!-- End Antiscroll-content -->
					</div> <!-- End Antriscroll-intent -->
				</div>
			</div>
            <!--  End Of Sidebar! -->
            
			<!-- BOOTSTRAP ENGINGE -->
            <?= js('jquery.min.js')?>
			<!-- smart resize event -->
			<?= js('jquery.debouncedresize.min.js')?>
			<!-- hidden elements width/height -->
			<?= js('jquery.actual.min.js')?>
			<!-- js cookie plugin -->
			<?= js('jquery.cookie.min.js')?>
			<!-- main bootstrap js -->
			<?= js('bootstrap.min.js')?>
			<!-- tooltips -->
			<?= js('jquery.qtip.min.js')?>
			<!-- fix for ios orientation change -->
			<?= js('ios-orientationchange-fix.js')?>
			<!-- jBreadcrumbs -->
			<script type="text/javascript" src="<?=asset_url();?>lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js"></script>

			<!-- scrollbar -->
			<script type="text/javascript" src="<?=asset_url();?>lib/antiscroll/antiscroll.min.js"></script>
			<script type="text/javascript" src="<?=asset_url();?>lib/antiscroll/jquery-mousewheel.js"></script>
			
			<!-- common functions -->
			<?= js('gebo_common.js')?>
			
			<!-- jquery validation -->
			<?= js('jquery.validate.min.js')?>
			<!-- validation functions -->
			<?= js('gebo_validation.js')?>
		
			<script>
				$(document).ready(function() {
					//* show all elements & remove preloader
					setTimeout('$("html").removeClass("js")',1000);
				});
			</script>
		
		  </div>


      <footer class="well">
        <p>Okelah</p>
      </footer>

    </div>

	</body>
</html>