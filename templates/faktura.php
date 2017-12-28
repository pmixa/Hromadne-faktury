<?php 

/* Template Name: Faktura */ 

?>

<style type="text/css"><!--

table {border-collapse:collapse;font-size:16px;margin:20px 0;}
td {border:1px solid #000 !important;padding:20px;}
.faktura tr {border:1px solid #000 !important,width:900px;}
.plneni {font-size:16px;font-weight:bold;}
.maker {font-size:13px;margin-top:50px;}
.foot {font-size:13px;font-weight:bold;margin-top:20px;}
.frame {border:3px solid #000 !important}
.noframe {border:0;}
img {width:330px;}

--></style>
<div class="faktura-content">
<h1>Faktura č. <?= $faktura->num ?></h1>
<table class="faktura">
	<tr>
		<td>
		<img src="http://muzamsk.cz/wp-content/uploads/2016/12/logo.png" />
		</td>
		<td>
			<strong><?= get_option('firma'); ?></strong><br />
			<?= esc_attr( get_option('ulice') ); ?><br />
			<?= esc_attr( get_option('psc') ); ?> <?= esc_attr( get_option('mesto') ); ?><br />
			IČ: <?= esc_attr( get_option('ic') ); ?><br />
		</td>
		
	</tr>
	<tr>
		<td class="long">
			<?= get_option('info'); ?>
		</td>
		<td>
			Variabilní symbol: <strong><?= $faktura->vs; ?></strong><br />
			Konstantní symbol: <?= $faktura->ks; ?><br />
			Datum vyhotovení: <strong><?= $faktura->date; ?></strong><br />
			Datum splatnosti: <strong><?= $faktura->date_due; ?></strong><br />
			Forma úhrady: převodem z účtu
		</td>
	</tr>
	<tr>
		<td class="frame" colspan="2">
			<strong><u>ODBĚRATEL:</u></strong><br /><br />
			<strong><?= $customer['zus']; ?></strong><br />
			Ředitel: <?= $customer['jmeno']; ?><br />
			<?= $customer['ulice']; ?><br />
			<?= $customer['psc']; ?> <?= $customer['mesto']; ?><br /><br />
			Tel.: <?= $customer['telefon']; ?><br />
			Email: <?= $customer['email']; ?><br /><br />
			IČ: <?= $customer['ic']; ?>
		</td>
	</tr>
</table>
<table class="faktura">
	<tr>
		<td colspan="2"><strong>Předmět plnění: <?= $faktura->title; ?></strong></td>
	</tr>

	<tr>
		<td>
			Celková cena:
		</td>
		<td class="frame">
			<strong><?= $faktura->price; ?> Kč</strong>
		</td>
	</tr>
</table>
<div class="maker">
	Vyhotovila: Eva Sekelová<br />
	tel.č. 596516938<br />
	e-mail: kancelar@zus-orlova.cz
</div>
<div class="sign"></div>
<div class="foot">Nejsme plátci DPH</div>
</div>



