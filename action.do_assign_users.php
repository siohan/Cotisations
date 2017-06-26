<?php
if (!isset($gCms)) exit;
//require_once(dirname(__FILE__).'/include/prefs.php');
debug_display($params, 'Parameters');
if (!$this->CheckPermission('Cotisations use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}

$annee = date('Y');
//on récupère les valeurs
//pour l'instant pas d'erreur
$error = 0;
		
		$record_id = '';
		if (isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		else
		{
			$error++;
		}
	
		if($error ==0)
		{
			//on vire toutes les données de cette compet avant 
		
				$licence = '';
				if (isset($params['licence']) && $params['licence'] != '')
				{
					$licence = $params['licence'];
					var_dump($licence);
					$error++;
				}
				$cotisation_ops = new cotisationsbis();
				$paiements_ops = new paiementsbis();
				foreach($licence as $key=>$value)
				{
					$ref_action = $this->random_string(15);
					$query2 = "INSERT INTO ".cms_db_prefix()."module_cotisations_belongs (ref_action,id_cotisation,licence) VALUES ( ?, ?, ?)";
					//echo $query2;
					$dbresultat = $db->Execute($query2, array($ref_action,$record_id,$key));
					//la requete a fonctionné ? On ajoute à la table Paiements
					if($dbresultat)
					{
						//on ajoute 
						$tableau = $cotisation_ops->types_cotisations($record_id);
						//var_dump($nom);
						if(is_array($tableau))
						{
							$nom = $tableau['nom'];
							$tarif = $tableau['tarif'];
							$module = 'Cotisations';
							$add = $paiements_ops->add_paiement($key,$ref_action,$module,$nom,$tarif);
							var_dump($add);
							
						}
						
					}
				}
			$this->SetMessage('Membres du groupe ajoutés !');
			
				
				
		}
		else
		{
			echo "Il y a des erreurs !";
		}
		


$this->RedirectToAdminTab('types_cotis');

?>