<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- Use the .htaccess and remove these lines to avoid edge case issues.   More info: h5bp.com/i/378 -->
	<meta http-equiv="X-UA-Compatible" content="edge,chrome=1" />
	<title>Fratello Restaurante | Restaurante e Pizzaria - Porto Alegre</title>
	<!-- SEO MetaTags -->
	<!-- SEO MetaTags -->
	<meta name="description" content="<?php bloginfo('name'); echo ' | '; bloginfo( 'description' ); ?>" />
	<meta name="author" content="EZ Comunicacao" />
	<meta name="keywords" content="<?php get_the_tags($post->ID); ?>" />
	<meta name="robots" content="index,follow" />
	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width" />
	<!-- Wordpress metatags -->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	<link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/favicon.ico" type="image/x-icon"/>
	<!-- .css -->
	<link href='<?php bloginfo( 'template_url' ); ?>/css/bootstrap.min.css' rel='stylesheet' />
	<link href='<?php bloginfo( 'template_url' ); ?>/css/bootstrap-responsive.min.css' rel='stylesheet'/>
	<link href='<?php bloginfo( 'template_url' ); ?>/ttf/font.css' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" media="all"  href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <!-- All JavaScript at the bottom, except this Modernizr build. Modernizr enables HTML5 elements & feature detects for optimal performance. Create your own custom Modernizr build: www.modernizr.com/download/ -->
	<script src="<?php bloginfo( 'template_url' ); ?>/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<?php
		//include(TEMPLATEPATH . '/neosmart-stream/setup.php');
		//$nss->getHead();
	?>
	<?php wp_head(); ?>
</head>
<body>
<header id="header" class="header-<?php if (is_front_page()) { echo 'home'; } else { /*the_ID();*/ the_slug(); } ?>"  >
	<nav class="navigation">
    <div class="container">
      <div class="navbar">
        <!-- Be sure to leave the brand out there if you want it shown -->
	      <a class="brand" href="<?php bloginfo( 'url' ); ?>/" title="<?php bloginfo('name'); ?>" >
						<img alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_url' ); ?>/img/fratello.brand.png" />
				</a>
	      <!-- .btn-navbar is used as the toggle for collapsed navbar content
	      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
				</a> -->
	      <!-- Everything you want hidden at 940px or less, place within here -->
	      <div class="menu">
		      <!-- .nav, .navbar-search, .navbar-form, etc -->
		      <?php
						$args = array( 'container'  => false, 'menu_class' => 'nav', 'walker' => new Bootstrap_Walker_Nav_Menu);
						wp_nav_menu( $args );
					?>
	      </div>
      </div>
    </div>
  </nav>
	<?php //if (is_front_page()) { get_template_part( 'background', 'slides' ); } ?>
</header>
