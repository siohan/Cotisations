<?php
if (!isset($gCms)) exit;
debug_display($params, 'Parameters');

	if (!$this->CheckPermission('Cotisations use'))
	{
		$designation .=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('types_cotis');
	}

//on récupère les valeurs
//pour l'instant pas d'erreur
$aujourdhui = date('Y-m-d ');
$error = 0;
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
	
		
		
		if (isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = $params['record_id'];
			$edit = 1;
		}		
		
	
		
		$nom = '';
		if (isset($params['nom']) && $params['nom'] !='')
		{
			$nom = $params['nom'];
		}
		else
		{
			$error++;
		}
		
		$description = '';
		if (isset($params['description']) && $params['description'] !='')
		{
			$description = $params['description'];
		}
		$tarif = '';
		if (isset($params['tarif']) && $params['tarif'] !='')
		{
			$tarif = $params['tarif'];
		}
		
		
		
		$actif = 0;
		if (isset($params['actif']) && $params['actif'] !='')
		{
			$actif = $params['actif'];
		}
		
		
				
		//on calcule le nb d'erreur
		if($error>0)
		{
			$this->Setmessage('Parametres requis manquants !');
			$this->RedirectToAdminTab('types_cotis');
		}
		else // pas d'erreurs on continue
		{
			
			
			
			
			if($edit == 0)
			{
				$query = "INSERT INTO ".cms_db_prefix()."module_cotisations_types_cotisations (nom, description, tarif,actif) VALUES ( ?, ?, ?, ?)";
				$dbresult = $db->Execute($query, array($nom, $description,$tarif, $actif));

			}
			else
			{
				$query = "UPDATE ".cms_db_prefix()."module_cotisations_types_cotisations SET nom = ?, description = ?, tarif = ?, actif = ? WHERE id = ?";
				$dbresult = $db->Execute($query, array($nom, $description, $tarif,$actif,$record_id));
				
				
			}
			
			
			
		}		
	//	echo "la valeur de edit est :".$edit;
		
		
	
			
		

$this->SetMessage('Type modifié ou ajouté');
$this->RedirectToAdminTab('types_cotis',$params='');

?>