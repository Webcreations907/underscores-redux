<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/************************************************************************
* Redux Extension Loader
*
* Change 'redux_demo' to your theme options name, make sure it 
* matches what you have in your Redux config file.
*************************************************************************/
if ( !function_exists( 'theme_custom_extension_loader' ) ) {
	function theme_custom_extension_loader( $ReduxFramework ) {
		$path = dirname( __FILE__ ) . '/extensions/';
		$folders = scandir( $path, 1 );
		foreach ( $folders as $folder ) {
			if ( $folder === '.' or $folder === '..' or !is_dir( $path . $folder ) ) {
				continue;
			}
			$extension_class = 'ReduxFramework_Extension_' . $folder;
			if ( !class_exists( $extension_class ) ) {
				// In case you wanted override your override, hah.
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/'.$ReduxFramework->args['opt_name'].'/'.$folder, $class_file );
				if ( $class_file ) {
					require_once $class_file;
					$extension = new $extension_class( $ReduxFramework );
				}
			}
		}
	}

add_action( "redux/extensions/redux_demo/before", 'theme_custom_extension_loader', 0 );
}

/************************************************************************
* Redux Options Panel/Config Files
*************************************************************************/

// Loads reduxframe work
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxCore/framework.php' ) ) {
	require_once dirname( __FILE__ ) . '/ReduxCore/framework.php';
}

//Loads the redux config file
if ( file_exists( dirname( __FILE__ ) . '/sample-config.php' ) ) {
	require_once dirname( __FILE__ ) . '/sample-config.php';
}
?>