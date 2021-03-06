<div class="wrap">
    <h1><?php _e( 'Vytvořit dávku faktur', 'faktury' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-title">
                    <th scope="row">
                        <label for="title"><?php _e( 'Název', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="" required="required" />
                        <span class="description"><?php _e('Napište za co faktura je', 'faktury' ); ?></span>
                    </td>
                </tr>
                <tr class="row-date">
                    <th scope="row">
                        <label for="date"><?php _e( 'Datum', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="date" name="date" id="date" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="" required="required" />
                        <span class="description"><?php _e('Vystavení faktury', 'faktury' ); ?></span>
                    </td>
                </tr>
                <tr class="row-date-due">
                    <th scope="row">
                        <label for="date_due"><?php _e( 'Splatnost', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="date" name="date_due" id="date_due" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="" required="required" />
                        <span class="description"><?php _e('Datum splatnosti', 'faktury' ); ?></span>
                    </td>
                </tr>
                <tr class="row-description">
                    <th scope="row">
                        <label for="description"><?php _e( 'Podrobný popis', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="description" id="description" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="" required="required" />
                        <span class="description"><?php _e('Podrobný popis faktury', 'faktury' ); ?></span>
                    </td>
                </tr>
                <tr class="row-price">
                    <th scope="row">
                        <label for="price"><?php _e( 'Cena', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="price" id="price" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-ks">
                    <th scope="row">
                        <label for="ks"><?php _e( 'Konst. symbol', 'faktury' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="ks" id="ks" class="regular-text" placeholder="<?php echo esc_attr( '', 'faktury' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-odberatel">
                    <th scope="row">
                        <label for="odberatel"><?php _e( 'Odběratel', 'faktury' ); ?></label>
                    </th>
                    <td>
                    	<select multiple size="30" name="odberatel[]" id="odberatel" required="required" />
                    	<?
                    	$blogusers = get_users( [ 'role__in' => [ 'author', 'subscriber' ] ] );
						foreach ( $blogusers as $user ) {
					echo "<option value=\"".$user->id."\">" . esc_html( $user->user_firstname ) . '</option>';
						}
                    	?>

                    	</select>
                   	</td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Vytvořit', 'faktury' ), 'primary', 'Submit' ); ?>

    </form>
</div>