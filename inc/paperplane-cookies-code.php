<?php

add_filter( 'the_content', 'paperplane_iframe_gdpr', 99, 4 );
function paperplane_iframe_gdpr( $html ) {
	return preg_replace('~<iframe[^>]*\K(?=src)~i','gdpr-', $html);
}

global $paperplane_cookies_current_language;
if ( function_exists( 'PLL' ) ) {
	$paperplane_cookies_current_language = pll_current_language('slug');
}
else {
	$paperplane_cookies_current_language = 'any-lang';
}

add_action( 'wp_footer', 'paperplane_handle_cookies', 9999);
function paperplane_handle_cookies() {
	global $paperplane_cookies_current_language;
	global $gdpr_tracking_codes_head;
	global $gdpr_tracking_codes_body;
	// versione del tema
	$cookie_version = get_field( 'cookie_version', 'option' );
	$cookie_gdpr_expry = get_field( 'scadenza_cookie_gdpr', 'option' );
	$non_gdpr_tracking_codes_head = get_field( 'non_gdpr_tracking_codes_head', 'option' );
	$non_gdpr_tracking_codes_body = get_field( 'non_gdpr_tracking_codes_body', 'option' );
	$gdpr_tracking_codes_head = get_field( 'gdpr_tracking_codes_head', 'option' );
	$gdpr_tracking_codes_body = get_field( 'gdpr_tracking_codes_body', 'option' );

	$non_gdpr_tracking_codes_body_closing = get_field( 'non_gdpr_tracking_codes_body_closing', 'option' );
	$gdpr_tracking_codes_body_closing = get_field( 'gdpr_tracking_codes_body_closing', 'option' );

	$forzare_il_reload = get_field( 'forzare_il_reload', 'option' );
	$forzare_accettazione_scroll = get_field( 'forzare_accettazione_scroll', 'option' );
	$pixel_scroll = get_field( 'pixel_scroll', 'option' );
	$click_to_accept = get_field( 'click_to_accept', 'option' );
	$embedded_content_message = get_field( 'embedded_content_message', $paperplane_cookies_current_language );
	//converto ore in giorni
	$days_expry = ($cookie_gdpr_expry / 24);
	 ?>
	<script>
	$(document).ready(function() {
		var non_gdpr_tracking_codes_head = decodeURIComponent("<?php echo rawurlencode($non_gdpr_tracking_codes_head); ?>");
		var non_gdpr_tracking_codes_body = decodeURIComponent("<?php echo rawurlencode($non_gdpr_tracking_codes_body); ?>");
		var gdpr_tracking_codes_head = decodeURIComponent("<?php echo rawurlencode($gdpr_tracking_codes_head); ?>");
		var gdpr_tracking_codes_body = decodeURIComponent("<?php echo rawurlencode($gdpr_tracking_codes_body); ?>");

		var non_gdpr_tracking_codes_body_closing = decodeURIComponent("<?php echo rawurlencode($non_gdpr_tracking_codes_body_closing); ?>");
		var gdpr_tracking_codes_body_closing = decodeURIComponent("<?php echo rawurlencode($gdpr_tracking_codes_body_closing); ?>");

		var embedded_content_message = decodeURIComponent("<?php echo rawurlencode($embedded_content_message); ?>");
		var myCookie<?php echo $cookie_version; ?> = Cookies.get('paperplane-gdpr<?php echo $cookie_version; ?>');
		$('head').append(non_gdpr_tracking_codes_head);
		$('body').prepend(non_gdpr_tracking_codes_body);
		$('body').append(non_gdpr_tracking_codes_body_closing);
		if ( myCookie<?php echo $cookie_version; ?> === 'no' ) {
			$('iframe').each(function() {
				frame_src = $(this).attr("gdpr-src");
				if (typeof frame_src !== typeof undefined && frame_src !== false) {
					$(this).replaceWith( "<div class='paperplane-gdpr-content-message'><a href='#' class='paperplane-gdpr-accept absl' aria-label='"+embedded_content_message+"'></a>"+embedded_content_message+"</div>" );
				}
			});
		}
		if ( typeof myCookie<?php echo $cookie_version; ?> === 'undefined' || myCookie<?php echo $cookie_version; ?> === null || myCookie<?php echo $cookie_version; ?> === '' ) {
			$('#paperplane-cookie-notice').fadeIn(200);
			$('iframe').each(function() {
				frame_src = $(this).attr("gdpr-src");
				if (typeof frame_src !== typeof undefined && frame_src !== false) {
					$(this).replaceWith( "<div class='paperplane-gdpr-content-message'><a href='#' class='paperplane-gdpr-accept absl' aria-label='"+embedded_content_message+"'></a>"+embedded_content_message+"</div>" );
				}
			});
			<?php if ( $forzare_accettazione_scroll === 'yes' ) : ?>
			function acceptOnScroll() {
				fromTop = $(document).scrollTop();
				if ( fromTop > <?php echo $pixel_scroll; ?> ) {
					$('#paperplane-cookie-notice').fadeOut(200);
					Cookies.set('paperplane-gdpr<?php echo $cookie_version; ?>', 'yes', { expires: <?php echo $days_expry; ?> });
					<?php if ( $forzare_il_reload === 'yes' ) : ?>
					location.reload();
					<?php endif; ?>
				}
			}
			$(document).scroll(function() {
				acceptOnScroll();
			});
			<?php endif; ?>
			<?php if ( $click_to_accept === 'yes' ) : ?>
				var first_click_to_accept;
				if ( first_click_to_accept != 1 ) {
					$(document).on('click','body *',function(){
						//alert(first_click_to_accept);
						$('#paperplane-cookie-notice').fadeOut(200);
						first_click_to_accept = 1;
						 Cookies.set('paperplane-gdpr<?php echo $cookie_version; ?>', 'yes', { expires: <?php echo $days_expry; ?> });
						 <?php if ( $forzare_il_reload === 'yes' ) : ?>
						 location.reload();
						 <?php endif; ?>
					});
				}
			<?php endif; ?>
		}
		if ( myCookie<?php echo $cookie_version; ?> === 'yes' ) {
			$('head').append(gdpr_tracking_codes_head);
			$('body').prepend(gdpr_tracking_codes_body);
			$('body').append(gdpr_tracking_codes_body_closing);
			$('iframe').each(function() {
				var blockedSrc = $(this).attr("gdpr-src");
				$(this).attr('src', blockedSrc);
				$(this).removeAttr('gdpr-src');
			});
			$('script').each(function() {
				var blockedScript = $(this).attr("gdpr-src");
				$(this).attr('src', blockedScript);
				$(this).removeAttr('gdpr-src');
			});
		}

		$(document).on('click', '.paperplane-gdpr-accept:not(.initialized)', function (e) {
			event.preventDefault();
			$('#paperplane-cookie-notice').fadeOut(200);
			Cookies.set('paperplane-gdpr<?php echo $cookie_version; ?>', 'yes', { expires: <?php echo $days_expry; ?> });
			<?php if ( $forzare_il_reload === 'yes' ) : ?>
			location.reload();
			<?php endif; ?>

		});

		$(document).on('click', '.paperplane-gdpr-deny:not(.initialized)', function (e) {
			event.preventDefault();
			$('#paperplane-cookie-notice').fadeOut(200);
			Cookies.set('paperplane-gdpr<?php echo $cookie_version; ?>', 'no', { expires: <?php echo $days_expry; ?> });
			<?php if ( $forzare_il_reload === 'yes' ) : ?>
			location.reload();
			<?php endif; ?>
		});

		$(document).on('click', '.show-paperplane-gdpr:not(.initialized)', function (e) {
			event.preventDefault();
			Cookies.remove('paperplane-gdpr<?php echo $cookie_version; ?>');
			if ( myCookie<?php echo $cookie_version; ?> === 'yes' ) {
				$('.paperplane-message-cookie-accepted').show();
			}
			if ( myCookie<?php echo $cookie_version; ?> === 'no' ) {
				$('.paperplane-message-cookie-refused').show();
			}
			$('#paperplane-cookie-notice').fadeIn(200);
		});




	});

	</script>
<?php }

