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
$licence = '';
$rowarray = array();

	
	if(!isset($params['licence']) || $params['licence'] == '')
	{
		$this->SetMessage("parametres manquants");
		$this->RedirectToAdminTab('groups');
	}
	else
	{
		$licence = $params['licence'];
	}

	
$db = $this->GetDb();
//on va sélectionner les licences déjà présentes en bdd pour cette cotisation et l'exclure de la liste
$query = "SELECT id, ref_action, id_cotisation, licence FROM ".cms_db_prefix()."module_cotisations_belongs WHERE licence = ?";
$dbresult = $db->Execute($query, array($licence));
$count = $dbresult->RecordCount();


	//on montre un formulaire pour ajouter des cotisations
	$query = "SELECT id, nom, description, tarif, actif FROM ".cms_db_prefix()."module_cotisations_types_cotisations AS j WHERE actif = 1 ";
	//echo $query;
	$dbresult = $db->Execute($query);//, array($tableau));

		if(!$dbresult)
		{
			$designation.= $db->ErrorMsg();
			$this->SetMessage("$designation");
			$this->RedirectToAdminTab('groups');
		}

		$smarty->assign('formstart',
				$this->CreateFormStart( $id, 'do_assign_cotis_to_user', $returnid ) );
		$smarty->assign('licence1',
				$this->CreateInputText($id,'licence1',$licence,10,15));	
		if($dbresult && $dbresult->RecordCount()>0)
		{
			while($row = $dbresult->FetchRow())
			{
				//var_dump($row);
				$nom = $row['nom'];
				$id_cotisation = $row['id'];
				$licence = $row['nom'];//licence
				//$joueur = '';
				$rowarray[$licence]['id_cotisation'] = $id_cotisation;
				$rowarray[$licence]['nom'] = $nom;//$joueur
				$rowarray[$licence]['participe'] = false;

				//on va chercher si le joueur est déjà dans la table participe
				$query2 = "SELECT licence, id_cotisation FROM ".cms_db_prefix()."module_cotisations_belongs WHERE licence = ? AND id_cotisation = ?";
				//echo $query2;
				$dbresultat = $db->Execute($query2, array($licence, $id_cotisation));

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
	echo $this->ProcessTemplate('assign_user_cotis.tpl');


#
#EOF
#
?>