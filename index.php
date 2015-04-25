<?php get_header(); ?>

<div class="white col-sm-12">
  <div class="max-width2 white-inner" id="terms-conditions">
  <div class="clearfix"></div>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <? the_content( ); ?>
<?php endwhile; endif; ?>

  </div><!-- end of white-inner -->
</div><!-- end of white -->
<div class="clearfix"></div>
<?php get_footer(); ?>