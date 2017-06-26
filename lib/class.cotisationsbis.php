<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class cotisationsbis
{
  function __construct() {}


##
##

function delete_group ($record_id)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes WHERE id = ?";
	$dbresult = $db->Execute($query,array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
	
	
}
function delete_group_belongs ($record_id)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";
	$dbresult = $db->Execute($query, array($record_id));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
function delete_user_belongs ($ref_action)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_cotisations_belongs WHERE ref_action = ?";
	$dbresult = $db->Execute($query, array($ref_action));
	
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
function count_users_in_group($id_cotisation)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_cotisations_belongs WHERE id_cotisation = ?";
	$dbresult = $db->Execute($query, array($id_cotisation));
	$row = $dbresult->FetchRow();
	$nb = $row['nb'];
	return $nb;
}
function montant_par_adherent($licence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT SUM(ty.tarif) AS montant_total FROM ".cms_db_prefix()."module_cotisations_belongs AS be, ".cms_db_prefix()."module_cotisations_types_cotisations AS ty WHERE be.id_cotisation = ty.id AND be.licence = ?";
	$dbresult = $db->Execute($query, array($licence));
	if($dbresult)
	{
		$row = $dbresult->FetchRow();
		$montant_total = $row['montant_total'];
		return $montant_total;
	}
	else
	{
		return FALSE;
	}
}
function types_cotisations($id_cotisation)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT * FROM ".cms_db_prefix()."module_cotisations_types_cotisations WHERE id = ?";
	$dbresult = $db->Execute($query, array($id_cotisation));
	if($dbresult)
	{
		$row = $dbresult->FetchRow();
		$tab['nom'] = $row['nom'];
		$tab['tarif'] = $row['tarif'];
		return $tab;
	}
	
}

function add_paiement ($licence,$ref_action,$nom,$tarif)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_paiements_paiements(licence,ref_action, module,nom, tarif) VALUES ( ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($licence,$ref_action,'Cotisations',$nom, $tarif));
	if($dbresult)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
function delete_user_paiement($ref_action)
{
	global $gCms;
	$db = cmsms()->GetDb();
	//$paiements_ops = cms_utils::get_module('Paiements');
	$paiements_ops = new paiementsbis();
	//on vérifie s'il y a déjà des paiements effectués
	$nb = $paiements_ops->nb_reglements($ref_action);
	if($nb >0)
	{
		//on supprime tous les reglements !
		$del_reglements = $paiements_ops->delete_reglements($ref_action);
	}
	//on supprime le paiement
	$delete = $paiements_ops->delete_paiement($ref_action);
	//on supprime la dépendance 
	if(TRUE === $delete)
	{
		$query = "DELETE FROM ".cms_db_prefix()."module_cotisations_belongs WHERE ref_action = ?";
		$dbresult = $db->Execute($query, array($ref_action));
		if($dbresult)
		{
			return true;		
		}
		else
		{
			return false;
		}
		
	}
	else
	{
		return false;
	}
}

#
#
#
}//end of class
#
# EOF
#
?>