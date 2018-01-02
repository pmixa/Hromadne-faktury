<div class="wrap">
    <h1><?php _e( 'Faktury', 'faktury' ); ?></h1>

    <?php $item = new Faktura ( $id ); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-title">
                    <th scope="row">
                        <label for="title"><?php _e( 'Název', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->title ); ?>" />
                    </td>
                </tr>
                <tr class="row-num">
                    <th scope="row">
                        <label for="num"><?php _e( 'Číslo faktury', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="num" id="num" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->num ); ?>" />
                    </td>
                </tr>
                <tr class="row-date">
                    <th scope="row">
                        <label for="date"><?php _e( 'Datum', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="date" name="date" id="date" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->date ); ?>" />
                    </td>
                </tr>
                <tr class="row-date-due">
                    <th scope="row">
                        <label for="date_due"><?php _e( 'Datum plnění', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="date" name="date_due" id="date_due" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->date_due ); ?>" />
                    </td>
                </tr>
                <tr class="row-ks">
                    <th scope="row">
                        <label for="ks"><?php _e( 'Konstantní symbol', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="ks" id="ks" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->ks ); ?>" />
                    </td>
                </tr>
                <tr class="row-vs">
                    <th scope="row">
                        <label for="vs"><?php _e( 'Variabilní symbol', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="vs" id="vs" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->vs ); ?>" />
                    </td>
                </tr>
                <tr class="row-description">
                    <th scope="row">
                        <label for="description"><?php _e( 'Popis', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="description" id="description" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->description ); ?>" />
                    </td>
                </tr>
                <tr class="row-price">
                    <th scope="row">
                        <label for="price"><?php _e( 'Cena', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="price" id="price" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="<?php echo esc_attr( $item->price ); ?>" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Upravit', 'faktury' ), 'primary', 'submit' ); ?>

    </form>
</div>