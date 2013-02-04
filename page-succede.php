<?php get_header(); ?>

<!-- Page == Te Fa Bene ==  -->
		<section id="page" class="te-fa-bene">
			<div class="container">
				<div id="conteudo" class="row">
					<article id="te-fa-bene-article" class="span12">
							<div class="row">
								<?php  while (have_posts()) : the_post(); ?>
									<h1><?php the_title(); ?></h1>
									<div class="content">
										<?php the_content(); ?>
									</div>
								<?php endwhile; ?>
							</div>
					</article>
					<aside id="time-line" class="span6" >
					  <div id="nss" class="row">
							<h2> Linha do Tempo </h2>
							<?php
								echo $nss->showCache();
							?>
						</div>
					</aside>
					<aside id="promotions" class="span6">
						<div id="banner" class="row">
							<h2 class="span6">  Destaques </h2>
              <ul class="banners">
								<!-- aqui vai os post_thumbnail do custon post type banners -->
								<?php
									date_default_timezone_set("Brazil/East"); // ajustando a data para o Brasil
									$hora = date("H:i"); // armazenando a hora no formato: 00, 06, 16, 19, etc...
									//$hora = "14:59"; // armazenando a hora no formato: 00, 06, 16, 19, etc...
									if($hora >= "03:00" && $hora <="14:59") {
										//$category = 'almoco';
										$query = array( 'post_type' => 'banners' , /*'category_name' => 'almoco',*/'posts_per_page' => -1,);
									} else  {
										//$category = 'janta';
										$query = array( 'post_type' => 'banners' , /*'category_name' => 'janta', */'posts_per_page' => -1,);
									}
										$banners = new WP_Query( $query );
										while ( $banners->have_posts() ) : $banners->the_post();
									    $image = get_post_meta($post->ID, 'wpcf-imagem-banner', true);
												if ($image != "" ) {
								?>
											<li class="span6">
												<article>
													<div class="description">
														<h1><?php the_title(); ?></h1>
														<p><?php the_excerpt(); //excerpt('10'); ?></p>
													</div>
													<figure>
														<?php echo '<img src="'.$image.'" alt="' . $post_type->description . '" />'; ?>
													</figure>
												</article>
											</li>
								<?php
												}
										endwhile; /*= End loop =*/
									wp_reset_query(); /*= Reset Query =*/
								?>
							</ul>
						</div>
					</aside>

				</div>
			</div>
		</section>
<?php get_footer(); ?>