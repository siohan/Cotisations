<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Cotisations use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
global $themeObject;
$shopping = '<img src="../modules/Cotisations/images/paiement.png" class="systemicon" alt="Réglez" title="Réglez">';
$smarty->assign('shopping', $shopping);
$false = $themeObject->DisplayImage('icons/extra/false.gif', $this->Lang('false'), '', '', 'systemicon');
$smarty->assign('false', $false);
$result= array ();
$query = "SELECT adh.id,adh.nom, adh.prenom, adh.licence,adh.actif FROM ".cms_db_prefix()."module_adherents_adherents AS adh WHERE actif = 1";


		$dbresult= $db->Execute($query);
	
	//echo $query;
	$rowarray= array();
	$rowclass = '';
	$cotis_ops = new cotisationsbis();
	
		if ($dbresult && $dbresult->RecordCount() > 0)
  		{
    			while ($row= $dbresult->FetchRow())
      			{
				$onerow= new StdClass();
				$onerow->rowclass= $rowclass;

				//les champs disponibles : 
				$licence = $row['licence'];
				$actif = $row['actif'];
				//une fonction pour calculer le montant total dû.
				$montant_total = $cotis_ops->montant_par_adherent($row['licence']);
				$onerow->licence= $row['licence'];
				//$nb = $cotis_ops->count_users_in_group($row['id']);
				$onerow->nom = $row['nom'];
				$onerow->prenom = $row['prenom'];
				$onerow->montant_total = $montant_total;
				//$onerow->nb_users = $this->CreateLink($id, 'view_group_users',$returnid,'Voir les '.$nb.' utilisateurs', array("id_cotisation"=>$row['id']));
				if($actif == 1)
				{
					$onerow->actif = $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('delete'), '', '', 'systemicon');
					$onerow->add_users = $this->CreateLink($id, 'assign_users', $returnid, $themeObject->DisplayImage('icons/system/groupassign.gif', $this->Lang('add'), '', '', 'systemicon'), array("record_id"=>$row['id']));
				}
				else
				{
					$onerow->actif = $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('delete'), '', '', 'systemicon');
				}
				
			//	$onerow->tarif = $row['tarif'];
							
				
				//$onerow->view= $this->createLink($id, 'view_item', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view_results'), '', '', 'systemicon'),array('active_tab'=>'CC',"record_id"=>$row['client_id'])) ;
				$onerow->view= $this->CreateLink($id, 'view_adherent', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('edit'), '', '', 'systemicon'), array('licence'=>$row['licence']));
			//	$onerow->add_reglement = $this->CreateLink($id, 'chercher_adherents_spid',$returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('obj'=>'delete_group','record_id'=>$row['id']));
			//	$onerow->add_users = $this->CreateLink($id, 'assign_users',$returnid, $themeObject->DisplayImage('icons/system/groupassign.gif', $this->Lang('add'), '', '', 'systemicon'), array('record_id'=>$row['id']));
				
				($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
				$rowarray[]= $onerow;
      			}
			
  		}

		$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
		$smarty->assign('itemcount', count($rowarray));
		$smarty->assign('items', $rowarray);
		
		

echo $this->ProcessTemplate('cotis_adherents.tpl');


#
# EOF
#
?>