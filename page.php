<?php
get_header();
?>
  <?php if (have_posts()) :   while (have_posts()) : the_post(); ?>
    
<div class="posts-wrapper container">
  <article class="box big-box c-inner">
<?php 
get_template_part('content/article');
?>
  </article>
</div>
     
<?php endwhile;endif;?>
<?php get_footer(); ?>