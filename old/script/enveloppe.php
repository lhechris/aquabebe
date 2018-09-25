<style type="text/css">
<!--
table	{ vertical-align: top; }
tr		{ vertical-align: top; }
td		{ vertical-align: top; }
}
-->
</style>
<?php
 	foreach($enfants as $enfant) { 
?>
<page backcolor="#FEFEFE" backimg="./res/aqua_bebe.jpg" backimgx="left" backimgy="middle" backimgw="96%" backtop="00mm" backbottom="10mm" backleft="6mm">
	<page_footer>
		<table style="width: 100%;font-size:8pt;">
			<tr>
				<td style="text-align: left;	width: 10%">&nbsp;</td>
				<td style="text-align: left;	width: 70%">Siège social : Aqua-Bébé rue Maubec 31830 Plaisance du Touch</td>
				<td style="text-align: right;	width: 20%">&nbsp;</td>
			</tr>
		</table>
    </page_footer>

	<table cellspacing="0" style="width: 100%; text-align: center; font-size: 16pt">
		<tr>
			<td style="width: 50%; color: #2a5396;">
				<img src="./res/logo_enveloppe.gif"/>
			</td>
			<td style="width: 50%;">
			</td>
		</tr>
	</table>
	<br>
	<br>
	<br>
	<table cellspacing="0" style="width: 100%; border:none; text-align: left; font-size: 16pt; line-height:20pt;">
		<tr>
			<td style="width: 45%;"></td>
			<td style="width: 50%;">
				<?=$enfant['prenom'];?>&nbsp;<?=$enfant['nom'];?><br/>
				<?=$enfant['adresse'];?><br/>
				<?=$enfant['cp'];?>&nbsp;<?=$enfant['commune'];?>
			</td>
			<td style="width: 5%;"></td>
		</tr>
	</table>
</page>
<?php } ?>
