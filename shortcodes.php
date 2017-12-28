<?php 

/*

výpis faktur pro přihlášeného uživatele

*/
function Faktura_Vypis() {

    global $wpdb;

    $out = '<table><tr><th>Č. faktury</th><th>Datum</th><th>Název</th><th>Cena</th><th></th></tr>';

    $user =  wp_get_current_user();

	$table_name = $wpdb->prefix . 'faktury';
    
    $faktury = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $table_name . ' WHERE id_user = %d',$user->ID ) );
    
	foreach ($faktury as $faktura) {



	$out.= "<tr>
				<td>".$faktura->num."</td>
				<td>".convert_date ($faktura->date)."</td>
				<td>".$faktura->title."</td>
				<td>".$faktura->price."</td>
				<td><a href=\"http://muzamsk.cz/faktura/?batch=".$faktura->id_batch."&user=".$user->ID."\">Zobrazit</a></td>
			</tr>";
	
	}

	return $out."</table>";
}

add_shortcode( 'Faktury', 'Faktura_Vypis' );








?>