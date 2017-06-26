<?php

if( !isset($gCms) ) exit;

	if (!$this->CheckPermission('Cotisations use'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('cotisations');
    		return;
  	}
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//s'agit-il d'une modif ou d'une créa ?
$record_id = '';
$index = 0;
$libelle = '';
$actif = 0;
$edit = 0;

if(isset($params['record_id']) && $params['record_id'] !="")
{
		$record_id = $params['record_id'];
		$edit = 1;//on est bien en trai d'éditer un enregistrement
		//ON VA CHERCHER l'enregistrement en question
		$query = "SELECT * FROM ".cms_db_prefix()."module_cotisations_types_cotisations WHERE id = ?";
		$dbresult = $db->Execute($query, array($record_id));
		$compt = 0;
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			$compt++;
			$id = $row['id'];
			$nom = $row['nom'];
			$tarif = $row['tarif'];
			$description = $row['description'];
			$actif = $row['actif'];
			
		}
}
$OuiNon = array('Oui'=>'1', 'Non'=>'0');	
	
	
	//on construit le formulaire
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_add_edit_types_cotis', $returnid ) );
	if($edit==1)
	{
		$smarty->assign('record_id',
				$this->CreateInputHidden($id,'record_id',$record_id));
		
	}
	
	
	$smarty->assign('nom',
			$this->CreateInputText($id,'nom',(isset($nom)?$nom:""),50,200));
	$smarty->assign('description',
			$this->CreateInputText($id,'description',(isset($description)?$description:""),50,200));
	$smarty->assign('tarif',
			$this->CreateInputText($id,'tarif',(isset($tarif)?$tarif:""),15,25));			
	$smarty->assign('actif',
			$this->CreateInputDropdown($id,'actif',$OuiNon,$selectedindex = $index, $selectedvalue=$actif));
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());
	
	



echo $this->ProcessTemplate('add_edit_types_cotis.tpl');

#
# EOF
#
?>
