<?php get_header(); ?>
<?php //get_template_part('banners'); ?>
<!-- Front Page == Home -->
	<?php if (is_front_page()) { get_template_part( 'background', 'slides' ); ?>
	<!-- Front Page == Home -->

		<section id="home">
			<div class="container">
				<div id="conteudo" class="row">
					<div id="chromefix" class="clearfix"></div>
						<?php //get_template_part('banners2'); ?>
					<div class="delivery offset9 span3">
						<img src="<?php bloginfo( 'template_url' ); ?>/img/delivery.png">
					</div>
					<aside class="offset9 span3">
						<div id="fotos">
							<h3>Fotos</h3>
								<a href="http://ezcomunicacao.servehttp.com/fratellosole/espaco/"  title="<?php bloginfo('name'); ?>" >
									<img alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_url' ); ?>/img/home.fotos.png">
									<h4>Veja Mais...</h4>
								</a>
						</div>
						<div id="sociais-networks" class="">
							<h3>Compartilhando</h3>
							<?php
								$nss->show();
							?>
							<ul class="social-icons">
								<li>
									<a href="https://www.facebook.com/fratellorestaurante" target="_blank" title="<?php bloginfo('name'); ?>" >
										<img alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_url' ); ?>/img/ico.facebook.fratello.png">
									</a>
								</li>
								<li>
									<a href="https://twitter.com/saborfratello" target="_blank"  title="<?php bloginfo('name'); ?>" >
										<img alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_url' ); ?>/img/ico.twitter.fratello.png">
									</a>
								</li>
								<li>
									<a href="http://instagram.com/<?php bloginfo( 'name' ); ?>" target="_blank"  title="<?php bloginfo
									('name'); ?>" >
										<img alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_url' ); ?>/img/ico.instagram.fratello.png">
									</a>
								</li>
								<li>
									<a href="https://pt.foursquare.com/v/fratello-sole/4c9fdadf46978cfafad7ae7f" target="_blank"  title="<?php bloginfo('name'); ?>" >
										<img alt="<?php bloginfo('name'); ?>" src="<?php bloginfo( 'template_url' ); ?>/img/ico.foursquare.fratello.png">
									</a>
								</li>
							</ul>
						</div>
					</aside>
				</div>
			</div>
		</section>
	<?php } ?>
<?php get_footer(); ?>

