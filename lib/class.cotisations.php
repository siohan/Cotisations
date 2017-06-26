<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://www.cmsmadesimple.org


class cotisations
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
#
#
#
}//end of class
#
# EOF
#
?>