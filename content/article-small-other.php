<?php $tag = get_field('tag'); ?>
<article class="box c-<?php echo $tag[0]->slug; ?>">
    <div class="box-inner">
        <header>
            <a target="_blank" href="<?php the_permalink(); ?>"><h1><div class="i-circle i-circle-xs"><i class="fa fa-comments"></i></div> <?php the_title(); ?></h1></a>
            <hr>
        </header>
        <div class="box-content">
            <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-box' ); ?>
            <?php if ($thumbnail['0']): ?>
                <div class="image-wrapper"> 
                    <a target="_blank" href="<?php the_permalink(); ?>">
                        <img src="<?php echo $thumbnail['0']; ?>" alt="">
                    </a>
                </div>
            <?php endif; ?>
            <?php 
                the_field('other_text');
             ?>
        </div>
    </div>
    <footer class="share">
        <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
    </footer>
</article>