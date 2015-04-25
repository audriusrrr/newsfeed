<?php
get_header();
?>
  <?php if (have_posts()) :   while (have_posts()) : the_post(); ?>
    <?php 
    $tag = get_field('tag');
    $type = get_field('type_of_post');
    

     ?>
<div class="posts-wrapper container">
  <article class="box big-box c-inner c-<?php echo $tag[0]->slug; ?>">
<?php 
	if($type == 'tumblr'):
    	get_template_part( 'content/article', 'inner-tumblr' );
 	elseif($type == 'facebook'):
	    get_template_part( 'content/article', 'inner-facebook' );
  	elseif($type == 'instagram'):
	    get_template_part( 'content/article', 'inner-instagram' );
	elseif($type == 'twitter'):
	    get_template_part( 'content/article', 'inner-twitter' );
 	 elseif($type == 'video'):
	    get_template_part( 'content/article', 'inner-video' );
  	elseif($type == 'other'):
	    get_template_part( 'content/article', 'inner-other' );
  	else:
		get_template_part('content/article');
	endif;
?>
  </article>
</div>
     
<?php endwhile;endif;?>
<?php get_footer(); ?>