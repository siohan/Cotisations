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
		
		$licence1 = '';
		if (isset($params['licence1']) && $params['licence1'] != '')
		{
			$licence1 = $params['licence1'];
		}
		else
		{
			$error++;
		}
	
		if($error ==0)
		{
			//on vire toutes les données de cette compet avant 
		
				$licence = array();
				if (isset($params['licence']) && $params['licence'] != '')
				{
					$licence = $params['licence'];
				}
			
				$cotisation_ops = new cotisationsbis();
				$paiements_ops = cms_utils::get_module('paiements');
				//$paiements_ops = new paiements();
				
				foreach($licence as $key=>$value)
				{
					
					$ref_action = $this->random_string(15);
					$query2 = "INSERT INTO ".cms_db_prefix()."module_cotisations_belongs (ref_action,id_cotisation,licence) VALUES ( ?, ?, ?)";
					$dbresultat = $db->Execute($query2, array($ref_action,$key,$licence1));
					//la requete a fonctionné ? On ajoute à la table Paiements
					if($dbresultat)
					{
						//on ajoute 
						$tableau = $cotisation_ops->types_cotisations($key);
						if(is_array($tableau))
						{
							$nom = $tableau['nom'];
							//echo $nom;
							$tarif = $tableau['tarif'];

						
							$query = "INSERT INTO ".cms_db_prefix()."module_paiements_paiements (licence,ref_action, module,nom, tarif) VALUES (?, ?, ?, ?, ?)";
							$dbresult = $db->Execute($query, array($licence1,$ref_action,'Cotisations',$nom, $tarif));
							if(!$dbresult)
							{

								$error = $db->ErrorMsg();
								echo $error;
							}
							
						//	$add = $paiements_ops->add_paiement($licence1,$ref_action,$nom,$tarif);
						//	var_dump($add);
						}//var_dump($tableau);
						//
						
						
					}
				}
			$this->SetMessage('Cotisation(s) ajouté(s) à ce membre !');
			
				
				
		}
		else
		{
			echo "Il y a des erreurs !";
		}
		


$this->Redirect($id, 'view_adherent_cotis',$returnid, array("licence"=>$licence1));

?>