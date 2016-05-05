<?php if(get_post_type() != 'location' && get_post_type() != 'feature'){ ?>
<time class="published" datetime="<?php echo get_the_time('c'); ?>">Posted <?php echo get_the_date(); ?></time>
<?php } ?>
