<div id="brands" class="container">
	<div class="row">
		<p>hypernia brands</p>
		<?php
        $logos = new WP_Query(
            array(
                'post_type' => 'logo',
                'order' => 'ASC',
                'meta_key' => 'logos_text_order',
                'orderby' => 'meta_value_num',
                'nopaging' => true
            )
        );
		$i = 0;
		$hasNext = true;
		$total = $logos->post_count;
		$fits = 3;
		$fitted = 0;
		$rows = $total / 3;

        while($hasNext): $logos->the_post();
            $hasNext = $logos->have_posts();

	        if($fitted == $fits) {
		        $fitted = 0;
		        if ( $rows < 1 ) {
			        if ( $rows < 0.68 && $rows > 0.34 ) {
				        $fits = 2;
			        } else {
				        $fits = 1;
			        }
		        }
	        }

            $title = get_the_title();
            $id = get_post_thumbnail_id();
            $meta = wp_get_attachment_metadata($id,true);
            $image = wp_get_attachment_url($id, 'single-post-thumbnail');

            $target = '_blank';
            $url = '';
            $url = get_post_meta(get_the_ID(), 'logos_text_link', true);
            if($url == ''){
	            $url = get_the_permalink();
	            $target = '_self';
            }

            $link = '<a href="' . $url . '" target="' . $target . '" title="' . $title . '" style="width:' . $meta['width'] .'px;height:' . ($meta['height'] / 2) .'px;display:block;margin: 0 auto;text-align:center;background-image:url(' . $image .');"></a>';

            if($i % 3 == 0){
	            echo '<div class="clearfix visible-xs-block"></div>';
            }

            echo '<div class="col-xs-12 col-sm-' . (12 / $fits) . ' brand-logo">' . $link . '</div>';

	        $total--;
	        $fitted++;
	        $rows = $total / 3;
            $i++;
        endwhile;
        wp_reset_query();
        ?>
	</div>
</div>
<footer class="content-info" role="contentinfo">
    <div class="container">
	    <?php if(is_active_sidebar('sidebar-footer')){ ?>
		    <div class="row menus">
	            <?php dynamic_sidebar('sidebar-footer'); ?>
		    </div>
		    <div class="row">
			    <div class="col-xs-12">
				    <hr/>
			    </div>
	        </div>
	    <?php } ?>
        <div class="row">
	        <div class="col-xs-12">
				<div class="center">
                    <p><img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-footer.jpg"/> Copyright &copy; 2010-<?php echo date('Y'); ?> <strong>Hypernia Corporation</strong>. All Rights Reserved.</p>
	            </div>
	        </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>