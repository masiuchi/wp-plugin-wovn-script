<?php
/*

Plugin Name: WOVN Script
Plugin URI:  https://github.com/masiuchi/wp-plugin-wovn-script
Description: Insert WOVN.io script tag to HTML.
Version:     0.01
Author:      Masahiro Iuchi
Author URI:  https://github.com/masiuchi
License:     GPL2

Copyright 2016 Masahiro Iuchi (email : masahiro.iuchi@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

add_action('wp_head', function () {
  $option = get_option('wovn_script_tok');
  if ($option && isset($option['token'])) {
    $script = sprintf(
      '<script src="//j.wovn.io/1" data-wovnio="key=%s" async></script>',
      esc_attr($option['token'])
    );
    echo "$script\n";
  }
});

if (is_admin()) {
  add_action('admin_init', function () {
    register_setting('wovn-script', 'wovn_script_token');
  });

  add_action('admin_menu', function () {

    add_options_page(
      'WOVN Script Settings',
      'WOVN Script',
      'manage_options',
      'wovn-script',
      function () {
        $option = get_option('wovn_script');
        if (isset($option['token'])) $token = $option['token'];

        echo '<div class="wrap">';
        echo '  <h1>WOVN Script setting</h1>';
        echo '  <form method="post" action="options.php">';
        echo      settings_fields('wovn-script-group');
                  do_settings_sections('wovn-script-group');
        echo '    <table class="form-table">';
        echo '      <tr>';
        echo '        <th scope="row"><label for="wovn-script-token">Token</label></th>';
        echo '        <td><input id="wovn-script-token" type="text" name="wovn_script[token]" value="' . esc_attr($token) . '" /></td>';
        echo '      </tr>';
        echo '    </table>';
        echo      submit_button();
        echo '  </form>';
        echo '</div>';
      }
    );
  });
}

?>

