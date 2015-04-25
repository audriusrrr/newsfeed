        <div class="col-md-4 widget-container">
          <div class="widget">
            
          <div class="purple-bg">
            <h1>inspiration delivered</h1>
          </div>
          <div class="purple-bg widget-signup-form">
          <div class="curtains-top"></div>
   <?php

if( function_exists( 'mc4wp_form' ) ) {
    mc4wp_form();
}
    ?>
          </div>
          </div>
          <div class="cleafix"></div>
<?php
dynamic_sidebar('blog');
?>

      </div><!-- end of container -->
