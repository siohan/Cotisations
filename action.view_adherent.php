<?php
if( !isset($gCms) ) exit;
####################################################################
##                                                                ##
####################################################################
//debug_display($params, 'Parameters');

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

if($count > 0)
{
	//on montre les cotisations de l'adhérent
	//echo "on y est !";
	$this->Redirect($id, 'view_adherent_cotis', $returnid, array("licence"=>$licence));
	
}
elseif($count == 0)
{
	$this->Redirect($id, 'add_cotis_to_adherent', $returnid, array("licence"=>$licence));
	
}

#
#EOF
#
?>