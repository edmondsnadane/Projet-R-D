

<div style="width:510px;margin-left:auto;margin-right:auto;"><br><br>

<img src="titre.jpg" width="509" alt="logo VT Agenda"><br>





<!--[if  IE]>

<?php  
	//message de déconnexion réussie
	    if ($_GET['disconnect']=="true" )
{
		echo '<div style="background-color:#006600;color:white;width:100%;height:30px;padding-top:13px;">Deconnexion réussie</div><br>';
}


	//message d'erreur des etudiants
	    if ($_POST['loginstudent']!="" && $_POST['logintype']=="student")
{
		echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Login incorrect !</div><br>';
}
    elseif (isset($_POST['loginstudent']) && $_POST['logintype']=="student")
{
        echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Login obligatoire !</div><br>';	
		}
	//message d'erreur des profs
    if (($_POST['loginvrac']=="" || $_POST['password']=="") && $_POST['logintype']=="vrac")
{
        echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Login et mot de passe obligatoires !</div><br>';
}
    elseif (isset($_POST['loginvrac']) && isset($_POST['password'])  && $_POST['logintype']=="vrac")
{
        echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Mauvais login ou mot de passe !</div><br>';
	}
 

echo '<div style="background-image:url(bg_form_login.png);border:1px solid navy;width:243px;padding:10px 5px 10px 0px;height:210px;float:left;">';

	

	?>

   <h2><span style="color:white">Planning des &eacute;tudiants</span></h2><br><br><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight">Login : <input type="text" name="loginstudent"><br><br>

    <br>

	<input type="hidden" name="larg" id="screen_widt" value="">

	<input type="hidden" name="haut" id="screen_heigh" value="">
Rester connecté : <input type="checkbox" name="cookieetudiant" value="1"  ><br><br>
	<input type="submit" value="Envoyer"><input type="hidden" name="logintype" value="student">

    </form><br><br><br>
<a href="aide.pdf">Mode d'emploi</a>
    </div>



  

	

	<div style="background-image:url(bg_form_login.png);border:1px solid navy;width:243px;margin-left:10px;height:210px;padding:10px 0px 10px 5px;float:left;">

    



<h2><span style="color:white">Planning des profs</span></h2><br><br><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_wi').value=document.documentElement.clientWidth;document.getElementById('screen_hei').value=document.documentElement.clientHeight">Login : <input type="text" name="loginvrac"><br><br>

    Mot de passe : <input type="password" name="password"><br>

	<input type="hidden" name="larg" id="screen_wi" value="">

		<input type="hidden" name="haut" id="screen_hei" value="">
Rester connecté : <input type="checkbox" name="cookieprof" value="1"  ><br>
    <input type="submit" value="Envoyer"><input type="hidden" name="logintype" value="vrac">

    </form>
<br>
	<br>

	<a href="changement_mdp.php">Changer de mot de passe</a><br><br>
<a href="aide.pdf">Mode d'emploi</a>
    </div>	

	

	

	<![endif]-->







<!--[if !IE]>-->
<?php
	//message de déconnexion réussie
	    if ($_GET['disconnect']=="true" )
{
		echo '<div style="background-color:#006600;color:white;width:100%;height:30px;padding-top:13px;">Deconnexion réussie</div><br>';
}
	//message d'erreur des etudiants
	    if ($_POST['loginstudent']!="" && $_POST['logintype']=="student")
{
		echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Login incorrect !</div><br>';
}
    elseif (isset($_POST['loginstudent']) && $_POST['logintype']=="student")
{
        echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Login obligatoire !</div><br>';	
		}
	//message d'erreur des profs
    if (($_POST['loginvrac']=="" || $_POST['password']=="") && $_POST['logintype']=="vrac")
{
        echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Login et mot de passe obligatoires !</div><br>';
}
    elseif (isset($_POST['loginvrac']) && isset($_POST['password'])  && $_POST['logintype']=="vrac")
{
        echo '<div style="background-color:red;color:white;width:100%;height:30px;padding-top:13px;">Mauvais login ou mot de passe !</div><br>';
	}
 

	echo '<div style="background-image:url(bg_form_login.png);border:1px solid navy;width:243px;padding:10px 5px 10px 0px;height:220px;float:left;">';



?>

   <h2><span style="color:white">Planning des &eacute;tudiants</span></h2><br><br><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight">Login : <input type="text" name="loginstudent"><br><br>

    <br>

	<input type="hidden" name="larg" id="screen_widt" value="">

	<input type="hidden" name="haut" id="screen_heigh" value="">
Rester connecté : <input type="checkbox" name="cookieetudiant" value="1"  ><br><br>
	<input type="submit"><input type="hidden" name="logintype" value="student">

    </form><br><br>
<a href="aide.pdf">Mode d'emploi</a>
    </div>



	

	    <div style="background-image:url(bg_form_login.png);border:1px solid navy;width:243px;margin-left:10px;height:220px;padding:10px 0px 10px 5px;float:left;">

    



<h2><span style="color:white">Planning des profs</span></h2><br><br><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_wi').value=window.innerWidth;document.getElementById('screen_hei').value=window.innerHeight">Login : <input type="text" name="loginvrac"><br><br>

    Mot de passe : <input type="password" name="password"><br>

	<input type="hidden" name="larg" id="screen_wi" value="">

		<input type="hidden" name="haut" id="screen_hei" value="">
Rester connecté : <input type="checkbox" name="cookieprof" value="1"  ><br>
    <input type="submit"><input type="hidden" name="logintype" value="vrac">

    </form><br>
	<br>
	<a href="changement_mdp.php">Changer de mot de passe</a><br><br>
<a href="aide.pdf">Mode d'emploi</a>
    </div>	
	
	  

<!--<![endif]-->



	

    <br><br>

    <div style="width:100%;text-align:center;clear:left;padding-top:40px;">
<?php
//MERCI DE NE PAS EFFACER LE NOM DE MON COLLEGUE ET LE MIEN. VOUS POUVEZ MODIFIER TOUTE L'INTERFACE WEB MAIS LA SEULE CHOSE QU'ON DEMANDE, C'EST DE LAISSER NOS DEUX NOMS.
?>
    D&eacute;velopp&eacute; par <span style="font-weight:bold;">Bruno MILLION</span> (IUT GMP) et par <span style="font-weight:bold;">Ga&euml;tan COLOMBIER</span> (IUT GMP) pour le PST de Ville d'Avray (Université Paris Ouest) - <?php echo $compteur;?> pages vues.<br>

    <a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-html401-blue" alt="Valid HTML 4.01 Transitional" ></a>

    <a href="http://jigsaw.w3.org/css-validator/check/referer/"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" ></a>

    <a href="http://www.php.net/"><img style="border:0;width:88px;height:31px" src="http://www.php.net/images/logos/php-power-white.png" alt="Powered by PHP" ></a>

    <a href="http://www.mysql.com"><img style="border:0;width:70px;height:36px" src="http://www.cygneweb.com/images/logo_mysql.gif" alt="Powered by Mysql" ></a>

	<br>

	    <a href="http://www.mozilla-europe.org">Affichage optimisé pour Firefox<img style="border:0;width:67px;height:25px" src="firefox.png" alt="optimisé pour Firefox" ></a>

	<br>

	  <a href="version.txt">Version 5.2.2</a>	

    </div>

    </div>

	

	<a style="color:#0000EE" href="index.php?smartphone=oui">Utiliser l'interface web optimisée pour les téléphones portables</a>

	</div>
</body>

</html>
	<?php

    die;

?>