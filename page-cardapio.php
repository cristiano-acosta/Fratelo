<?php get_header(); ?>

<!-- Page == Cardapio -->
		<section id="page" class="cardapio">
			<div class="container">
				<div id="conteudo" class="row">
						<article id="cardapio-article" class="span12">		<?php  while (have_posts()) : the_post(); ?>
							<h1><?php the_title(); ?></h1>
							  <p><?php the_content(); ?> </p>
							<?php endwhile; ?>
						</article>
						<hr class="span12 shadow">
					  <?php get_template_part('cardapio'); ?>
				</div>
			</div>
		</section>
<?php get_footer(); ?>