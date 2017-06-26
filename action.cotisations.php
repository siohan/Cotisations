<?php

if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Cotisations use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db =& $this->GetDb();
global $themeObject;
$aujourdhui = date('Y-m-d');
$cotis_ops = new cotisationsbis();
$paiements_ops = new paiementsbis();
if(isset($params['obj']) && $params['obj'] != '')
{
	$obj = $params['obj'];
}

switch($obj)
{
	case "delete_user_cotis":
		if(isset($params['ref_action']) && $params['ref_action'] != '')
		{
			$ref_action = $params['ref_action'];
			$delete_user_paiement = $cotis_ops->delete_user_paiement($ref_action);
			if(true === $delete_user_paiement)
			{
				$this->SetMessage('Cotisation supprimée. Versement(s) supprimé(s)');
				
			}
			else
			{
				$this->SetMessage('La suppression a échouée !');
			}
		}
		else
		{
			$this->SetMessage('Une erreur est survenue !');
		}
		$this->Redirect($id, 'defaultadmin', $returnid);
		
	break;
	
	
}

//$this->RedirectToAdminTab('adherents');

?>