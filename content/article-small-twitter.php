<?php 
$obj = get_post_meta($post->ID, 'tweet_obj');
// $res = json_decode($obj);

// print_r($obj);
?>
<?php $tag = get_field('tag'); ?>
<article class="box c-<?php echo $tag[0]->slug; ?>">
    <div class="box-inner">
        <header>
            <a href="<?php the_permalink(); ?>" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-twitter"></i></div> <?php the_title(); ?></h1></a>
            <hr>
        </header>
        <div class="box-content">
            <div class="author"> <strong><?php echo $obj[0]->user->name ?></strong> <a href="<?php echo $obj[0]->user->url ?>">@<?php echo $obj[0]->user->screen_name ?></a></div>
            <?php if ($obj[0]->entities->media[0]): ?>
                <div class="image-wrapper"> 
                    <a href="<?php the_permalink(); ?>" target="_blank">
                        <img src="<?php echo $obj[0]->entities->media[0]->media_url; ?>" alt="">
                    </a>
                </div>
            <?php endif; ?>
            <p>
                <?php echo twitterify($obj[0]->text); ?>
            </p>
        </div>
    </div>
    <footer class="share">
        <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
    </footer>
</article>