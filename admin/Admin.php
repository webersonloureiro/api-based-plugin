<?php
namespace Weberson\Admin;

if( ! defined( 'ABSPATH' ) ) {
    die;
}

use Weberson\Admin\Requests;

class Admin {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
        add_filter( 'plugin_action_links_' . PLUGIN_FOLDER, array( $this, 'action_links' ), 10, 1 );
        add_action( 'in_admin_header', array( $this, 'admin_header' ) );
        add_action( 'in_admin_footer', array( $this, 'admin_footer' ) );
    }

    public function enqueue_assets() {
        $current_screen = get_current_screen();
        if ( ! strpos( $current_screen->base, 'weberson' ) ) {
            return;
        }

        wp_enqueue_style( 'weberson_style', plugins_url( '/assets/css/admin-style.css', __DIR__ ), array(), PLUGIN_VER );
    }

    public function add_admin_pages() {
        add_menu_page(
            esc_html__( 'API Plugin', 'weberson' ),
            esc_html__( 'API Plugin', 'weberson' ),
            'read',
            'weberson',
            array( $this, 'admin_index' ),
            'dashicons-rest-api',
            110
        );
    }

    public function admin_index() {
        $api_request = new Requests();
        $api_json_data = $api_request->api_json_data();
        ?>
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div id="weberson-admin-content" class="wrap">
            <form method="post" action="options.php">
                <div class="weberson-section-heading">
                    <h2>
                        <?php esc_html_e( 'Listing Data', 'weberson' ); ?>
                    </h2>
                </div>

                <?php if( $api_json_data ) { ?>
                    <div class="weberson-section-row">
                        <table class="form-table weberson-list-table">
                            <tr valign="top">
                                <?php
                                foreach( $api_json_data->data->headers as $header ) {
                                    ?>
                                    <th scope="row">
                                        <?php echo esc_html( $header ); ?>
                                    </th>
                                    <?php
                                }
                                ?>
                            </tr>
                            
                            <?php
                            $max_items = count( ( array ) $api_json_data->data->rows );
                            for( $i=1; $i <= $max_items; $i++ ) { 
                                ?>
                                <tr valign="top" class="<?php echo esc_attr( 'row ' . $i ); ?>">
                                    <?php
                                    foreach( $api_json_data->data->rows->$i as $key => $row ) {
                                        ?>
                                        <td class="<?php echo esc_attr( $key . '-' . $i ); ?>">
                                            <?php echo esc_html( $row ); ?>
                                        </td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                <?php } else { 
                    esc_html_e( 'No data available. Plase, update the API URL', 'weberson' );
                } ?>
                
                <div class="weberson-section-heading">
                    <h2>
                        <?php esc_html_e( 'API Data', 'weberson' ); ?>
                    </h2>
                </div>
                
                <div class="weberson-section-row">
                    <table class="form-table ">
                        <tr valign="top">
                            <th scope="row">
                                <?php esc_html_e( 'Refresh API data', 'weberson' ); ?>
                            </th>
                            <td>
                                <button id="weberson-refresh-data" class="button button-primary">
                                    <?php esc_html_e( 'Refresh', 'weberson' ); ?>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
        <?php
    }

    public function admin_header() {
        $current_screen = get_current_screen();
        if ( ! strpos( $current_screen->base, 'weberson' ) ) {
            return;
        }
        ?>

        <div id="weberson-admin-header">
            <h1>
                <?php esc_html_e( 'API Plugin', 'weberson' ); ?>
            </h1>
        </div>
        <?php
    }

    public function admin_footer() {
        $current_screen = get_current_screen();
        if ( ! strpos( $current_screen->base, 'weberson' ) ) {
            return;
        }
        ?>

        <div class="weberson-admin-footer">
            <p>
                <?php esc_html_e( 'Made with ♥ and &#9749; by Weberson Loureiro', 'weberson' ); ?>
            </p>
            <ul class="weberson-admin-footer__links">
                <li>
                    <a href="https://www.linkedin.com/in/webersonloureiro/" target="_Blank">Github</a>
                </li>
                <li> / </li>
                <li>
                    <a href="https://github.com/webersonloureiro" target="_Blank">LinkedIn</a>
                </li>
            </ul>
        </div>
        <?php
    }

    public function action_links( $links ) {
        $url = 'admin.php?page=weberson';
        $settings_link = '<a href="'. esc_url( $url ) . '">' . esc_html__( 'API Data', 'weberson' ) . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }
}
