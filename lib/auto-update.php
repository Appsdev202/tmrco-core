<?php

add_filter('plugins_api', 'tmrco_core_plugin_infomation', 20, 3);
function tmrco_core_plugin_infomation( $res, $action, $args ){

	if( 'plugin_information' !== $action ) {
		return false;
	}

	$plugin_slug = 'tmrco-core-main';

	if( $plugin_slug !== $args->slug ) {
		return false;
	}

	if( false == $remote = get_transient( 'tmrco_core_update_' . $plugin_slug ) ) {
		$remote = wp_remote_get( 'https://raw.githubusercontent.com/Appsdev202/aml197/main/update.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);
		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'tmrco_core_update_' . $plugin_slug, $remote, 14400 ); // 4 cache
		}
	}

	if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {

		$remote = json_decode( $remote['body'] );
		$res = new stdClass();

		$res->name = $remote->name;
		$res->slug = $plugin_slug;
		$res->new_version = $remote->new_version;
		$res->requires = $remote->requires;
		$res->author = '<a href="https://www.rimtm.com/">rimtm</a>';
		$res->download_link = $remote->package;
		$res->trunk = $remote->package;
		$res->sections = array();
		return $res;

	}
	return false;
}

add_filter( 'site_transient_update_plugins', 'tmrco_core_plugin_push_update' );
add_filter( 'transient_update_plugins', 'tmrco_core_plugin_push_update' );

function tmrco_core_plugin_push_update( $transient ){

	if ( ! is_object( $transient ) )
		return $transient;

	if ( ! isset( $transient->response ) || ! is_array( $transient->response ) )
		$transient->response = array();

	if( false == $remote = get_transient( 'tmrco_core_upgrade_tmrco-core-main' ) ) {

		$remote = wp_remote_get( 'https://raw.githubusercontent.com/Appsdev202/aml197/main/update.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);

		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'tmrco_core_upgrade_tmrco-core-main', $remote, 14400 ); // 4 hours cache
		}
	}

	if( $remote ) {
		$remote = json_decode( $remote['body'] );
		if( $remote && version_compare( tmrco_CORE_VERSION, $remote->new_version, '<' )
			&& version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
			$res = new stdClass();
			$res->slug = 'tmrco-core-main';
			$res->plugin = 'tmrco-core-main/tmrco-core-main.php';
			$res->new_version = $remote->new_version;
			$res->url = 'https://www.rimtm.com/';
			$res->package = $remote->package;
			$res->compatibility = new stdClass();
       		$transient->response[$res->plugin] = $remote;
       	}
	}
	// echo '<pre>';print_r( $transient); exit;
    return $transient;
}

add_action( 'upgrader_process_complete', 'tmrco_core_after_update', 10, 2 );

function tmrco_core_after_update( $upgrader_object, $options ) {
	if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
		delete_transient( 'tmrco_core_upgrade_tmrco-core-main' );
	}
}
