<div class="wrap">
    <h1><?php _e( 'Faktury', 'wedevs' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-title">
                    <th scope="row">
                        <label for="title"><?php _e( 'Název', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-num">
                    <th scope="row">
                        <label for="num"><?php _e( 'Číslo faktury', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="num" id="num" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-date">
                    <th scope="row">
                        <label for="date"><?php _e( 'Datum', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="date" id="date" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-date-due">
                    <th scope="row">
                        <label for="date_due"><?php _e( 'Datum plnění', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="date_due" id="date_due" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-ks">
                    <th scope="row">
                        <label for="ks"><?php _e( 'Konstantní symbol', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="ks" id="ks" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-vs">
                    <th scope="row">
                        <label for="vs"><?php _e( 'Variabilní symbol', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="vs" id="vs" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-description">
                    <th scope="row">
                        <label for="description"><?php _e( 'Popis', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="description" id="description" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-price">
                    <th scope="row">
                        <label for="price"><?php _e( 'Cena', 'wedevs' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="price" id="price" class="regular-text" placeholder="<?php echo esc_attr( '', 'wedevs' ); ?>" value="" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Vytvořit', 'wedevs' ), 'primary', 'submit' ); ?>

    </form>
</div>