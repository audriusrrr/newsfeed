<?php $tag = get_field('tag'); ?>
<?php
$img = get_field('tumblr_image_url');
$caption = get_field('tumblr_image_caption');
$desc = get_field('tumblr_image_description');
$blog = get_field('tumblr_blog_title');



?>
<!-- <code><pre> -->
    
<!-- </pre></code> -->
<article class="box c-<?php echo $tag[0]->slug; ?>">
    <div class="box-inner">
        <header>
            <!-- <a href="<?php the_field('tumblr_url'); ?>" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-tumblr"></i></div> <?php the_title(); ?></h1></a> -->
            <a href="<?php the_permalink(); ?>" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-tumblr"></i></div> <?php the_title(); ?></h1></a>
            <hr>
        </header>
        <div class="box-content">
            <?php if ($img): ?>
                <div class="image-wrapper"> 
                     <a href="<?php the_field('tumblr_url'); ?>" target="_blank">
                        <img src="<?php echo $img; ?>" alt="">
                    </a>
                </div>
            <?php endif; ?>
                <p>
            <?php
                if($desc):
                    echo $desc;
                else:
                    echo $caption;
                endif;
             ?>
                 <a href="<?php the_field('tumblr_url'); ?>" target="_blank"><?php echo $blog; ?></a>
                </p>
        </div>
    </div>
    <footer class="share">
        <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
    </footer>
</article>