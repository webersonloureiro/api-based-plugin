<?php
namespace Weberson\Includes\Commands;

if( ! defined( 'ABSPATH' ) ) {
    die;
}

class Refresh{
    public function refresh_api() {
        delete_transient( 'weberson_api_data_cache' );
        \WP_CLI::log( 'Transients deleted!' );
    }
}
