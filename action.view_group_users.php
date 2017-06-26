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
//debug_display($params, 'Parameters');
$aujourdhui = date('Y-m-d');
//$ping = new Ping();
$act = 1;//par defaut on affiche les actifs (= 1 )
$shopping = '<img src="../modules/Adherents/images/shopping.jpg" class="systemicon" alt="Commandes" title="Commandes">';
$smarty->assign('add_users', 
		$this->CreateLink($id, 'edit_adherent',$returnid, 'Ajouter'));
$smarty->assign('shopping', $shopping);
$query = "SELECT * FROM ".cms_db_prefix()."module_cotisations_types_cotisations WHERE id_cotisation = ?";
if(isset($params['id_cotisation']) && $params['id_cotisation'] != '')
{
	$id_cotisation = $params['id_cotisation'];
	$req = 1;
	
}
$query1 = "SELECT nom FROM ".cms_db_prefix()."module_cotisations_types_cotisations WHERE id = ?";
$dbresultat = $db->Execute($query1, array($id_cotisation));
if($dbresultat && $dbresultat->RecordCount()>0)
{
	$row = $dbresultat->FetchRow();
	$nom = $row['nom'];
	$smarty->assign('nom', $nom);
}

$query2 = "SELECT adh.id, adh.licence, adh.nom, adh.prenom, adh.actif FROM ".cms_db_prefix()."module_adherents_adherents AS adh, ".cms_db_prefix()."module_cotisations_belongs AS be WHERE adh.licence = be.licence AND be.id_cotisation = ?";//" WHERE actif = 1";
$query2.=" ORDER BY nom ASC ";
$smarty->assign('act', $act);
	$dbresult = $db->Execute($query2,array($id_cotisation));

$rowarray = array();
$rowclass = 'row1';
if($dbresult && $dbresult->RecordCount() >0)
{
	
	while($row = $dbresult->FetchRow())
	{
	
		$onerow = new StdClass();
		$onerow->rowclass = $rowclass;
		$onerow->licence= $row['licence'];
		$onerow->nom= $row['nom'];
		$onerow->prenom= $row['prenom'];
		$onerow->actif= $row['actif'];
		
		$onerow->edit = $this->CreateLink($id, 'edit_adherent',$returnid,$themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array("record_id"=>$row['id']));
		//$onerow->refresh= $this->CreateLink($id, 'chercher_adherents_spid', $returnid,'<img src="../modules/Adherents/images/refresh.png" class="systemicon" alt="Rafraichir" title="Rafraichir">',array("obj"=>"refresh","licence"=>$row['licence']));//$row['closed'];
		//$onerow->view_contacts= $this->CreateLink($id, 'view_contacts', $returnid,'<img src="../modules/Adherents/images/contact.jpg" class="systemicon" alt="Contacts" title="Contacts">',array("licence"=>$row['licence']));//$row['closed'];
		
		($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
		$rowarray[]= $onerow;
		
	}
	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);
}
elseif(!$dbresult)
{
	echo $db->ErrorMsg();
}

//$query.=" ORDER BY date_compet";
echo $this->ProcessTemplate('view_group_users.tpl');

?>