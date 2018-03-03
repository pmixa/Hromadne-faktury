<?php


use Spipu\Html2Pdf\Html2Pdf;

	$batch_id = isset($_GET['batch']) ? $_GET['batch'] : false;
	$faktura_id = isset($_GET['faktura']) ? $_GET['faktura'] : false;
	$od = isset($_GET['od']) ? $_GET['od'] : false;
	$do = isset($_GET['do']) ? $_GET['do'] : false;
	$user = isset($_GET['user']) ? $_GET['user'] : false;
	$out = isset($_GET['out']) ? $_GET['out'] : false;

	

	if (($batch_id && ($od || $do || $user)) || $faktura_id) {

	ob_start();

	if (!$faktura_id) {
	$faktury = Faktury::get_faktury ($batch_id);
	$i = 1;

	// faktury pro ucetni
	if ($od && $do) {

			foreach ($faktury as $fa) {
	
				if ($i>=$od && $i<=$do) {
			
				$faktura = new Faktura($fa->id);
				$customer = $faktura->get_user();

				echo '<page style="font-family: freeserif"><br />';
				include "faktura.php";
				echo'</page>';
				}
			$i++;

			}
	
	}


	//faktura pro uzivatele
	else if ($user) {

			foreach ($faktury as $fa) {
				
				$faktura = new Faktura($fa->id);
				$customer = $faktura->get_user();
				if ($user == $customer['id']) {
				echo '<page style="font-family: freeserif"><br />';
				include "faktura.php";
				echo'</page>';
				}

			}
	}
	}

	else {

				$faktura = new Faktura($faktura_id);
				$customer = $faktura->get_user();

				echo '<page style="font-family: freeserif"><br />';
				include "faktura.php";
				echo'</page>';

		}


	
  	$content = ob_get_clean();

  	if ($out == 'pdf') {

    	$html2pdf = new Html2Pdf('P', 'A4', 'cs');
    	$html2pdf->writeHTML($content);
    	$html2pdf->output('muzamsk-faktura-'.$faktura->num.'.pdf','I');
    }
    
    else {
    	echo "<div style=\"font:20px Arial;color:red; border:2px solid red; padding:20px;margin:10px;text-align:center\">Pro stažení faktury v PDF formátu klikněte <a href=\"".$_SERVER['REQUEST_URI']."&out=pdf\">ZDE</a></div>";
    	echo $content;
    	}

}

