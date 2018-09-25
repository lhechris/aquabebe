<?php
	
  require_once($_SERVER["DOCUMENT_ROOT"]."/script/trace.php");

	function get_param($param)
  {
    // récupère un paramètre via POST
    // vérifie s'il est vide. Si oui, lui met une chaîne vide
    // trim()  retourne la chaîne str  , après avoir supprimé les caractères invisibles en début et fin de chaîne.
    
    if (isset($_POST[$param]))
    {
      return trim($_POST[$param]);
    }

    return "";
  }
  
  function get_value($row, $index)
  {
    // récupère la valeur d'un index de tableau
    //  si aucune  valeur n'est définie, renvoit une chaîne vide.
    if (isset($row[$index]))
    {
      return trim($row[$index]);
    }

    return "";
  }
  
  // ---------------------------------------------
  //
  // ---------------------------------------------
  
  function verify_text($row)
  {
		$_POST[$row['name']] = get_param($row['name']);
		if($row['required'])
    {
			if(!filter_var($_POST[$row['name']],FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/(.*)[a-zA-Z]+(.*)/"))))
      {
				return _MSG_ERREUR_REQUIRED_VALUE;
			}
		}
		return null;
	}
    
  // -----------------------------------------------------------------------------------------
  // verify_tel() : vérifie que le n° renseigné contient 10 caractères numériques
  // -----------------------------------------------------------------------------------------
	function verify_tel($row)
	{
		$value = get_param($row['name']);
		$_POST[$row['name']] = $value;
		if(!empty($value)) 
		{
			if	(	(!filter_var($value, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[0-9]{10}$/")))) ) 
			{
				return _MSG_ERREUR_TEL;
			}
		} 
		else if($row['required'])
		{
			return _MSG_ERREUR_REQUIRED_VALUE;
		}
		return null;
	}
	
	
    
  // -----------------------------------------------------------------------------------------
  // verify_tel_portable() : vérifie que le n° renseigné contient 10 caractères numériques
  //                         et qu'il commence par 06 ou 07
  // -----------------------------------------------------------------------------------------
	function verify_tel_portable($row)
	{
		$value = get_param($row['name']);
		$_POST[$row['name']] = $value;
		
		if(!empty($value)) 
		{
			if	(	(!filter_var($value, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^[0-9]{10}$/")))) ) 
			{
				return _MSG_ERREUR_TEL;
			}
			if	(	(!filter_var($value, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^0[67]/")))) ) 
			{
				return _MSG_ERREUR_TEL_PORTABLE;
			}
		} 
		else if($row['required'])
		{
			return _MSG_ERREUR_REQUIRED_VALUE;
		}
		return null;
	}
  // ---------------------------------------------
  //
  // ---------------------------------------------
	function verify_mail($row)
  {
		$value = get_param($row['name']);
		$_POST[$row['name']] = $value;
		if(!empty($value)) 
    {
			if (!filter_var($value, FILTER_VALIDATE_EMAIL)) 
      {
				return _MSG_ERREUR_MAIL;
			}
		} 
    else if($row['required'])
    {
			return _MSG_ERREUR_REQUIRED_VALUE;
		}
		return null;
	}
  
  // -------------------------------------------------------------------------
  // verify_mail2($row) 
  // Vérifie si l'e-mail indiqué existe dans la base de données
  // Sert dans script/validation_demenagement.php
  // -------------------------------------------------------------------------
  function verify_mail2($row) 
	{
		$value = get_param($row['name']);
		$_POST[$row['name']] = $value;
    
    // l'e-mail est renseigné
		if(!empty($value)) 
		{
      // l'e-mail a déjà été utilisé
			if (is_set_demenagement($value)) 
			{
				return _MSG_ERREUR_MAIL_2;
			}
		} 
    // l'e-mail n'est pas renseigné
		else if($row['required'])
		{
			return _MSG_ERREUR_REQUIRED_VALUE;
		}
		return null;
	}
	
  // -------------------------------------------------------------
  // verify_cp($row)
  // -------------------------------------------------------------
	function verify_cp($row)
  {
		$value = get_param($row['name']);
		$_POST[$row['name']] = $value;
		if(!empty($value)) 
    {
			if (!filter_var($value, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[0-9][0-9][0-9][0-9][0-9]/")))) 
      {
				return _MSG_ERREUR_CP;
			}
		} 
    else if($row['required'])
    {
			return _MSG_ERREUR_REQUIRED_VALUE;
		}
		return null;
	}
	function verify_textlong($row)
  {
		$_POST[$row['name']] = get_param($row['name']);
		if($row['required'])
    {
			if(!filter_var($_POST[$row['name']],FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/(.*)[a-zA-Z]+(.*)/"))))
      {
				return _MSG_ERREUR_REQUIRED_VALUE;
			}
		}
		return null;
	}
  
  // ----------------------------------------------------------------------
  // verify_radio()
  // ----------------------------------------------------------------------
  
  function verify_radio($row)
	{
    trace("--->verify_radio()");
		$value = get_param($row['name']);
    trace("   value : $value");
    
    // si une valeur a été renseignée, on vérifie la valeur
		if($value!="") 
		{
			$max=sizeof(@split(",",substr(get_value($row, 'type'),6)));
			if (($value<0) || ($value>=$max))
			{
				return _MSG_ERREUR_RADIO;
			}
		} 
    
    // si aucune valeur n'a été renseignée, on renvoie un message d'erreur
		else if($row['required'])
		{
			return _MSG_ERREUR_REQUIRED_VALUE;
		}
		return null;
	}	
  
  // VERSION PRECEDENTE (jamais utilisée a priori)
	/*function verify_radio($row)
  {
    $value = get_param($row['name']);
		$max=sizeof(@split(",",substr(get_value($row, 'type'),6)));
		if (($value<0) || ($value>=$max)) 
    {
			return _MSG_ERREUR_RADIO;
		}
		return null;
	}
  */
  
  // ----------------------------------------------------------------------
  // verify_checkbox()
  // ----------------------------------------------------------------------
	function verify_checkbox($row)
  {
    $value = get_param($row['name']);
		if(!empty($value)) 
    {
			$_POST[$row['name']] = true;
		} 
    else 
    {
			$_POST[$row['name']] = false;
			if($row['required'])
      {
				return _MSG_ERREUR_REQUIRED_VALUE;
			}
		}
		return null;
	}
	function verify_date($row)
  {
		$value = get_param($row['name']);
		$_POST[$row['name']] = $value;
		if(!empty($value)) 
    {
			$date=@split("/",$value);
			if (3!=sizeof($date)) 
      {
				return _MSG_ERREUR_DATE_1;
			}
			if (!checkdate($date[1],$date[0],$date[2])) 
      {
				return _MSG_ERREUR_DATE_2;
			}
		} 
    else if($row['required'])
    {
			return _MSG_ERREUR_REQUIRED_VALUE;
		}
		return null;
	}
	function verify_none($row)
  {
		return null;
	}
	
	function verify($pattern) 
  {
		trace("-->verify()");
    $result=array();
		foreach ($pattern as $row)
    {
      $my_trace = $row['type'];
      trace("row['type'] : $my_trace");
      $my_trace = $row['name'];
      trace("row['name'] :: $my_trace");
			if ("radio"==substr($row['type'],0,5))
      {
				$verify_function="verify_radio";
			} 
      else if ("function"==substr($row['type'],0,8))
      {
				$verify_function="verify_".substr($row['type'],9);
			} 
      else
      {
				$verify_function="verify_".$row['type'];
			}
      trace("verify_function = $verify_function");
      
			$temp = $verify_function($row);
      trace ("temp = $temp");
			if(null!=$temp)
      {
				$result[$row['name']]=$temp;
			}
		}
		trace("<--verify()");
		return $result;
	}
  
  //------------------------------------------------------------------------
  // input()
  //------------------------------------------------------------------------
	function input($pattern,$errors,&$values) 
  {
		if(is_array($pattern)) 
    {
			foreach ($pattern as $row)
      {
				$class="";
        $post_name=get_param($row['name']);
        $row_name=get_value($row, 'name');
        $errors_name=get_value($errors, $row_name);
        
				if(null!=get_value($errors, get_value($row, 'name')))
        {
					$class="class=\"error\"";
				}
        
        if (("text"==$row['type']) || ("mail"==substr($row['type'],0,4)) || ("tel"==$row['type']) || ("tel_portable"==$row['type'])) 
				{
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>
					<input ".$class." type=\"text\" size=\"53\" maxlength=\"150\" name=\"".$row['name']."\" value=\"".$post_name."\" />
					";
				}
        // PRECEDENTE VERSION
				/*if (("text"==$row['type']) || ("mail"==$row['type']) || ("tel"==$row['type'])) 
        {
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>
					<input ".$class." type=\"text\" size=\"53\" maxlength=\"150\" name=\"".$row['name']."\" value=\"".$post_name."\" />
					";
				}
        */
        
				if ("textlong"==$row['type'])
        {
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>
					<TEXTAREA ".$class." name=\"".$row_name."\" COLS=\"40\">".$post_name."</TEXTAREA>
					";
				}
				if ("cp"==$row['type'])
        {
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>
					<input ".$class." type=\"text\" size=\"53\" maxlength=\"5\" name=\"".$row['name']."\" value=\"".$post_name."\" />
					";
				}
				if ("checkbox"==$row['type'])
        {
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>";
					if($post_name)
          {
						$select=" checked=\"checked\"";
					} 
          else 
          {
						$select="";
					}
					$values[$row['name']] .= "<input ".$class.$select." type=\"checkbox\" name=\"".$row['name']."\" value=\"true\" />";
				}
				if ("radio"==substr($row['type'],0,5))
        {
					$vals=@split(",",substr($row['type'],6));
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>";
					$oldValue = $post_name;
					$i=0;
          
					foreach($vals as $val)
          {
						if((null==$oldValue) || ($i!=$oldValue))
            {
							$select="";
						} 
            else 
            {
							$select=" checked=\"checked\"";
						}
						$values[$row['name']] .= "<input ".$class.$select." type=\"radio\" name=\"".$row['name']."\" value=\"".($i++)."\">"
							.$val."</input>
							";
					}
				}
				if ("date"==$row['type'])
        {
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>
					<input ".$class." type=\"text\" size=\"53\" maxlength=\"10\" name=\"".$row['name']."\" value=\"".$post_name."\" />
					";
				}
				if ("function"==substr($row['type'],0,8))
        {
					$functionName=substr($row['type'],9);
					$values[$row['name']]="<span class=\"error\">".$errors_name."</span>";
					$functionName($values,$row,$errors);
				}
			}
		}
	}
	
	function text($pattern,&$values) 
  {
		foreach ($pattern as $row)
    {
			if(isset($row['name']))
      {
				// DEBUG
        //$toto = get_param($row['name']);
        //echo "SVG : toto = $toto";
        // END-DEBUG
        
        if (!isset($values[$row['name']]))
        {
          $values[$row['name']] = "";
        }

        $values[$row['name']].=get_param($row['name']);
			}
		}
	}
	
	function createResetButton()
  {
		/* return  "              <button type=\"reset\">\n"
			."                <img class=\"button\" src=\"".DOCUMENT_ROOT."/images/effacer.gif\" border=\"0\" alt=\""._EFFACER."\" />\n"
			."              </button>\n";*/
		return "<input type=\"reset\"/>";
	}
	
	function createSubmitButton($value,$label) 
  {
		/*return "              <button type=\"submit\" name=\"action\" value=\"".($action-1)."\" >\n"
					."                <img class=\"button\" src=\"".DOCUMENT_ROOT."/images/precedent.gif\" border=\"0\" alt=\"".$pattern[$action-1][2]."\" />\n"
					."              </button>\n";*/
          
    trace("-> createSubmitButton()"); trace("  value : $value, label $label");
		return "<input type=\"submit\" name=\"submit\" value=\"$label\" onclick=\"document.getElementById('action').value=$value; form.submit();\" />";
	}
	
  // ----------------------------------------------------------------------------
  // writeForm()
  // ----------------------------------------------------------------------------
	function writeForm($pattern) 
  {
    trace("-> writeForm()");
		
    $values = array();
    $errors = 0;
		
		//toutes les valeurs arrivée en paramètres POST doivent rester en mémoire => passage en champ caché
		//sauf le champ 'action' car il est créé directement à l'ouverture du formulaire (vers la ligne 474, qui affiche un '<form'
		trace("  valeurs entrées : ");
		foreach ($_POST as $postName=>$postValue)
    {
			if ($postName != "action")
    	{
				$values[$postName] = "<input type=\"hidden\" name=\"$postName\" value=\"$postValue\" />";
				trace("    $values[$postName]");
			}
		}
    
		//Détermine l'action courante
    $action = get_param('action');
    trace("  action courante : $action");
		
		if ( ( ""==$action) || filter_var($action,FILTER_VALIDATE_INT) ) 
    {
			$action=intval($action);
		} 
    else 
    {
			for($i=0;$i<sizeof($pattern);$i++) 
      {
				$row=$pattern[$i];
				$short=substr($action,strpos($action,$row[2]),strlen($row[2]));
				if ($short==$row[2])
        {
					$action=$i;
					break;
				}
			}
		}
    trace("  action courante (après transformation) : $action");
		
		if($action>0) 
    {
			//on vérifie s'il y a des erreurs à l'étape précédente. En cas d'erreur on retourne à l'étape précédente.
			$errors = verify($pattern[$action-1][1]);
			if(0!=count($errors))
      {
				$action = $action-1;
        trace("  il y a des erreurs");
        trace ("erreur : $errors");
			}
		}
		
		//détermine la valeur des champs et des boutons
		
		if ( $action<sizeof($pattern)) 
    {
			$form=true;
			$visualisation=false;
			input($pattern[$action][1],$errors,$values);
			$button1=createResetButton();
      
			if($action>0)
      {
				$button2 = createSubmitButton(($action-1),"&lt;&lt; ".$pattern[$action-1][2]);
        trace("  ligne 376 : $button2");
			} 
      else 
      {
				$button2=null;
			}
      
			if(($action+1)<sizeof($pattern))
      {
				$button3 = createSubmitButton(($action+1),$pattern[$action+1][2]." &gt;&gt;");
        trace("  ligne 386 : $button3");
			} 
      else if(1==sizeof($pattern))
      {
				$button3 = createSubmitButton(($action+1),_VISUALISER." &gt;&gt;");
        trace("  ligne 391 : $button3");
       } 
      else 
      {
				$button3 = createSubmitButton(($action+1),_VALIDER." &gt;&gt;");
        trace("  ligne 395 : $button3");
			}
			$result=null;
		}
		
		if ( $action==sizeof($pattern)) 
    {
      trace("action = taille de pattern = $action");
      
			if(1==sizeof($pattern))
      {
				$form=true;
				$visualisation=true;
				text($pattern[0][1],$values);
				$button1 = createSubmitButton(($action-1),"&lt;&lt; "._MODIFIER);
				$button2 = createSubmitButton(($action+1),_VALIDER." &gt;&gt;");
        trace("  ligne 410 : $button1");
        trace("  ligne 413 : $button2");				
				$result=null;
			} 
      else 
      {
				$action ++; 
			}
		}
		
		if (  $action==(sizeof($pattern)+1)) 
    {
      trace("action = taille de pattern + 1 = $action");
      
			$form=false;
			$visualisation=false;
			$button1 = "";
			$button2 = "";
			
			foreach($pattern as $etape)
      {
				text($etape[1],$values);
			}
			
			$result = callbackSend();
		}
		
		
		//debut du formulaire
		echo "\n  <div class=\"formulaire\">\n";
		//Onglets
		echo "    <ul class=\"onglets\">\n";
		foreach ($pattern as $onglet){
			if (isset($pattern[$action]) && $onglet == $pattern[$action]) 
      {
				$class=" class=\"actif\"";
			} 
      else 
      {
				$class="";
			}
			echo "      <li".$class.">".$onglet[0]."</li>\n";
		}
		if($action>=sizeof($pattern))
    {
			echo "      <li class=\"last actif\"></li>\n"
				."    </ul>\n";
		} 
    else 
    {
			echo "      <li class=\"last\"></li>\n"
			."    </ul>\n";
		}
		//Champs du formulaire
		echo "    <div class=\"fields\">\n";
		if($form) 
    {
    	// Création d'un champ caché pour stocker l'action à envoyer dans le formulaire
			echo "      <form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" id=\"action\" name=\"action\" value=\"\" />\n";
		}

		echo "        <table>\n";
			//si on est dans les étapes actives du formulaire
			if($action<sizeof($pattern))
      {
        trace("  on est dans les étapes actives du formulaire");
        trace('  pattern[action][1] : '.$pattern[$action][1]);
				echo "          <caption>\n"
					."            <div class=\"redStar\">&nbsp;*</div> Ces informations sont indispensables pour traiter votre demande.\n"
					."          </caption>\n";
			
				foreach ($pattern[$action][1] as $row)
        {
					$mandatory = "";
					if($form && $row['required'])
          {
						$mandatory = "<div class=\"redStar\">&nbsp;*</div>";
					}

					if(isset($values[$row['name']]))
          {
						echo "          <tr>\n"
							."            <td class=\"label\">".$row['label'].$mandatory."</td>\n"
							."            <td class=\"value\">".$values[$row['name']]."</td>\n"
							."          </tr>\n";
						unset($values[$row['name']]);
					} 
          else 
          {
						echo "          <tr>\n"
							."            <td colspan=\"2\" class=\"separator\">".$row['label'].$mandatory."</td>\n"
							."          </tr>\n";
					}
				}
			}
			if($visualisation){
				foreach ($pattern as $etape) 
        {
					foreach ($etape[1] as $row)
          {
						if(null!=$values[$row['name']])
            {
							echo "          <tr>\n"
								."            <td class=\"label\">".$row['label'].$mandatory."</td>\n"
								."            <td class=\"value\">".$values[$row['name']]."</td>\n"
								."          </tr>\n";
							unset($values[$row['name']]);
						} 
            else 
            {
							echo "          <tr>\n"
								."            <td colspan=\"2\" class=\"separator\">".$row['label'].$mandatory."</td>\n"
								."          </tr>\n";
						}
					}
				}
			}
			
			//affichage des champs cachés, des boutons et des résultats 
			echo "          <tr>\n"
				."            <td class=\"buttons\" colspan=\"2\">\n";			
			//affichage des champs cachés
			if($form) 
      {
				foreach ($values as $value)
        {
					echo "              ".$value."\n";
				}
			}
			
			if (isset($button1)) echo $button1;
			if (isset($button2)) echo $button2;
			if (isset($button3)) echo $button3;
			echo "            </td>\n"
				."          </tr>\n";
				
			echo "          <tr>\n"
				."            <th colspan=\"2\">".$result."&nbsp;</th>\n"
				."          </tr>\n";
		
			echo "        </table>\n";

			
			if($form) 
      {
				echo "      </form>\n";
			}
	
		echo "    </div>\n"
			."    <div class=\"bottom\"></div>\n"
			."  </div>\n";
			
		echo "  <hr/>\n";
    
    trace("<- writeForm()");
	}
	
	
?>
