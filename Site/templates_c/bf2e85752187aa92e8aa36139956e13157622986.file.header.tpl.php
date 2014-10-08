<?php /* Smarty version Smarty-3.1.18, created on 2014-10-08 15:54:57
         compiled from "template\include\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3013254353bfa894fd1-39340041%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf2e85752187aa92e8aa36139956e13157622986' => 
    array (
      0 => 'template\\include\\header.tpl',
      1 => 1412776495,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3013254353bfa894fd1-39340041',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54353bfa899319_95606314',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54353bfa899319_95606314')) {function content_54353bfa899319_95606314($_smarty_tpl) {?><nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-calendar"></span> VT Calendar</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> nom prenom <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Outils</a></li>
            <li><a href="#">Modules</a></li>
            <li><a href="#">Droits</a></li>
            <li><a href="#">Heures</a></li>
			<li><a href="#">Export PDF</a></li>
			<li><a href="#">Flux RSS</a></li>
			<li><a href="#">Config</a></li>
          </ul>
        </li>
      </ul>
	  <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Déconnexion</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav><?php }} ?>
