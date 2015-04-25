<?php
/*
 * Template Name: Home
 */
get_header();
 ?>
<div class="posts-wrapper container">
    <div class="row">
        <div class="col-sm-8 description">
            <p>Qatar has ancient traditions and rich culture, and aims to be an advanced society. We envisage a vibrant and prosperous country in which there is economic and social justice for all, and in which nature and man are in harmony.</p>
            <p>Get the Facts is your go-to place for information about life in Qatar and how we are galvanizing our collective energies and directing them toward these aspirations.</p>
        </div>
        <div class="col-sm-4 hidden-xs">
            <div class="subscribe box">
                <div class="box-inner">
                    <h3>Know the facts</h3>
                    <hr>
                    <form action="" class="sub">
                        <p>Sign up for email updates</p>
                        <input type="email" name="email" placeholder="Your email address" class="input email_sub">
                        <input type="submit" name="subscribe" value="Get the latest" class="btn btn-gtf">
                        <span class="extra-info pull-left"></span>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div id="loader-wrapper">
        <div class="loader">
            <div class="spinner">
              <div class="spinner-container spinner-container1">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
              </div>
              <div class="spinner-container spinner-container2">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
              </div>
              <div class="spinner-container spinner-container3">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
              </div>
            </div>
        </div>
        <section class="posts">
        </section>
    </div>

        <div class="get-more-wrapper hidden ">
            <a href="#" class="btn btn-gtf">see more posts</a>
        </div>
        <div class="clearfix"></div>
</div>
<?php get_footer(); ?>