add_action( 'wp_footer', 'cookies_banner', 9999);
function cookies_banner() {
	global $gdpr_tracking_codes_head;
	global $gdpr_tracking_codes_body;
	global $paperplane_cookies_current_language;

	// versione del tema
	$mostra_banner_cookie = get_field( 'mostra_banner_cookie', 'option' );
	$banner_message = get_field( 'banner_message', $paperplane_cookies_current_language );
	$banner_accept_text = get_field( 'banner_accept_text', $paperplane_cookies_current_language );
	$banner_deny_text = get_field( 'banner_deny_text', $paperplane_cookies_current_language );
	$more_info_text = get_field( 'more_info_text', $paperplane_cookies_current_language );
	$url_cookie_policy = get_field( 'url_cookie_policy', $paperplane_cookies_current_language );
	$url_cookie_policy_target = get_field( 'url_cookie_policy_target', $paperplane_cookies_current_language );
	$promemoria_cookie_accettati = get_field( 'promemoria_cookie_accettati', $paperplane_cookies_current_language );
	$promemoria_cookie_rifiutati = get_field( 'promemoria_cookie_rifiutati', $paperplane_cookies_current_language );
	$mostra_pulsante_rifiuto = get_field( 'mostra_pulsante_rifiuto', $paperplane_cookies_current_language );
	$show_options_again = get_field( 'show_options_again', $paperplane_cookies_current_language );

	if ( $mostra_banner_cookie == 1 ) :
	 ?>
		<div id="paperplane-cookie-notice">
			<div class="paperplane-cookie-notice-container">
				<div class="paperplane-message-cookie-accepted">
					<?php echo $promemoria_cookie_accettati; ?>
				</div>
				<div class="paperplane-message-cookie-refused">
					<?php echo $promemoria_cookie_rifiutati; ?>
				</div>
				<?php echo $banner_message; ?>
				<a href="#" class="paperplane-gdpr-accept" aria-label="<?php echo $banner_accept_text; ?>"><?php echo $banner_accept_text; ?></a>
				<?php if ( $mostra_pulsante_rifiuto == 1 ) : ?>
					<a href="#" class="paperplane-gdpr-deny" aria-label="<?php echo $banner_deny_text; ?>"><?php echo $banner_deny_text; ?></a>
				<?php endif; ?>
				<a href="<?php echo $url_cookie_policy; ?>" target="<?php echo $url_cookie_policy_target; ?>"><?php echo $more_info_text; ?></a>
			</div>
		</div>
	<?php endif; ?>
<?php }

