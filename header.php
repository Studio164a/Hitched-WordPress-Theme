<!DOCTYPE html> 
<html <?php language_attributes() ?>> 
<head>
    <meta charset="<?php bloginfo( 'charset' ) ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><?php wp_title( "&raquo;", true ) ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ) ?>
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
		<header id="header" class="page">
			<div id="site_title"><?php echo hitched_get_option('groom') ?> <span class="ampersand">&</span> <?php echo hitched_get_option('bride') ?></div>

			<div id="page_title">
				<a href="<?php echo hitched_page_permalink() ?>"><h1><?php echo hitched_page_title() ?></h1></a>
			</div>	
		</header>
		<!-- End header -->