<div class="box-inner">
<header>
    <h1><?php the_title(); ?></h1>
    <hr>
</header>
<div class="box-content">
    <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'big-box' ); ?>
    <?php if ($thumbnail['0']): ?>
        <div class="image-wrapper">
	        <img src="<?php echo $thumbnail['0']; ?>" alt="">
        </div>
    <?php endif; ?>
    <?php the_content(); ?>
</div>
</div>
<footer class="share">
    <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
</footer>
