<!DOCTYPE html> 
<html dir="ltr" lang="en-US"> 
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title><?php wp_title( "&raquo;", true ) ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php wp_head() ?> 	
</head>
<body <?php body_class() ?>>

	<nav id="primary_nav">
		<div class="menu-button">Menu <i class="float_right icon-chevron-down icon-large"></i></div>
		<?php wp_nav_menu( array(
			'theme_location' => 'primary_navigation', 
			'container' => false,
			'menu_class' => 'responsive_menu'
		) ) ?>
	</nav>

	<div id="container" class="wrapper">		

		<!-- Header -->
		<header id="header" class="home">

			<hgroup>
				<h1 id="site_title"><?php echo hitched_get_option('groom') ?> <span class="ampersand">&</span> <?php echo hitched_get_option('bride') ?></h1>
				<h3><?php echo hitched_get_option('where_when') ?></h3>
			</hgroup>

			<!-- Slider -->
			<?php get_template_part( 'slider' ) ?>			
			<!-- End slider -->
			
		</header>
		<!-- End header -->