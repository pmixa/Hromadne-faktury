<?php

/**
 * Sub menu class
 *
 * @author Premysl Mixa <mixa.p@seznam.cz>
 */
class Sub_menu {
 
    /**
     * Autoload method
     * @return void
     */
    public function __construct() {
        add_action( 'admin_menu', array(&$this, 'register_sub_menu') );
    }
 
    /**
     * Register submenu
     * @return void
     */
    public function register_sub_menu() {
        add_submenu_page( 
            'options-general.php', 'Faktury', 'Faktury', 'manage_options', 'nastaveni-faktury', array(&$this, 'submenu_page_callback')
        );
        register_setting( 'faktury_group', 'firma' );
        register_setting( 'faktury_group', 'ic' );
        register_setting( 'faktury_group', 'dic' );
        register_setting( 'faktury_group', 'ulice' );
        register_setting( 'faktury_group', 'mesto' );
        register_setting( 'faktury_group', 'psc' );
        register_setting( 'faktury_group', 'cu' );
        register_setting( 'faktury_group', 'info' );
        register_setting( 'faktury_group', 'rada' );
        register_setting( 'faktury_group', 'emailtext' );
          }
 
    /**
     * Render submenu
     * @return void
     */
    public function submenu_page_callback() {
      ?>  <div class="wrap">
  <h1>Nastavení modulu faktur</h1>
  <form method="post" action="options.php">
    <?php settings_fields('faktury_group');
    do_settings_sections( 'faktury_group' ); ?>
        <table>
            <tr>
                <td>
                    <label for="firma">
                        Název firmy:
                    </label>
                </td>
                <td>
                    <input type="text" name="firma" size="80" value="<?php echo esc_attr( get_option('firma') ); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="ic">
                        IČ:
                    </label>
                </td>
                <td>
                    <input type="text" name="ic" value="<?php echo esc_attr( get_option('ic') ); ?>">
                </td>
            </tr>
             <tr>
                <td>
                    <label for="dic">
                        DIČ:
                    </label>
                </td>
                <td>
                    <input type="text" name="dic" value="<?php echo esc_attr( get_option('dic') ); ?>">
                </td>
            </tr>
             <tr>
                <td>
                    <label for="ulice">
                        Ulice a č.p.:
                    </label>
                </td>
                <td>
                    <input type="text" name="ulice" size="80" value="<?php echo esc_attr( get_option('ulice') ); ?>">
                </td>
            </tr>
             <tr>
                <td>
                    <label for="mesto">
                        Město:
                    </label>
                </td>
                <td>
                    <input type="text" name="mesto" value="<?php echo esc_attr( get_option('mesto') ); ?>">
                </td>
            </tr>
             <tr>
                <td>
                    <label for="psc">
                       PSČ:
                    </label>
                </td>
                <td>
                    <input type="text" name="psc" value="<?php echo esc_attr( get_option('psc') ); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="cu">
                       Číslo účtu:
                    </label>
                </td>
                <td>
                    <input type="text" name="cu" value="<?php echo esc_attr( get_option('cu') ); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="info">
                       Další informace:
                    </label>
                </td>
                <td>
                    <textarea cols="60" rows="5" name="info"><?php echo esc_attr( get_option('info') ); ?></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="rada">
                       Číselná řada:
                    </label>
                </td>
                <td>
                    <input type="text" name="rada" value="<?php echo esc_attr( get_option('rada') ); ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="emailtext">
                       Text emailu:
                    </label>
                </td>
                <td>
                    <textarea cols="60" rows="5" name="emailtext"><?php echo esc_attr( get_option('emailtext') ); ?></textarea>
                </td>
            </tr>
    </table>
    <?php submit_button(); ?>
  </form>
  </div>
  <?
    }
 
}
 
new Sub_menu();

