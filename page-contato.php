<?php get_header(); ?>
<div role="main">
<!-- Page == contato -->
		<section id="page" class="contato">
			<div class="container">
				<div id="conteudo" class="row">
					<article id="contato-article" class="span12">
						<?php  while (have_posts()) : the_post(); ?>
							<h1><?php the_title(); ?></h1>
							<div class="content row-fluid">
								<?php the_content(); ?>
							</div>
						<?php endwhile; ?>
					</article>
				</div>
			</div>
		</section>
<?php get_footer(); ?>