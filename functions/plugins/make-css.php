<?php
function dynamic_css() {
?>
    <style type="text/css">

<?php if( have_rows('navigation_repeater', 'options') ) : ?>
		<?php while( have_rows('navigation_repeater', 'options') ) : the_row(); 
			$color = get_sub_field('tag_color'); 
			$tag = get_sub_field('header_tag');
		?>
#categories .c-<?php echo $tag->slug; ?> a { color: <?php echo $color; ?>; }
#categories .c-<?php echo $tag->slug; ?> a:hover { text-decoration: underline; }
#categories .c-<?php echo $tag->slug; ?>.active a{ background-color: <?php echo $color; ?>; color: #fff; }
#categories .c-<?php echo $tag->slug; ?> a { -webkit-transition: all 0.3s ease-in-out; -moz-transition: all 0.3s ease-in-out; -o-transition: all 0.3s ease-in-out; transition: all 0.3s ease-in-out; }
.box.c-<?php echo $tag->slug; ?> { border-top-color: <?php echo $color; ?>; }
.box.c-<?php echo $tag->slug; ?> h1:hover, .box.c-<?php echo $tag->slug; ?> h1:active, .box.c-<?php echo $tag->slug; ?> h1:focus { color: <?php echo $color; ?>; }
.box.c-<?php echo $tag->slug; ?> h1:hover .i-circle, .box.c-<?php echo $tag->slug; ?> h1:active .i-circle, .box.c-<?php echo $tag->slug; ?> h1:focus .i-circle { background-color: <?php echo $color; ?>; }

		<?php endwhile; ?>
<?php endif; ?> ?>
    </style>
<?php
}
