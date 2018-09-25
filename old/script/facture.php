<style type="text/css">
<!--
table	{ vertical-align: top; }
tr		{ vertical-align: top; }
td		{ vertical-align: top; }
}
-->
</style>
<page backcolor="#FEFEFE" backimg="./res/aqua_bebe.jpg" backimgx="right" backimgy="middle" backimgw="96%" backtop="10mm" backbottom="30mm" >
	<page_footer>
		<table style="width: 100%;font-size:8pt;">
			<tr>
				<td style="text-align: left;	width: 15%">&nbsp;</td>
				<td style="text-align: center;	width: 70%">Siège social : Aqua-Bébé  820, route de Saint Thomas 31470 Saint Lys - SIRET 41360577500035</td>
				<td style="text-align: right;	width: 15%">&nbsp;</td>
			</tr>
		</table>
    </page_footer>

	<table cellspacing="0" style="width: 100%; text-align: center; font-size: 16pt">
		<tr>
			<td style="width: 50%;">
			</td>
			<td style="width: 50%; color: #2a5396;">
				ATTESTATION D'ADHÉSION<br/>
				Saison <?=$saison;?>
			</td>
		</tr>
		<tr>
			<td colspan="2"><br/><br/><br/><br/><br/><br/></td>
		</tr>
		<tr>
			<td style="width: 50%;"></td>
			<td style="width: 50%; color: #2a5396;">
			 820, route de Saint Thomas<br/>
			 31470 Saint Lys
			</td>
		</tr>
	</table>
	<br/>
	<br/>
	<br/>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<table cellspacing="0" style="width: 100%; border:none; text-align: left; font-size: 12pt; ">
		<tr>
			<td style="width: 25%;"></td>
			<td style="width: 66%;">
				Je soussignée Florent Lavail, Président de l'Association Aqua-Bébé, 
				<!--certifie que <?=$payeur;?> a bien réglé le montant de la cotisation pour la saison 2010 / 2011 par <?=$moyen;?>.<br/>-->
				certifie que <?=$payeur;?> a bien réglé le montant de la cotisation pour la saison <?=$saison;?> par chèque.<br/>
				La somme payée est de <?=$montant_lettre;?> euros (<?=$montant;?>&euro;&nbsp;)  
				dont vingt euros (20&euro;&nbsp;) d'adhésion à l'association.<br/>
				<br/>
				<br/>
				Cette cotisation concerne l'enfant <?=$prenom;?> <?=$nom;?> <?php if($sexe){echo "née";} else { echo "né";}?> le <?=$naissance;?>, 
				qui pratique l'activité des bébés nageurs le <?=$jour;?> <?=strtolower($heure);?>.<br/> <!--strtolower permet de mettre la chaine en miniscule-->
				 Ce document n'engage pas l'association sur la provision des paiements effectués en plusieurs fois.
				<br/>
				<br/>
				<br/>
				Fait à St Lys, le <?php echo date("j/m/Y"); ?><br/>
				<br/>
				<br/>
				<br/>
			</td>
		</tr>
	</table>
	<table cellspacing="0" style="width: 100%; border:none; text-align: center; font-size: 12pt; ">
		<tr>
			<td style="width: 60%;"></td>
			<td style="width: 31%;">
				Le Président, Florent Lavail <br/>
        <!-- signature de la présidente -->
				<img style="width: 100%" src="./res/Signature_Florent_Lavail.jpg" alt="Signature Présidente" >
				<?php //cachet du club ou de l'association.		?>
			</td>
		</tr>
	</table>
</page>
