<?php $tag = get_field('tag'); ?>
<?php
// $obj_str = get_field('facebook_api_return');
// $obj = json_decode($obj_str);
// $img = $obj[0]->images[2]->source;
// $author = $obj[0]->from->name;
// $name = $obj[0]->name;



         $img =  get_field('facebook_image_url');
         $author =  get_field('facebook_author');
         $name =  get_field('post_name');
?>

<div class="box-inner">
<header>
    <a href="<?php the_permalink(); ?>" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-facebook"></i></div> <?php the_title(); ?></h1></a>
    <hr>
</header>
<div class="box-content">
    <?php if ($img): ?>
        <div class="image-wrapper"> 
             <a href="<?php the_field('facebook_status_url'); ?>" target="_blank">
                <img src="<?php echo $img ?>" alt="">
            </a>
        </div>
    <?php endif; ?>
        <p>
    <?php if($name): ?>
        <blockquote>
            <p><?php echo $name; ?></p>
        </blockquote>
    <?php endif; ?>
             <a href="<?php the_field('facebook_status_url'); ?>" target="_blank">
             <?php echo $author; ?>
             </a>
        </p>
</div>
</div>
<footer class="share">
    <div data-url="<?php the_permalink(); ?>" class="share-post"></div>
</footer>
