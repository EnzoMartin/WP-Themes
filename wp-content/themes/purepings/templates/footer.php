<div id="footer-banner">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 hidden-xs">
                <h5><?php echo get_option('purepings_bannerheading'); ?></h5>
                <h6><?php echo get_option('purepings_bannersubheading'); ?></h6>
            </div>
	        <div class="col-xs-12 col-sm-4 button-col">
                <a class="btn btn-order" href="<?php echo get_option('purepings_bannerurl'); ?>"><?php echo get_option('purepings_bannerurltext'); ?></a>
            </div>
        </div>
    </div>
</div>
<footer class="content-info" role="contentinfo">
    <div class="container">
        <div class="row menus">
            <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>
    </div>
</footer>
<footer id="footer-links" class="content-info" role="contentinfo">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-5">
	            <div class="align-container">
                    <p>&copy; <?php echo date('Y'); ?> PurePings.com All Rights Reserved.</p>
	            </div>
            </div>
	        <div class="col-xs-12 col-sm-7">
		        <div class="align-container">
                    <?php dynamic_sidebar('footer-links'); ?>
		        </div>
            </div>
        </div>
        <div class="row">
            <div id="hypernia-logo" class="col-xs-12">
                <a href="http://hypernia.com/"><img src="<?php echo get_bloginfo('template_directory') . '/assets/img/hypernia_logo.png'; ?>"/></a>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>