function show_again_banner() {
	global $paperplane_cookies_current_language;
	$mostra_banner_cookie = get_field( 'mostra_banner_cookie', 'option' );
	$show_options_again = get_field( 'show_options_again', $paperplane_cookies_current_language );
	if ( $mostra_banner_cookie == 1 ) {
		echo '<a href="#" class="show-paperplane-gdpr" aria-label="'.$show_options_again.'">'.$show_options_again.'</a>';
	}
}



function paperplanecookies_showagain( $atts ){
	ob_start();
	global $paperplane_cookies_current_language;
	$mostra_banner_cookie = get_field( 'mostra_banner_cookie', 'option' );
	$show_options_again = get_field( 'show_options_again', $paperplane_cookies_current_language );
	if ( $mostra_banner_cookie == 1 ) {
		echo '<a href="#" class="show-paperplane-gdpr" aria-label="'.$show_options_again.'">'.$show_options_again.'</a>';
	}
	return ob_get_clean();
}
add_shortcode( 'coookies-showagain', 'paperplanecookies_showagain' );















function paperplanecookies_list( $atts ){
	ob_start();
	if ( function_exists( 'PLL' ) ) {
		if ( have_rows( 'cookies_list', pll_current_language('slug') ) ) {
			while ( have_rows( 'cookies_list', pll_current_language('slug') ) ) : the_row();
				echo '<div class="cookies-list-block">';
				echo '<strong>';
				the_sub_field( 'nome_cookie' );
				echo '</strong>';
				echo '<br />';
				the_sub_field( 'quanto_tempo_persiste' );
				echo '<br />';
				the_sub_field( 'quali_dati_tiene_traccia' );
				echo '<br />';
				the_sub_field( 'per_quale_scopo' );
				echo '<br />';
				the_sub_field( 'dove_vengono_inviati_dati' );
				echo '<br />';
				the_sub_field( 'come_rifiutare_i_cookie' );
				echo '</div>';
			endwhile;
		}

	}
	else {
		if ( have_rows( 'cookies_list', 'any-lang' ) ) {
			while ( have_rows( 'cookies_list', 'any-lang' ) ) : the_row();
				echo '<div class="cookies-list-block">';
				echo '<strong>';
				the_sub_field( 'nome_cookie' );
				echo '</strong>';
				echo '<br />';
				the_sub_field( 'quanto_tempo_persiste' );
				echo '<br />';
				the_sub_field( 'quali_dati_tiene_traccia' );
				echo '<br />';
				the_sub_field( 'per_quale_scopo' );
				echo '<br />';
				the_sub_field( 'dove_vengono_inviati_dati' );
				echo '<br />';
				the_sub_field( 'come_rifiutare_i_cookie' );
				echo '</div>';
			endwhile;
		}
	}

	return ob_get_clean();
}
add_shortcode( 'coookies-list', 'paperplanecookies_list' );
