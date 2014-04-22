<?php
/* do wordpress init and set $wpdb respecting db drop-ins */
require_once( '../../../wp-load.php' );

/* pull in is_plugin_active */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/* if the plugin isn't active let them log in normally */
if ( ! is_plugin_active( 'eig-sso/eig-sso.php' ) ) {
    wp_safe_redirect( wp_login_url() );
    exit;
}

global $wpdb;

require_once( './eig-sso.php' );

$nonce = $_GET['nonce'];
$salt  = $_GET['salt'];

if ( eigsso_check_offer( $nonce, $salt ) ) {
    eigsso_accept_offer();
}

/* if the mysql user doesn't have privileges eigsso_accept_offer will not
   redirect and drop into this case. */
wp_safe_redirect( wp_login_url() );
exit;

/*
endpoint.php - Receiver for Single Sign On requests issued by EIG properties.
Copyright (C) 2014 Endurance International Group

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
?>
