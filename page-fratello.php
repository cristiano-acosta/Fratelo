<?php get_header(); ?>

<!-- Page == home -->
		<section id="page">
			<div class="container">
				<div id="conteudo" class="row">
						<div id="chromefix" class="clearfix"></div>
					<div id="page-home" class="span12">
						<div class="row">
							<?php while (have_posts()) : the_post(); ?>
                <article class="page-<?php the_ID(); ?> span7">
                  <h1><?php /*<img src="<?php bloginfo('template_url'); ?>/img/title/fratello.png" alt="<?php //the_title(); ?>">*/?><?php the_title(); ?></h1>
                        <?php /*<p class="the_excerpt"  ><?php excerpt('20'); ?></p>
                        <p id="more"> Veja mais... </p> */ ?>
                    <div class="">	<?php the_content(); ?></div>
                </article>
		            <figure class="span5">
				          <?php the_post_thumbnail( '', array( 'class' => '' ) ); ?>
		            </figure>
							<?php endwhile; // end of the loop. ?>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php get_footer(); ?>