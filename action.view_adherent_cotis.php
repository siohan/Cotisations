<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Cotisations use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$licence = '';
if(isset($params['licence']) && $params['licence'] !='')
{
	$licence = $params['licence'];
}
global $themeObject;
$shopping = '<img src="../modules/Cotisations/images/paiement.png" class="systemicon" alt="Réglez" title="Réglez">';
$smarty->assign('shopping', $shopping);
$false = $themeObject->DisplayImage('icons/extra/false.gif', $this->Lang('false'), '', '', 'systemicon');
$smarty->assign('false', $false);
$result= array ();
$query = "SELECT CONCAT_WS(' ',adh.nom, adh.prenom) AS joueur, adh.licence, be.id_cotisation,be.ref_action FROM ".cms_db_prefix()."module_adherents_adherents AS adh , ".cms_db_prefix()."module_cotisations_belongs AS be  WHERE adh.licence = be.licence AND adh.licence = ?";
$dbresult= $db->Execute($query, array($licence));
	
	//echo $query;
	$rowarray= array();
	$rowclass = '';
	$cotis_ops = new cotisationsbis();
	$paiements_ops = cms_utils::get_module('Paiements');
	$paiements_ops = new paiementsbis();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;
				$smarty->assign('joueur',$row['joueur']);
				$licence = $row['licence'];
				$onerow->licence= $row['licence'];
				$onerow->ref_action= $row['ref_action'];
				$tableau = $cotis_ops->types_cotisations($row['id_cotisation']);
				$paid = $paiements_ops->is_paid($row['ref_action']);
				$restant = $paiements_ops->restant_du($row['ref_action']);
				//var_dump($restant);
				if(is_null($restant))
				{
					$restant = 0;
				}
				$du = $tableau['tarif'] - $restant;
				//var_dump($restant);
				$onerow->nom = $tableau['nom'];				
				$onerow->montant_total = $tableau['tarif'];
				$onerow->restant = $du;
				$onerow->delete = $this->CreateLink($id, 'cotisations',$returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array("obj"=>"delete_user_cotis","ref_action"=>$row['ref_action']));				
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
      			}
			
  		}

		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		
		

echo $this->ProcessTemplate('cotis_adherent.tpl');


#
# EOF
#
?>