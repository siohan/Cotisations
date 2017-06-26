<?php
#-------------------------------------------------------------------------
# Module: Cotisations
# Version: 0.1, Claude SIOHAN Agi webconseil
# Method: Install
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------

/**
 * For separated methods, you'll always want to start with the following
 * line which check to make sure that method was called from the module
 * API, and that everything's safe to continue:
 */ 
if (!isset($gCms)) exit;


/** 
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Install() method in the module body.
 */

$db = $gCms->GetDb();

// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	nom C(150),
	description C(255),
	tarif N(6.2) DEFAULT 0.00,
	actif I(1) DEFAULT 1";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_cotisations_types_cotisations", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	ref_action C(15),
	id_cotisation I(4),
	licence I(11)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_cotisations_belongs", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
//les index

$idxoptarray = array('UNIQUE');
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'belongs',
	    cms_db_prefix().'module_cotisations_belongs', 'licence, id_cotisation',$idxoptarray);
	       $dict->ExecuteSQLArray($sqlarray);

//Permissions
$this->CreatePermission('Cotisations use', 'Cotisations : utiliser le module');



// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>