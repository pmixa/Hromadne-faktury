<?

//////////////////////////////////////////////////////////////////////////
/////////////////                                         ////////////////
/////////////////              EXTEND  PROFIL             ////////////////
/////////////////            FAKTURACNI UDAJE             ////////////////
//////////////////////////////////////////////////////////////////////////

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>Fakturační údaje</h3>

	<table class="form-table">

		<tr>
			<th><label for="ic">IČ</label></th>

			<td>
				<input type="text" name="ic" id="ic" value="<?php echo esc_attr( get_the_author_meta( 'ic', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Zadejte vaše IČ</span>
			</td>
		</tr>
    <tr>
			<th><label for="firma">Název společnosti</label></th>

			<td>
				<input type="text" name="firma" id="firma" value="<?php echo esc_attr( get_the_author_meta( 'firma', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Název firmy</span>
			</td>
		</tr>
    <tr>
			<th><label for="dič">DIČ</label></th>

			<td>
				<input type="text" name="dic" id="dic" value="<?php echo esc_attr( get_the_author_meta( 'dic', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">DIČ</span>
			</td>
		</tr>
    <tr>
			<th><label for="ulice">Ulice</label></th>

			<td>
				<input type="text" name="ulice" id="ulice" value="<?php echo esc_attr( get_the_author_meta( 'ulice', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Zadejte ulici a číslo popisné</span>
			</td>
		</tr>
    <tr>
			<th><label for="mesto">Město</label></th>

			<td>
				<input type="text" name="mesto" id="mesto" value="<?php echo esc_attr( get_the_author_meta( 'mesto', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Zadejte Město</span>
			</td>
		</tr>
    <tr>
			<th><label for="psč">PSČ</label></th>

			<td>
				<input type="text" name="psc" id="psc" value="<?php echo esc_attr( get_the_author_meta( 'psc', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Zadejte PSČ</span>
			</td>
		</tr>
		 <tr>
			<th><label for="phone">Telefon</label></th>

			<td>
				<input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Zadejte telefon</span>
			</td>
		</tr>
	</table>
  <script type='text/javascript'>

jQuery(document).ready(function($) {
 $('#ic').change( function() {
   var ico = $(this).val();
   
   var data = {
		'ic': ico
		};
    var url = "<?php echo plugin_dir_url( __FILE__ )."ares.php"; ?>";
    jQuery.post(url, data, function(response) {
    response = $.parseJSON( response );
    if (response.stav == 'ok') {
      $('input[name=firma]').val(response.firma);
      $('input[name=dic]').val(response.dic);
      $('input[name=ulice]').val(response.ulice);
      $('input[name=mesto]').val(response.mesto);
      $('input[name=psc]').val(response.psc);
      alert('Název a sídlo firmy bylo vyplněno z databáze ARES.');
     } else {
      alert(response.stav);
     }   
		});

});
});
</script> 
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );


function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_usermeta( $user_id, 'ic', $_POST['ic'] );
  update_usermeta( $user_id, 'adresa', $_POST['adresa'] );
  update_usermeta( $user_id, 'firma', $_POST['firma'] );
  update_usermeta( $user_id, 'dic', $_POST['dic'] );
  update_usermeta( $user_id, 'ulice', $_POST['ulice'] );
  update_usermeta( $user_id, 'mesto', $_POST['mesto'] );
  update_usermeta( $user_id, 'psc', $_POST['psc'] );
  update_usermeta( $user_id, 'phone', $_POST['phone'] );
}