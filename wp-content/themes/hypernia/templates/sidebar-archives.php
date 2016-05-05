<div class="hidden-xs hidden-sm col-md-3 news-archive">
	<div class="news-header"><em>Archived News</em></div>
	<div class="news-list">
		<?php
		$archives = wp_get_archives(array(
			'type'            => 'monthly',
			'limit'           => '',
			'format'          => 'custom',
			'before'          => '',
			'after'           => '|',
			'show_post_count' => true,
			'echo'            => 0,
			'order'           => 'DESC'
		));

		$archives = explode('|',trim($archives));
		$currentYear = 0;

		foreach($archives as $archive){
			if($archive != '') {
				$found = preg_match( '/\d{4}/', $archive, $match );
				if ( $found && $currentYear != $match[0] ) {
					$currentYear = $match[0];
					echo '<div class="archive-year">' . $currentYear . '</div>';
				}

				echo '<div class="archive-link"><i class="fa fa-caret-right"></i>  ' . str_replace( ' ' . $currentYear, '', $archive ) . '</div>';
			}
		}
		?>
	</div>
</div>