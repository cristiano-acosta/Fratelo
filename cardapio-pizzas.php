<!-- Cardapio de Pizzas -->
<div class="tab-pane fade row " id="<?php echo $post_type->name; ?>">
	<?php
		global $post;
		$args = array('orderby' => 'name','order' => 'ASC');
		$categories = get_categories($args);

			/*= Loop de categorias  =*/
			foreach($categories as $category){
				/*= excluir o blog =*/
				//var_dump($category);
				//echo  'Nome:'.$category->name.' id:'.$category->cat_ID.'<br>';
				/*= excluir o blog(32), janta(34), almoço(33), doses(38),drinks(37),   =*/
				$exclude = array('32','34','33','38','37','36','35','34','33','39','40');
				if(!in_array($category->cat_ID,$exclude)):
	?>
				<div class="category_group">
					<div class="category_title span12">
						<?php
							echo '<h2><a href="" title="' . sprintf(__(" %s"),$category->name) . '" ' . '>' . $category->name. '</a> </h2> ';
						?>
					</div>
					<?php
						$posttags = get_tags($args);
						foreach($posttags as $tag){
					?>
							<div class="span12 tag_title">
								<?php echo '<h3>' . $tag->name . '</h3> ';
								//echo $category->term_id;
								?>


						<div class="row category_slide">
						<?php
							//$items_do_cardapio = new WP_Query(array('post_type' => $post_type->name, 'order' => 'ASC','category' => $category->term_id, 'tag' => $tag->name));
							$items_do_cardapio = new WP_Query(array('post_type' => $post_type->name, 'order' => 'ASC','category__in' => $category->term_id, 'tag' => $tag->name));
								while($items_do_cardapio->have_posts()) : $items_do_cardapio->the_post();
						?>
								<article class="span4 menu-entry" id="post-<?php the_ID() ?>">

									<div class="price-img">
										<?php	/*= Pego a imagem ou a imagem padrão do Custom Post Type  =*/
											if(has_post_thumbnail()){the_post_thumbnail(); } else{ echo '<img src="' . get_template_directory_uri() . '/img/cardapio/medio.' . $post_type->name . '.png" alt="' . $post_type->description . '" />'; }
										?>
									</div><div class="menu-entry-info">

					          <div class="menu-entry-content"><?php the_content(); ?></div>
				          </div>
									<div class="price_overlay">
										<div style="float:left;" class="price_left"></div>
										<div style="float:left;" class="item_price">
											<div class="item_price_dig">
												<?php /* para achar os campos ====>$custom_field_keys = get_post_custom_keys(); foreach ( $custom_field_keys as$key => $value ) {                                                                                      				$valuet = trim($value); if ( '_' == $valuet{0} )continue;cho $key . " => " . $value . "<br />"; 				}
													$pizza_broto = get_post_meta($post->ID,'wpcf-pizza-broto',true);
													$pizza_pequena = get_post_meta($post->ID,'wpcf-pizza-pequena',true);
													$pizza_grande = get_post_meta($post->ID,'wpcf-pizza-grande',true);
													$preco = get_post_meta($post->ID,'wpcf-preco',true);// check if the custum field has a value
														if($pizza_broto != ''){ echo '<p class="pizza_broto">Broto <br> R$ ' . $pizza_broto . '</p>'; }
														if($pizza_pequena != ''){ echo '<p class="pizza_pequena">Pequena <br> R$ ' . $pizza_pequena . '</p>';}
														if($pizza_grande != ''){ echo '<p class="pizza_grande">Grande <br> R$ ' . $pizza_grande . '</p>'; }
															else if($preco != ''){ echo 'R$ ' . $preco; }*/
												?>
												<h4 class="menu_title"><?php the_title(); ?></h4>
											</div>
										</div>
										<div style="float:left;" class="price_right"></div>
									</div>
								</article>
						<?php endwhile; wp_reset_query(); ?>
							</div>
						</div>
					<?php } ?>
				</div>
	<?php
			endif;
		}
	?>
</div>
	<!-- Cardapio de Pizzas -->