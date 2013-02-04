<?php wp_footer(); ?>

<footer id="footer">
	<div class="container">
		<div class="row">
			<article class="span12">
				<div class="row-fluid">

					<address class="span8">
						<p>Fratello Restaurante</p>
						<p>+55 51 3328.0551 | <a href="maito:fratello@fratellosole.com.br">fratello@fratellosole.com.br</a></p>
						<p>Shopping Iguatemi | Avenida João Wallig, 1800 | Porto Alegre RS</p>
					</address>
					<div id="newsletter" class=" span4">
						<h2>Receba nossa Newsletter</h2>
						 <?php echo do_shortcode( '[contact-form-7 id="833" title="NewsLetter"]' ) ?>
					</div>
					<div class="ezcomunicacao  span12">
						<p id="ezcomunicacao" >
								<a title="Desenvolvimento web criação sites publicidade websites porto alegre RS" href="http://ezcomunicacao.com.br/"></a>
						</p>
					</div>
				</div>
			</article>
		</div>
	</div>
</footer>
<!-- JavaScript at the bottom for fast page loading: http://developer.yahoo.com/performance/rules.html#js_bottom -->
<!-- scripts concatenated and minified via build script -->
<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery-1.8.3.min.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/script.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/neosmart-stream/nss-core/jquery.neosmart.stream.js"></script>
<script src="<?php bloginfo( 'template_url' ); ?>/js/fratello.js"></script>


<!-- end scripts -->
<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID. mathiasbynens.be/notes/async-analytics-snippet -->
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-33970083-1']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>

</body>
</html>
