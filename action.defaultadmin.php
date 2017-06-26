<?php
   if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Cotisations use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
//	debug_display($params, 'Parameters');

echo $this->StartTabheaders();
if (FALSE == empty($params['activetab']))
  {
    $tab = $params['activetab'];
  } else {
  $tab = 'type_cotis';
 }	
	echo $this->SetTabHeader('type_cotis', 'Types de Cotisations', ('type_cotis' == $tab)?true:false);
	echo $this->SetTabHeader('adherents', 'Cotisations par adhérents', ('adherents' == $tab)?true:false);
//	echo $this->SetTabHeader('feu', 'Espace privé' , ('feu' == $tab)?true:false);
//	echo $this->SetTabHeader('email', 'Emails' , ('email' == $tab)?true:false);



echo $this->EndTabHeaders();

echo $this->StartTabContent();
	
	
	echo $this->StartTab('type_cotis', $params);
    	include(dirname(__FILE__).'/action.admin_type_cotisations_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('adherents', $params);
    	include(dirname(__FILE__).'/action.admin_joueurs_tab.php');
   	echo $this->EndTab();





echo $this->EndTabContent();
//on a refermé les onglets
?>