<?php 
$get_class = "c-economy-commerce"
 ?>
<article class="box <?php echo $get_class; ?>">
    <div class="box-inner">
        <header>
            <a href="#" target="_blank"><h1><div class="i-circle i-circle-xs"><i class="fa fa-comments"></i></div> hm <?php the_title(); ?></h1></a>
            <hr>
        </header>
        <div class="box-content">
        <?php the_content(); ?>
        </div>
    </div>
    <footer class="share">
        <div class="share-post"></div>
    </footer>
</article>