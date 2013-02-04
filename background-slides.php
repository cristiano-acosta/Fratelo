<!-- get_template_part( 'background', 'slides' ); -->
<div id="slide">
	
		<ul class="rslides">
			<?php
				$slides = new WP_Query( array( 'post_type' => 'slide','order' => 'ASC', 'posts_per_page' => -1,  ) );
				while ( $slides->have_posts() ) : $slides->the_post();
				if ( has_post_thumbnail() ) {
			?>
				<li>
					<?php the_post_thumbnail( '', array( 'class' => 'full' )  ); ?>
				</li>
			<?php } endwhile; /* End loop */ ?>
			<?php wp_reset_query(); ?>
		</ul>

</div>
