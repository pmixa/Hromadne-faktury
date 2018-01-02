<?php


	$batch_id = $_GET['id'];

	

 	
$textemail=get_option('textemail');


$faktury = Faktura::get_faktury ($batch_id);

$pocet = count($faktury);
$max = 25;
 $i = 1;

// UCETNI
// 

$to = 'kancelar@zus-orlova.cz';
$subject = 'faktura';
$body = "Na stránkách muzamsk.cz byly vygenerovány faktury. Klikněte na odkaz pro stažení<br /> 
	<a href=\"http://muzamsk.cz/faktura/?batch=$batch_id&od=1&do=".(1+$max)."\">První várka</a><br />
	<a href=\"http://muzamsk.cz/faktura/?batch=$batch_id&od=".(2+$max)."&do=".$pocet."\">Druhá várka</a><br />

	";
$protocol = "<table><tr><td>$i.</td><td>$to</td><td>$body</td></tr>";
$i++;
$headers = array('MIME-Version: 1.0' . "\r\n",'Content-Type: text/html; charset=UTF-8');
wp_mail( $to, $subject, $body, $headers );


// ODBERATELE
	
		foreach ($faktury as $fa) {
	
				$faktura = new Faktura($fa->id);
				$customer = $faktura->get_user();
				$content="Dobrý den,<br />na stránkách muzamsk.cz byla vygenerována faktura. Pro stažení 
				prosím klikněte <a href=\"http://muzamsk.cz/faktura/?batch=$batch_id&user=".$customer['id']."\">zde.</a><br />Děkujeme.";
				
				$to = $customer['email'];
				$subject = 'faktura';
				$body = $content;

				$protocol.= "<tr><td>$i.</td><td>$to</td><td>$body</td>"; 
				
				$i++;
				$headers = array('MIME-Version: 1.0' . "\r\n",'Content-Type: text/html; charset=UTF-8');
					wp_mail( $to, $subject, $body, $headers );

				}



				$to = 'mixa.p@seznam.cz';
				$subject = 'faktury-protokol';
				$body = $protocol;
				$headers = array('MIME-Version: 1.0' . "\r\n",'Content-Type: text/html; charset=UTF-8');
					wp_mail( $to, $subject, $body, $headers );
					
echo "<div class=\"wrap\"><strong><u>Odesláno</u></strong><br />".$protocol."</table></div>";
