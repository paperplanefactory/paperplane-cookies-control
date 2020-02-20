<?php

add_filter( 'the_content', 'paperplane_iframe_gdpr', 99, 4 );
function paperplane_iframe_gdpr( $html ) {
	return preg_replace('~<iframe[^>]*\K(?=src)~i','gdpr-', $html);
}

add_filter('acf_the_content', 'paperplane_iframe_acf_gdpr');
function paperplane_iframe_acf_gdpr($html) {
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
	$days_expry = get_field( 'scadenza_cookie_gdpr', 'option' );
	 ?>
	<script>
	jQuery(document).ready(function() {
		var non_gdpr_tracking_codes_head = decodeURIComponent("<?php echo rawurlencode($non_gdpr_tracking_codes_head); ?>");
		var non_gdpr_tracking_codes_body = decodeURIComponent("<?php echo rawurlencode($non_gdpr_tracking_codes_body); ?>");
		var non_gdpr_tracking_codes_body_closing = decodeURIComponent("<?php echo rawurlencode($non_gdpr_tracking_codes_body_closing); ?>");
		var gdpr_tracking_codes_head = decodeURIComponent("<?php echo rawurlencode($gdpr_tracking_codes_head); ?>");
		var gdpr_tracking_codes_body = decodeURIComponent("<?php echo rawurlencode($gdpr_tracking_codes_body); ?>");
		var gdpr_tracking_codes_body_closing = decodeURIComponent("<?php echo rawurlencode($gdpr_tracking_codes_body_closing); ?>");
		var embedded_content_message = decodeURIComponent("<?php echo rawurlencode($embedded_content_message); ?>");
		var generation_date = new Date();
		if (localStorage.getItem('paperplane-gdpr-expry') === null) {
			var expry_date = localStorage.getItem('paperplane-gdpr-expry');
			expry_date = new Date(generation_date);
			expry_date.setDate(expry_date.getDate() + <?php echo $days_expry; ?>);
			localStorage.setItem('paperplane-gdpr-expry', expry_date	);
		}

		console.log(localStorage.getItem('paperplane-gdpr-expry'));
		console.log(localStorage.getItem('paperplane-gdpr'));
		function clear_local_storage() {
			//localStorage.clear();
			localStorage.removeItem('paperplane-gdpr-expry');
			localStorage.removeItem('paperplane-gdpr');
		}

		function add_non_GDPR_cookies() {
			jQuery('head').append(non_gdpr_tracking_codes_head);
			jQuery('body').prepend(non_gdpr_tracking_codes_body);
			jQuery('body').append(non_gdpr_tracking_codes_body_closing);
		}
		add_non_GDPR_cookies();

		function add_GDPR_cookies() {
			jQuery('head').append(gdpr_tracking_codes_head);
			jQuery('body').prepend(gdpr_tracking_codes_body);
			jQuery('body').append(gdpr_tracking_codes_body_closing);
		}

		function show_banner() {
			jQuery('#paperplane-cookie-notice').addClass('shown');
		}

		function hide_banner() {
			jQuery('#paperplane-cookie-notice').removeClass('shown');
		}

		function block_embed() {
			jQuery('iframe').each(function() {
				frame_src = jQuery(this).attr("gdpr-src");
				if (typeof frame_src !== typeof undefined && frame_src !== false) {
					jQuery(this).replaceWith( "<div class='paperplane-gdpr-content-message'><a href='#' class='paperplane-gdpr-accept absl' aria-label='"+embedded_content_message+"'></a>"+embedded_content_message+"</div>" );
				}
			});
		}

		function approve_embed() {
			jQuery('iframe').each(function() {
				var blockedSrc = jQuery(this).attr("gdpr-src");
				jQuery(this).attr('src', blockedSrc);
				jQuery(this).removeAttr('gdpr-src');
			});
			jQuery('script').each(function() {
				var blockedScript = jQuery(this).attr("gdpr-src");
				jQuery(this).attr('src', blockedScript);
				jQuery(this).removeAttr('gdpr-src');
			});
		}

		function acceptOnScroll() {
			fromTop = jQuery(document).scrollTop();
			if ( fromTop > <?php echo $pixel_scroll; ?> ) {
				hide_banner();
				localStorage.setItem('paperplane-gdpr', 'yes'	);
				<?php if ( $forzare_il_reload === 'yes' ) : ?>
				location.reload();
				<?php endif; ?>
			}
		}

		if ( generation_date > expry_date ){
			clear_local_storage();
		}

		if ( localStorage.getItem('paperplane-gdpr') === null ) {
			show_banner();
		}


		if ( localStorage.getItem('paperplane-gdpr') === 'yes' ) {
			add_GDPR_cookies();
			approve_embed();
			hide_banner();
		}

		if ( localStorage.getItem('paperplane-gdpr') === 'no' ) {
			block_embed();
			hide_banner();
		}

		<?php if ( $forzare_accettazione_scroll === 'yes' ) : ?>
		if ( localStorage.getItem('paperplane-gdpr') === null ) {
			jQuery(document).scroll(function() {
				acceptOnScroll();
			});
		}

		<?php endif; ?>

		<?php if ( $click_to_accept === 'yes' ) : ?>
			var first_click_to_accept;
			if ( localStorage.getItem('paperplane-gdpr') === null ) {
				jQuery(document).on('click','body *',function(){
					hide_banner();
					localStorage.setItem('paperplane-gdpr', 'yes'	);
					 <?php if ( $forzare_il_reload === 'yes' ) : ?>
					 location.reload();
					 <?php endif; ?>
				});
			}
		<?php endif; ?>




		jQuery(document).on('click', '.paperplane-gdpr-accept:not(.initialized)', function (e) {
			event.preventDefault();
			hide_banner();
			localStorage.setItem('paperplane-gdpr', 'yes'	);
			<?php if ( $forzare_il_reload === 'yes' ) : ?>
			location.reload();
			<?php endif; ?>

		});

		jQuery(document).on('click', '.paperplane-gdpr-deny:not(.initialized)', function (e) {
			event.preventDefault();
			hide_banner();
			localStorage.setItem('paperplane-gdpr', 'no');
			//console.log(localStorage.getItem('paperplane-gdpr'));
			<?php if ( $forzare_il_reload === 'yes' ) : ?>
			location.reload();
			<?php endif; ?>
		});

		jQuery(document).on('click', '.show-paperplane-gdpr:not(.initialized)', function (e) {
			event.preventDefault();
			show_banner();
			clear_local_storage();
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
