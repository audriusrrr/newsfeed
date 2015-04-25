<?php $tag = get_field('tag'); ?>
<?php
$obj = get_post_meta( $post->ID, 'insta_obj' );
// echo '<div><pre>';
// var_dump($obj);
// echo '</pre></div>';

 ?>
    <div class="box-inner">
        <header>
            <a href="<?php the_field('instagram_url'); ?>" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-instagram"></i></div> <?php the_title(); ?></h1></a>
            <hr>
        </header>
        <div class="box-content">
            <?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-box' ); ?>
            <?php if ($thumbnail['0']): ?>
                <div class="image-wrapper"> 
                     <a href="<?php the_field('instagram_url'); ?>" target="_blank">
                        <img src="<?php echo $thumbnail['0']; ?>" alt="">
                    </a>
                </div>
            <?php elseif($obj[0]->thumbnail_url): ?>
                <div class="image-wrapper"> 
                     <a href="<?php the_field('instagram_url'); ?>" target="_blank">
                        <img src="<?php echo $obj[0]->thumbnail_url; ?>" alt="">
                    </a>
                </div>
            <?php elseif($obj[0]->url): ?>
                <div class="image-wrapper"> 
                     <a href="<?php the_field('instagram_url'); ?>" target="_blank">
                        <img src="<?php echo $obj[0]->url; ?>" alt="">
                    </a>
                </div>
            <?php endif; ?>
                <p>
            <?php
                echo $obj[0]->title;
             ?>
                </p>
                <a href="<?php the_field('instagram_url'); ?>" target="_blank">@<?php echo $obj[0]->author_name; ?></a>
        </div>
    </div>
    <footer class="share">
        <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
    </footer>
