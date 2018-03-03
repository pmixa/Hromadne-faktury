.<?php 

/*

výpis faktur pro přihlášeného uživatele

*/
function Faktura_Vypis() {

    global $wpdb;

    $user = wp_get_current_user();

if( array_intersect(array('contributor','author','subscriber'), $user->roles ) ) {   
   
  

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
				<td><a href=\"http://muzamsk.cz/faktura/?faktura=".$faktura->id."\">Zobrazit</a></td>
			</tr>";
	
	}

	$out.="</table>";

	}

	else if( array_intersect(array('administrator','editor'), $user->roles ) ) {   

 	$out = '<table><tr><th>Č. faktury</th><th>Datum</th><th>Název</th><th>Cena</th></tr>';

	$table_name = $wpdb->prefix . 'faktury';
    
    $faktury = $wpdb->get_results( 'SELECT * FROM ' . $table_name .' ORDER BY num asc' );
    
	foreach ($faktury as $faktura_id) {

	$faktura = new Faktura($faktura_id->id);
	$user = $faktura->get_user();
	

	$out.= "<tr>
				<td><strong>".$faktura->num."</strong></td>
				<td>".convert_date ($faktura->date)."</td>
				<td>".$faktura->title."</td>
				<td>".$faktura->price."</td>
				
			</tr>
			<tr><td colspan=\"3\">Odběratel: <small>".$user['zus']." - ".$user['jmeno']."</small></td>
			<td><a href=\"http://muzamsk.cz/faktura/?faktura=".$faktura->id."\">Zobrazit</a></td></tr>";


		}
		$out.="</table>";

		}

	return $out;
}

add_shortcode( 'Faktury', 'Faktura_Vypis' );








?>