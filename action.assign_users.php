<?php
if( !isset($gCms) ) exit;
####################################################################
##                                                                ##
####################################################################
//debug_display($params, 'Parameters');
if (!$this->CheckPermission('Cotisations use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$type_compet = '';
$idepreuve = '';
$designation = '';
$record_id = '';
$rowarray = array();

	
	if(!isset($params['record_id']) || $params['record_id'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('groups');
	}
	else
	{
		$record_id = $params['record_id'];
	}

	
$db = $this->GetDb();
//on va sélectionner les licences déjà présentes en bdd pour cette cotisation et l'exclure de la liste
$query = "SELECT licence FROM ".cms_db_prefix()."module_cotisations_belongs WHERE id_cotisation = ?";
$dbresult = $db->Execute($query, array($record_id));
$count = $dbresult->RecordCount();
$tableau = array();
if($count >0)
{
	while($row = $dbresult->FetchRow())
	{
		$licence = $row['licence'];
		$tableau[]=$licence;
	}

$tab = implode(', ',$tableau);
//$tab = array_values($tableau);	

}
if($count >0)
{
	$query = "SELECT j.licence, CONCAT_WS(' ',j.nom, j.prenom ) AS joueur FROM ".cms_db_prefix()."module_adherents_adherents AS j WHERE actif = 1 AND licence NOT IN ($tab) ORDER BY cat ASC ";
}
else
{
	$query = "SELECT j.licence, CONCAT_WS(' ',j.nom, j.prenom ) AS joueur FROM ".cms_db_prefix()."module_adherents_adherents AS j WHERE actif = 1 ORDER BY cat ASC ";
}

//echo $query;
$dbresult = $db->Execute($query);//, array($tableau));

	if(!$dbresult)
	{
		$designation.= $db->ErrorMsg();
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('groups');
	}

	$smarty->assign('formstart',
			$this->CreateFormStart( $id, 'do_assign_users', $returnid ) );
	$smarty->assign('record_id',
			$this->CreateInputText($id,'record_id',$record_id,10,15));	
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			//var_dump($row);
			
			$licence = $row['licence'];
			$joueur = $row['joueur'];
			$rowarray[$licence]['name'] = $joueur;
			$rowarray[$licence]['participe'] = false;
			
			//on va chercher si le joueur est déjà dans la table participe
			$query2 = "SELECT licence, id_cotisation FROM ".cms_db_prefix()."module_cotisations_belongs WHERE licence = ? AND id_cotisation = ?";
			//echo $query2;
			$dbresultat = $db->Execute($query2, array($licence, $record_id));
			
			if($dbresultat->RecordCount()>0)
			{
				while($row2 = $dbresultat->FetchRow())
				{
			
					// l'adhérent est déjà en bdd
					$rowarray[$licence]['participe'] = true;
				}
			}
			
			//print_r($rowarray);
			
			
						
			
			
		}
		$smarty->assign('rowarray',$rowarray);	
			
	}
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));
	$smarty->assign('back',
			$this->CreateInputSubmit($id,'back',
						$this->Lang('back')));

	$smarty->assign('formend',
			$this->CreateFormEnd());
echo $this->ProcessTemplate('assign_users.tpl');
#
#EOF
#
?>