<?php get_header(); ?>
<!-- Page == espaco -->
		<section id="page" class="espaco">
			<div class="container">
				<div id="conteudo" class="row">
					<article id="espaco-article" class="span12">
						<?php  while (have_posts()) : the_post(); ?>
							<h1><?php the_title(); ?></h1>
							<?php the_content(); ?>
						<?php endwhile; ?>
					</article>
					<hr class="span12 shadow">
					<?php $pagechild = new WP_Query(array('post_type' => 'page', 'post_parent' => $post->ID));
						while ($pagechild->have_posts()) : $pagechild->the_post(); ?>
                  <article id="espaco-kids" class="span12">
                     <h1><?php the_title(); ?></h1>
                     <?php the_content(); ?>
                  </article>
               <?php endwhile; ?>
				</div>
			</div>
		</section>
<?php get_footer(); ?>