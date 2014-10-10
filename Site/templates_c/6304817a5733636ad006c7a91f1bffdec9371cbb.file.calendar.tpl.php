<?php /* Smarty version Smarty-3.1.18, created on 2014-10-09 13:21:35
         compiled from "template\include\calendar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:695154364a73c71560-86478021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6304817a5733636ad006c7a91f1bffdec9371cbb' => 
    array (
      0 => 'template\\include\\calendar.tpl',
      1 => 1412853693,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '695154364a73c71560-86478021',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54364a73c7a2b5_43778986',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54364a73c7a2b5_43778986')) {function content_54364a73c7a2b5_43778986($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
	<title>VT Calendar</title>

	<meta charset="UTF-8">

	<link rel="stylesheet" href="API/bootstrap-calendar-master/components/bootstrap2/css/bootstrap.css">
	<link rel="stylesheet" href="API/bootstrap-calendar-master/components/bootstrap2/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="API/bootstrap-calendar-master/css/calendar.css">

	<style type="text/css">
		.btn-twitter {
			padding-left: 30px;
			background: rgba(0, 0, 0, 0) url(https://platform.twitter.com/widgets/images/btn.27237bab4db188ca749164efd38861b0.png) -20px 6px no-repeat;
			background-position: -20px 11px !important;
		}
		.btn-twitter:hover {
			background-position:  -20px -18px !important;
		}
	</style>
</head>
<body>
<div class="container">


	<div class="page-header">

		<div class="pull-right form-inline">
			<div class="btn-group">
				<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
				<button class="btn" data-calendar-nav="today">Today</button>
				<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
			</div>
			<div class="btn-group">
				<button class="btn btn-warning" data-calendar-view="year">Year</button>
				<button class="btn btn-warning active" data-calendar-view="month">Month</button>
				<button class="btn btn-warning" data-calendar-view="week">Week</button>
				<button class="btn btn-warning" data-calendar-view="day">Day</button>
			</div>
		</div>

		<h3></h3>

	</div>

	<div class="row">
		<div class="span9">
		
	
			<div id="calendar"></div>
		</div>
		<div class="span3">
			<div class="row-fluid">
				<select id="first_day" class="span12">
					<option value="" selected="selected">First day of week language-dependant</option>
					<option value="2">First day of week is Sunday</option>
					<option value="1">First day of week is Monday</option>
				</select>
				<select id="language" class="span12">
					<option value="">Select Language (default: fr-FR)</option>
					<option value="nl-NL">Dutch</option>
					<option value="fr-FR">French</option>
					<option value="de-DE">German</option>
					<option value="el-GR">Greek</option>
					<option value="hu-HU">Hungarian</option>
					<option value="it-IT">Italian</option>
					<option value="pl-PL">Polish</option>
					<option value="pt-BR">Portuguese (Brazil)</option>
					<option value="ro-RO">Romania</option>
					<option value="es-CO">Spanish (Colombia)</option>
					<option value="es-MX">Spanish (Mexico)</option>
					<option value="es-ES">Spanish (Spain)</option>
					<option value="ru-RU">Russian</option>
					<option value="sv-SE">Swedish</option>
					<option value="zh-CN">简体中文</option>
					<option value="zh-TW">繁體中文</option>
					<option value="ko-KR">한국어</option>
				</select>
				<label class="checkbox">
					<input type="checkbox" value="#events-modal" id="events-in-modal"> Open events in modal window
				</label>
			</div>

		</div>
	</div>

	<div class="clearfix"></div>
	<br><br>
	
	<br><br>
	
	<!--<div id="disqus_thread"></div>
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
-->
	<div class="modal hide fade" id="events-modal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Event</h3>
		</div>
		<div class="modal-body" style="height: 400px">
		</div>
		<div class="modal-footer">
			<a href="#" data-dismiss="modal" class="btn">Close</a>
		</div>
	</div>

	<script type="text/javascript" src="API/bootstrap-calendar-master/components/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/components/underscore/underscore-min.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/components/bootstrap2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/components/jstimezonedetect/jstz.min.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/nl-NL.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/fr-FR.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/de-DE.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/el-GR.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/it-IT.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/hu-HU.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/pl-PL.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/pt-BR.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/ro-RO.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/es-CO.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/es-MX.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/es-ES.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/ru-RU.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/language/sv-SE.js"></script>
    <script type="text/javascript" src="API/bootstrap-calendar-master/js/language/zh-CN.js"></script>
    <script type="text/javascript" src="API/bootstrap-calendar-master/js/language/cs-CZ.js"></script>
    <script type="text/javascript" src="API/bootstrap-calendar-master/js/language/ko-KR.js"></script>
    <script type="text/javascript" src="API/bootstrap-calendar-master/js/language/zh-TW.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/calendar.js"></script>
	<script type="text/javascript" src="API/bootstrap-calendar-master/js/app.js"></script>

	<script type="text/javascript">
	
	
	
		var disqus_shortname = 'bootstrapcalendar'; // required: replace example with your forum shortname
		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
	
	
	
		
		
	var calendar = $('#calendar').calendar({
    events_source: [
        {
            "id": "999",
            "title": "Event 1",
            "url": "www.example.com",
            "class": "event-important",
            "start": "1362938400000",
			"end":   "1363197686300"
        },
        
    ]});
		
	</script>
</div>
</body>
</html>
<?php }} ?>
