<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title><?php is_home() ? bloginfo( 'description' ) : wp_title( '' ); ?> | <?php bloginfo( 'name' ); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" type="image/ico" rel="shortcut icon">
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Style Sheets -->
        <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
        <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <?php wp_head();dynamic_css(); ?>
        <?php $client_wants_menu = true; ?>
    </head>
    <body>
        <div class="body-wrap">
            <header id="header">
                <nav id="primary" class="navbar" role="navigation">
                    <div class="navbar-header">
                    <?php if ($client_wants_menu): ?>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    <?php endif; ?>
                    </div>
                    <div class="get-the-facts">
                        <a href="<?php bloginfo('url'); ?>" class="logo">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="Get The Facts" id="logo">
                        </a>
                    </div>
                    <div class="container">
                    <div class="row">
                    <?php if ($client_wants_menu): ?>
                    <div class="collapse navbar-collapse" id="menu"></div>
                    <?php endif; ?>
                    <div id="categories">
                            <?php if( have_rows('navigation_repeater', 'options') ) : ?>
                        <ul class="nav">
                                    <li class="filter-issue" ><span>Filter by issue:</span></li>
                                    <?php while( have_rows('navigation_repeater', 'options') ) : the_row(); ?>
                                        <?php $tag = get_sub_field('header_tag'); ?>
                                        <li class="inactive c c-c c-<?php echo $tag->slug; ?>" data-ID="<?php echo $tag->term_id; ?>" data-slug="<?php echo $tag->slug; ?>"><a href="#<?php echo $tag->slug; ?>"><?php echo $tag->name; ?></a></li>
                                        <!-- <li class="divider">|</li> -->
                                    <?php endwhile; ?>
                            <li class="filter-platform" ><span>Filter by platform:</span></li>
                            <li class="c c-circles">
                                <a href="#facebook" class="i-circle i-circle-xs secTag inactive" data-field="facebook"><i class="fa fa-facebook"></i></a>
                                <a href="#instagram" class="i-circle i-circle-xs secTag inactive" data-field="instagram"><i class="fa fa-instagram"></i></a>
                                <a href="#tumblr" class="i-circle i-circle-xs secTag inactive" data-field="tumblr"><i class="fa fa-tumblr"></i></a>
                                <a href="#twitter" class="i-circle i-circle-xs secTag inactive" data-field="twitter"><i class="fa fa-twitter"></i></a>
                                <a href="#video" class="i-circle i-circle-xs secTag inactive" data-field="video"><i class="fa fa-play"></i></a>
                                <a href="#other" class="i-circle i-circle-xs secTag inactive" data-field="other"><i class="fa fa-comments"></i></a>
                            </li>
                            <!-- <li class="divider pull-right">|</li> -->
                            <li class="c remove-filters c-remove-filters filters-inactive pull-right"><a disabled href="#">Remove filters</a></li>
                        </ul>
                            <?php endif; ?>
                    </div>
                    </div>
                    </div>
                </nav>
                <div class="clearfix"></div>
            </header>