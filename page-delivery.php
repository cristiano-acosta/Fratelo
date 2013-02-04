<?php get_header(); ?>
	<!-- Page == delivery -->
		<section id="page" class="delivery">
			<div class="container">
				<div id="conteudo" class="row">
					<article id="delivery-article" class="span12">
						<div class="row">
						<?php  while (have_posts()) : the_post(); ?>
							<h1 class="span12"><?php the_title(); ?></h1>
							<div class="content span8">
								<?php the_content(); ?>
							</div>
							<div class="post_thumbnail span3">
								<?php the_post_thumbnail('',array('class' => 'span3'));  ?>
							</div>
						<?php endwhile; ?>
						</div>
					</article>
					<hr class="span12 shadow">
				  <aside class="cardapio_delivery">
						<?php get_template_part('cardapio'); ?>
				  </aside>
				</div>
			</div>
		</section>
<?php get_footer(); ?>