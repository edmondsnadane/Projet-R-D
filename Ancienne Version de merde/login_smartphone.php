

<div style="width:300px;margin-left:auto;margin-right:auto;">



<?php



/**

 * Page de login

*/

?>



<!--[if  IE]>

<?php  

  echo '<div style="border:1px solid navy;width:140px;padding:10px 0px 10px 0px;height:120px;float:left;">';


    if (isset($_POST['loginstudentsmartphone']) && $_POST['logintype']=="studentsmartphone")
		{
		if ($_POST['loginstudentsmartphone']!="")
			{
			echo '<span style="color:red;font-weight:bold;">Login incorrect !</span><br>';
			}
		else
			{
			 echo '<span style="color:red;font-weight:bold;">Login obligatoire !</span><br>';
			}
}


?>

   <h2>Planning &eacute;tudiants</h2><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight">Login : <br><input type="text" style="width:80px" name="loginstudentsmartphone">

    <input type="hidden" name="larg" id="screen_widt" value="">

	<input type="hidden" name="haut" id="screen_heigh" value="">

	<input type="submit" value="Envoyer"><input type="hidden" name="logintype" value="studentsmartphone">

    </form>
	

	<br><br>

    </div>



    <div style="border:1px solid navy;width:140px;margin-left:10px;height:120px;padding:10px 0px 10px 0px;float:left;">

    

<?php

    if (($_POST['loginprof']=="" || $_POST['password']=="") && $_POST['logintype']=="prof")

		{

			echo '<span style="color:red;font-weight:bold;">Login et mot de passe obligatoires !</span><br>';

		}

	elseif (isset($_POST['loginprof']) && isset($_POST['password'])  && $_POST['logintype']=="prof")

		{     

			echo '<span style="color:red;font-weight:bold;">Login ou mot de passe incorrects !</span><br>';

		}

	?>

<h2>Planning profs</h2><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_width').value=document.documentElement.clientWidth;document.getElementById('screen_height').value=document.documentElement.clientHeight">Login : <br><input type="text" style="width:80px" name="loginprof"><br>

    Mot de passe : <input type="password"  style="width:80px" name="password"><br>

	<input type="hidden" name="larg" id="screen_width" value="">

		<input type="hidden" name="haut" id="screen_height" value="">

    <input type="submit" value="Envoyer"><input type="hidden" name="logintype" value="prof">

    </form>

	

    </div>

	

	  

	

	

	

	

	<![endif]-->







<!--[if !IE]>-->





    <div style="border:1px solid navy;width:140px;padding:10px 5px 10px 0px;height:130px;float:left;">

 <?php
    if (isset($_POST['loginstudentsmartphone']) && $_POST['logintype']=="studentsmartphone")
		{
		if ($_POST['loginstudentsmartphone']!="")
			{
			echo '<span style="color:red;font-weight:bold;">Login incorrect !</span><br>';
			}
		else
			{
			 echo '<span style="color:red;font-weight:bold;">Login obligatoire !</span><br>';
			}
}


?>

   <h2>Planning &eacute;tudiants</h2><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_w').value=window.innerWidth;document.getElementById('screen_h').value=window.innerHeight">Login : <br><input type="text" style="width:80px" name="loginstudentsmartphone"><br>

    <input type="hidden" name="larg" id="screen_w" value="">

	<input type="hidden" name="haut" id="screen_h" value="">

	<input type="submit"><input type="hidden" name="logintype" value="studentsmartphone">

    </form>

    </div>   



	

	    <div style="border:1px solid navy;width:140px;margin-left:10px;height:130px;padding:10px 0px 10px 0px;float:left;">

    

	<?php

    if (($_POST['loginprof']=="" || $_POST['password']=="") && $_POST['logintype']=="prof")

        echo '<span style="color:red;font-weight:bold;">Login et mot de passe obligatoires !</span><br>';

    elseif (isset($_POST['loginprof']) && isset($_POST['password'])  && $_POST['logintype']=="prof")

        echo '<span style="color:red;font-weight:bold;">Login ou mot de passe incorrects !</span><br>';

?>

<h2>Planning profs</h2><br><form action="index.php" method="post" onsubmit="document.getElementById('screen_wi').value=window.innerWidth;document.getElementById('screen_he').value=window.innerHeight">Login : <br><input type="text" style="width:80px" name="loginprof"><br>

    Mot de passe : <br><input type="password" style="width:80px" name="password"><br>

	<input type="hidden" name="larg" id="screen_wi" value="">

		<input type="hidden" name="haut" id="screen_he" value="">

    <input type="submit"><input type="hidden" name="logintype" value="prof">

    </form>

	

    </div>

	



	



<!--<![endif]-->

		<a style="color:#0000EE" href="index.php?smartphone=non">Revenir à l'interface web classique</a>

	





    </div>

</div>

	

	<?php

    die;

?>