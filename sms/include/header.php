<head>
	<title>
		Schildpatio Management System(SMS)
	</title>
	<link href="/sms/include/stylenew.css" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/sms/include/js/login.js"> </script>
	<link rel="icon" 
      type="image/png" 
      href="/sms/include/images/favicon.ico">
</head>
	<body>


<div id="navBar">

<?php
if ($loggedin){
?>
    <div id="subDiv1">
  	<div id="navigation">
  <?php
if ($_SESSION['userid']){
	?>

	<?php 
	if ($_SESSION['admin']==1){ 
		?>
		<a href="/sms/manage/">Manage</a>
	<?php
}
?> 
	<a href="/sms/vastekosten/">Vastekosten</a>
<?php
}
?>
</div>

		
</div>

<?php }
?>



  <div id="subDiv2"></div>
    <div id="subDiv3">

<div id="logginstatus">
			 
						<?php
						
					if ($_SERVER['REQUEST_URI']!='/sms/'){	
					if(!$loggedin){
					?>
					<script>location.href='/sms/'</script>
					<?php
					} else {
						include(ROOT ."/include/header_loggedin.php");
					}
					}
							else {
							if (!$loggedin){
							include(ROOT ."/include/header_login.php"); 
							}
								else {
								include(ROOT ."/include/header_loggedin.php");
									}
					}
					?>


</div>


</div>
</div>

	