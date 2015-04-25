<?php $tag = get_field('tag'); ?>

<?php $img_url = get_post_meta( $post->ID, 'video_img' );  ?>
    <div class="box-inner">
        <header>
            <a href="<?php the_field('video_url'); ?>" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-play"></i></div> <?php the_title(); ?></h1></a>
            <hr>
        </header>
        <div class="box-content">
                <div class="image-wrapper video-wrapper"> 
                    <a href="<?php the_field('video_url'); ?>" target="_blank">
                        <img src="<?php echo $img_url[0]; ?>" alt="">
                        <div class="circle-md"><span class="fa fa-play fa-2x"></span></div>
                    </a>
                </div>
                <p>
                    <?php the_field('video_description'); ?>
                </p>
                <a target="_blank" href="<?php the_field('video_url'); ?>">Source</a>
        </div>
    </div>
    <footer class="share">
        <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
    </footer>
