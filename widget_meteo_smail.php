
<?php

/**
 * @package widget_meteo
 * @version 0.1.1
 */
/*
Plugin Name: La Meteo qui sert pas du tout
Plugin URI: http://wordpress.org/plugins/lameteopd/
Description: Ceci est un plugin meteo pour ceux qui cherchent à voir l'invisible frère
Author: Wndrfla
Version: 0.1.1
Author URI: http://wndrfla.tg/
*/

class PluginMeteo {
	private $plugin_meteo_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'plugin_meteo_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'plugin_meteo_page_init' ) );
	}

	public function plugin_meteo_add_plugin_page() {
		add_plugins_page(
			'Plugin Meteo', // page_title
			'Plugin Meteo', // menu_title
			'manage_options', // capability
			'plugin-meteo', // menu_slug
			array( $this, 'plugin_meteo_create_admin_page' ) // function
		);
	}

	public function plugin_meteo_create_admin_page() {
		$this->plugin_meteo_options = get_option( 'plugin_meteo_option_name' ); ?>

		<div class="wrap">
			<h2>Plugin Meteo</h2>
			<p>Veuillez entrer votre clé api, l'ID de la ville ainsi que le widget désiré.</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'plugin_meteo_option_group' );
					do_settings_sections( 'plugin-meteo-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function plugin_meteo_page_init() {
		register_setting(
			'plugin_meteo_option_group', // option_group
			'plugin_meteo_option_name', // option_name
			array( $this, 'plugin_meteo_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'plugin_meteo_setting_section', // id
			'Settings', // title
			array( $this, 'plugin_meteo_section_info' ), // callback
			'plugin-meteo-admin' // page
		);

		add_settings_field(
			'api_key_0', // id
			'api-key', // title
			array( $this, 'api_key_0_callback' ), // callback
			'plugin-meteo-admin', // page
			'plugin_meteo_setting_section' // section
		);

		add_settings_field(
			'city_id_1', // id
			'city-id', // title
			array( $this, 'city_id_1_callback' ), // callback
			'plugin-meteo-admin', // page
			'plugin_meteo_setting_section' // section
		);

		add_settings_field(
			'widget_type_2', // id
			'widget-type', // title
			array( $this, 'widget_type_2_callback' ), // callback
			'plugin-meteo-admin', // page
			'plugin_meteo_setting_section' // section
		);
	}

	public function plugin_meteo_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['api_key_0'] ) ) {
			$sanitary_values['api_key_0'] = sanitize_text_field( $input['api_key_0'] );
		}

		if ( isset( $input['city_id_1'] ) ) {
			$sanitary_values['city_id_1'] = sanitize_text_field( $input['city_id_1'] );
		}

		if ( isset( $input['widget_type_2'] ) ) {
			$sanitary_values['widget_type_2'] = sanitize_text_field( $input['widget_type_2'] );
		}

		return $sanitary_values;
	}

	public function plugin_meteo_section_info() {
		
	}

	public function api_key_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="plugin_meteo_option_name[api_key_0]" id="api_key_0" value="%s">',
			isset( $this->plugin_meteo_options['api_key_0'] ) ? esc_attr( $this->plugin_meteo_options['api_key_0']) : ''
		);
	}

	public function city_id_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="plugin_meteo_option_name[city_id_1]" id="city_id_1" value="%s">',
			isset( $this->plugin_meteo_options['city_id_1'] ) ? esc_attr( $this->plugin_meteo_options['city_id_1']) : ''
		);
	}

	public function widget_type_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="plugin_meteo_option_name[widget_type_2]" id="widget_type_2" value="%s">',
			isset( $this->plugin_meteo_options['widget_type_2'] ) ? esc_attr( $this->plugin_meteo_options['widget_type_2']) : ''
		);
	}

}
if ( is_admin() )
    $plugin_meteo = new PluginMeteo();

 
//   Accès aux valeurs:
  $plugin_meteo_options = get_option( 'plugin_meteo_option_name' ); // Tableau de toutes les valeurs
  $api_key_0 = $plugin_meteo_options['api_key_0']; // api-key
  $city_id_1 = $plugin_meteo_options['city_id_1']; // city-id
  $widget_type_2 = $plugin_meteo_options['widget_type_2']; // widget-type
 
?>
<div id="openweathermap-widget-<?=$widget_type_2?>" style="margin-left:10%;"></div>
<script src='//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/d3.min.js'></script><script>window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];  window.myWidgetParam.push({id: <?=$widget_type_2?>,cityid: '<?= $city_id_1 ?>',appid: '<?=$api_key_0?>',units: 'metric',containerid: 'openweathermap-widget-<?=$widget_type_2?>',  });  (function() {var script = document.createElement('script');script.async = true;script.charset = "utf-8";script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(script, s);  })();</script>
<script>window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];  window.myWidgetParam.push({id: <?=$widget_type_2?>,cityid: '<?= $city_id_1 ?>',appid: '<?=$api_key_0?>',units: 'metric',containerid: 'openweathermap-widget-<?=$widget_type_2?>',  });  (function() {var script = document.createElement('script');script.async = true;script.charset = "utf-8";script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(script, s);  })();</script>