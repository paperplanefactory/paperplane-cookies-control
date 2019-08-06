<?php
// creo un array per gestire l'inserimento dei campi nella pagina opzioni sia con che senza Polylang
// verifico che sia attivo Polylang
if ( function_exists( 'PLL' ) ) {
	$langs_parameters = array(
		'hide_empty' => 0,
		'fields' => 'slug'
	);
	$languages = pll_languages_list($langs_parameters);
}
else {
	$languages = array('any-lang');
}
$possible_options = array();
foreach ( $languages as $lang ) {
	$possible_options[] = array(
		array(
			'param' => 'options_page',
			'operator' => '==',
			'value' => 'plugin-gestione-cookie-gdpr-testi-'.$lang.'',
		),
	);
}

// funzionamento - senza lingua
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
	'key' => 'group_5d00c1b459584',
	'title' => 'Gestione Funzionamento Cookie GDPR',
	'fields' => array(
		array(
			'key' => 'field_5d00c1b45c239',
			'label' => 'Gestione comportamento',
			'name' => '',
			'type' => 'accordion',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 1,
			'multi_expand' => 1,
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5d00c1b45c274',
			'label' => 'Mostrare il banner dei cookie?',
			'name' => 'mostra_banner_cookie',
			'type' => 'true_false',
			'instructions' => 'Scegli se mostrare o meno il banner.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => 'Sì',
			'ui_off_text' => 'No',
		),
		array(
			'key' => 'field_5d00c1b45c2ac',
			'label' => 'Cookie version',
			'name' => 'cookie_version',
			'type' => 'number',
			'instructions' => 'Cambiare per forzare la generazione di un nuovo cookie. Utile nel caso in cui siano stati modificati i codici di tracciamento.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 1,
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5d00c1b45c2ff',
			'label' => 'Scadenza cookie GDPR',
			'name' => 'scadenza_cookie_gdpr',
			'type' => 'number',
			'instructions' => 'Scegliere dopo quanto il banner dei cookie deve essere mostrato nuovamente. Indicare il valore in ore.<br />
esempio er un mese: 24x31 = 744',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 744,
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5d00c1b45c357',
			'label' => 'Forzare l\'accettazione dei cookie cliccando in qualsiasi punto della pagina?',
			'name' => 'click_to_accept',
			'type' => 'select',
			'instructions' => 'Ogni interazione dell\'utente comporterà l\'accettazione dei cookie.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Sì',
				'no' => 'No',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5d00c1b45c3af',
			'label' => 'Forzare il reload della pagina all\'accettazione o rifiuto?',
			'name' => 'forzare_il_reload',
			'type' => 'select',
			'instructions' => 'Forzando il reload verranno tracciati i dati dal momento della scelta del consenso. In caso contrario il tracciamento inizierà dalla visita successiva.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Sì',
				'no' => 'No',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5d00c1b45c407',
			'label' => 'Forzare l\'accettazione allo scroll?',
			'name' => 'forzare_accettazione_scroll',
			'type' => 'select',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Sì',
				'no' => 'No',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5d00c1b45c45e',
			'label' => 'Dopo quanti pixel di scroll attivare l\'accettazione?',
			'name' => 'pixel_scroll',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5d00c1b45c407',
						'operator' => '==',
						'value' => 'yes',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 100,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5d00c1b45c4ba',
			'label' => 'Gestione codici di tracciamento e contenuti da bloccare',
			'name' => '',
			'type' => 'accordion',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 1,
			'multi_expand' => 1,
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5d00c1b45c50e',
			'label' => 'Informazioni sugli script caricati in pagina',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Nel caso in cui vengano utilizzati script in pagina es. AdSense sostituire l\'attributo src con gdpr-src<br />
Da:<br />
src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"<br />
A:<br />
gdpr-src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"<br />
<strong>Questa modifica non è da applicare alle due voci sotto "Non GDPR Tracking codes" e GDPR Tracking codes.</strong>',
			'new_lines' => 'wpautop',
			'esc_html' => 0,
		),
		array(
			'key' => 'field_5d00c1b45c566',
			'label' => 'Non GDPR Tracking codes HEAD',
			'name' => 'non_gdpr_tracking_codes_head',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che non richiedono accettazione.<br />
Per rendere Analytics GDPR compliant verificare che il codice abbia questa riga:<br />
gtag(\'config\', \'UA-XXXXXXX-X\', { \'anonymize_ip\': true });<br />
E verificare che nelle "Impostazioni di condivisione dati" di Analytics non sia marcato nessun checkbox.<br />
Questi codici verranno aggiunti dinamicamente alla sezione HEAD del documento.<br />
Per un codice più compatto fare riferimento a https://minimalanalytics.com/',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '<!-- Non GDPR Tracking codes (head) -->',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d00c1b45c616',
			'label' => 'GDPR Tracking codes HEAD',
			'name' => 'gdpr_tracking_codes_head',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che richiedono accettazione.<br />
Questi codici verranno aggiunti dinamicamente alla sezione HEAD del documento.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '<!-- GDPR Tracking codes (head) -->',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d00c1b45c5be',
			'label' => 'Non GDPR Tracking codes BODY',
			'name' => 'non_gdpr_tracking_codes_body',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che non richiedono accettazione.<br />
Questi codici verranno aggiunti dinamicamente alla sezione BODY del documento.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '<!-- Non GDPR Tracking codes (body) -->',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d00c1b45c66e',
			'label' => 'GDPR Tracking codes BODY',
			'name' => 'gdpr_tracking_codes_body',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che richiedono accettazione.<br />
Questi codici verranno aggiunti dinamicamente alla sezione BODY del documento.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '<!-- GDPR Tracking codes (body) -->',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d41889de44f5',
			'label' => 'GDPR Tracking codes /BODY',
			'name' => 'gdpr_tracking_codes_body_closing',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che richiedono accettazione.<br />
Questi codici verranno aggiunti dinamicamente alla fine della sezione BODY del documento.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '<!-- GDPR Tracking codes (body) -->',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d418894e44f4',
			'label' => 'Non GDPR Tracking codes /BODY',
			'name' => 'non_gdpr_tracking_codes_body_closing',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che non richiedono accettazione.<br />
Questi codici verranno aggiunti dinamicamente alla fine della sezione BODY del documento.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '<!-- Non GDPR Tracking codes (body) -->',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5d0123b0f3a15',
			'label' => 'Aspetto e CSS',
			'name' => '',
			'type' => 'accordion',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 0,
			'multi_expand' => 0,
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5d0123c8f3a16',
			'label' => 'Usare i CSS preimpostati?',
			'name' => 'use_own_css',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5d012401f3a17',
			'label' => 'Gestione aspetto banner',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Se vuoi personalizzare i CSS puoi utilizzare questi selettorei direttamente nel foglio di stile del tema:

#paperplane-cookie-notice {
	position: fixed;
	z-index: 9999;
	display: block;
	//visibility: hidden;
	display: none;
	width: calc(100% - 26px);
	bottom: 10px;
	left: 10px;
	font-family: $font-main !important;
	font-weight:$font-weight-1 !important;
	font-size: $cta1-size-smartphone !important;
	line-height: $cta1-lineheight-smartphone !important;
	border: $color-4 solid 3px !important;
	background-color: $color-1 !important;
	color: $color-6 !important;
	.paperplane-cookie-notice-container {
		position: relative;
		width: calc(100% - 20px);
		max-width: 768px;
		margin: 0 auto;
		padding: 10px;
		text-align: center;
		.paperplane-message-cookie-accepted, .paperplane-message-cookie-refused {
			display: none;
		}
	}
	a {
		display: inline-block;
		margin: 5px;
		padding: 3px 6px;
		background-color: $color-7;
		color: $color-1 !important;
		text-transform: uppercase;
	}
}

.paperplane-gdpr-content-message {
	position: relative;
	padding: 10px;
	margin: 20px 0;
	background-color: $color-1;
	color: $color-7;
	p {
		margin-bottom: 0;
		//text-transform: uppercase;
	}
}',
			'new_lines' => 'br',
			'esc_html' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-opzioni-di-funzionamento',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));


// testi - con lingue
// aggiornando i campi ricordarsi di sostituire l'array del parametro 'location' con => 'location' => $possible_options,

acf_add_local_field_group(array(
	'key' => 'group_5d00c29da548e',
	'title' => 'Gestione Testi Cookie GDPR',
	'fields' => array(
		array(
			'key' => 'field_5d00c29da7dea',
			'label' => 'Testi',
			'name' => '',
			'type' => 'accordion',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 1,
			'multi_expand' => 1,
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5d00c29da7e41',
			'label' => 'Messaggio da mostrare per gli embed bloccati.',
			'name' => 'embedded_content_message',
			'type' => 'wysiwyg',
			'instructions' => 'es. Questo contenuto è stato bloccato in base alle impostazioni sulla privacy. Per visualizzare questo contenuto devi attivare l\'uso dei cookie cliccando qui.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array(
			'key' => 'field_5d00c29da7ea7',
			'label' => 'Messaggio nel banner di avviso',
			'name' => 'banner_message',
			'type' => 'textarea',
			'instructions' => 'es. Questo sito utilizza cookie necessari al suo funzionamento e, negli articoli del blog, cookie per gestire annunci pubblicitari. Se clicchi "OK" acconsenti all\'uso dei cookie.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'br',
		),
		array(
			'key' => 'field_5d00c29da7f01',
			'label' => 'Testo per il pulsante di accettazione',
			'name' => 'banner_accept_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Accetto',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d00c29da7f59',
			'label' => 'Mostrare il pulsante di rifiuto dei cookie?',
			'name' => 'mostra_pulsante_rifiuto',
			'type' => 'true_false',
			'instructions' => 'Se non utilizzi cookie di profilazione puoi scegliere di non far comparire il pulsante.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => 'Sì',
			'ui_off_text' => 'No',
		),
		array(
			'key' => 'field_5d00c29da7fb0',
			'label' => 'Testo per il pulsante di Rifiuto',
			'name' => 'banner_deny_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Rifiuto',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d00c29da8008',
			'label' => 'Testo per il pulsante Maggiori informazioni',
			'name' => 'more_info_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Maggiori informazioni',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d00c29da8060',
			'label' => 'URL pagina Cookie Policy o Privacy Policy',
			'name' => 'url_cookie_policy',
			'type' => 'page_link',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'page',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'allow_archives' => 1,
			'multiple' => 0,
		),
		array(
			'key' => 'field_5d00c29da80b7',
			'label' => 'Target pagina Cookie Policy o Privacy Policy',
			'name' => 'url_cookie_policy_target',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'_self' => 'Stessa finestra',
				'_blank' => 'Nuova finestra',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5d00c29da810f',
			'label' => 'Testo link per mostrare ancora il banner e modificare le impostazioni.',
			'name' => 'show_options_again',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Mostra e modifica opzioni privacy.',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d00c29da8166',
			'label' => 'Istruzioni per inserire il link per mostrare ancora il banner e modificare le impostazioni',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Inserire questa stringa nel tema (ad esempio nel footer):<br />
<?php if ( function_exists( \'show_again_banner\' ) ) { show_again_banner(); } ?> <br />
Oppure utilizzare questo shortcode: [coookies-showagain]',
			'new_lines' => 'wpautop',
			'esc_html' => 1,
		),
		array(
			'key' => 'field_5d00c29da81be',
			'label' => 'Testo di promemoria per cookie accettati',
			'name' => 'promemoria_cookie_accettati',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Hai scelto di utilizzare i cookie di terze parti, grazie per la fiducia. Puoi modificare la tua scelta secondo queste opzioni:',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d00c29da8216',
			'label' => 'Testo di promemoria per cookie rifiutati',
			'name' => 'promemoria_cookie_rifiutati',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Hai scelto di non utilizzare i cookie di terze parti. Puoi modificare la tua scelta secondo queste opzioni:',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d00c29da8374',
			'label' => 'Elenco cookie da mostrare nella pagina dedicata',
			'name' => '',
			'type' => 'accordion',
			'instructions' => 'Utilizzare lo shortcode [coookies-list] nella pagina dove si desiderano elencare i cookie utilizzati.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 0,
			'multi_expand' => 0,
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5d00c29da83cc',
			'label' => 'Gestisci cookies',
			'name' => 'cookies_list',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Aggiungi cookie',
			'sub_fields' => array(
				array(
					'key' => 'field_5d00c29dc2295',
					'label' => 'Nome del cookie',
					'name' => 'nome_cookie',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5d00c29dc22d5',
					'label' => 'Quanto tempo persiste sul browser dell\'utente?',
					'name' => 'quanto_tempo_persiste',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5d00c29dc2314',
					'label' => 'Di quali dati tiene traccia?',
					'name' => 'quali_dati_tiene_traccia',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5d00c29dc2352',
					'label' => 'Per quale scopo (funzionalità, prestazioni, statistiche, marketing, ecc.)?',
					'name' => 'per_quale_scopo',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5d00c29dc2390',
					'label' => 'Dove vengono inviati i dati e con chi sono condivisi?',
					'name' => 'dove_vengono_inviati_dati',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5d00c29dc23cd',
					'label' => 'Come rifiutare i cookie e come modificare successivamente lo stato dei cookie',
					'name' => 'come_rifiutare_i_cookie',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 1,
					'delay' => 0,
				),
			),
		),
	),
	'location' => $possible_options,
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));


endif;
