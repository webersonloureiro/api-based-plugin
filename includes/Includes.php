<?php
namespace Weberson\Includes;

if( ! defined( 'ABSPATH' ) ) {
    die;
}

use Weberson\Admin\Requests;
use Weberson\Admin\Admin;
use Weberson\Includes\Blocks\Blocks;
use Weberson\Includes\Commands\Refresh;

class Includes {
    public function run() {
        $this->load_requests();
        $this->load_admin();
        $this->load_commands();
        $this->load_blocks();
    }

    public function load_requests() {
        new Requests();
    }

    public function load_admin() {
        new Admin();
    }

    public function load_commands() {
        if( ! defined( 'WP_CLI' ) || ! WP_CLI || ! class_exists( '\WP_CLI' )) {
            return;
        }
    
        $refresh_api_command = new Refresh();
        \WP_CLI::add_command( 'weberson', $refresh_api_command );
    }

    public function load_blocks() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        new Blocks();
    }
}
