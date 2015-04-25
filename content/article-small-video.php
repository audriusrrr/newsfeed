<?php $tag = get_field('tag'); ?>

<?php $img_url = get_post_meta( $post->ID, 'video_img' );  ?>
<article class="box c-<?php echo $tag[0]->slug; ?>">
    <div class="box-inner">
        <header>
            <a href="<?php the_permalink(); ?>" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-play"></i></div> <?php the_title(); ?></h1></a>
            <hr>
        </header>
        <div class="box-content">
                <div class="image-wrapper video-wrapper"> 
                    <a href="<?php the_permalink(); ?>" target="_blank">
                        <img src="<?php echo $img_url[0]; ?>" alt="">
                        <div class="circle-md"><span class="fa fa-play fa-2x"></span></div>
                    </a>
                </div>
                <p>
                    <?php the_field('video_description'); ?>
                </p>
        </div>
    </div>
    <footer class="share">
        <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
    </footer>
</article>