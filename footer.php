            <footer id="footer">
                <div class="container">
                <ul class="nav footer-nav">
                        <?php if( have_rows('footer_menu_repeater', 'options') ) : ?>
                                <?php while( have_rows('footer_menu_repeater', 'options') ) : the_row(); ?>
                                    <?php $name = get_sub_field('footer_name'); ?>
                                    <?php $url = get_sub_field('footer_url'); ?>
                                    <li class="c-c"><a href="<?php echo $url; ?>" target="_blank"><?php echo $name; ?></a></li>
                                    <!-- <li class="divider">|</li> -->
                                <?php endwhile; ?>
                        <?php endif; ?>

                        <?php if( have_rows('social_repeater', 'options') ) : ?>
                    <li class="c c-circles">
                                <?php while( have_rows('social_repeater', 'options') ) : the_row(); ?>
                                    <?php $soc = get_sub_field('social_network'); ?>
                                    <?php $url = get_sub_field('social_url'); ?>
                                    <a href="<?php echo $url; ?>" target="_blank" class="i-circle i-circle-xs"><i class="fa fa-<?php echo $soc; ?>"></i></a>
                                <?php endwhile; ?>
                    </li>
                        <?php endif; ?>
                </ul>
                </div>
            </footer>
        </div>
    <?php wp_footer(); ?>
    </body>
</html>