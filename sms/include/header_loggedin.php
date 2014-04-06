<?php session_start(); ?>
<div id="loggedin">
Je bent ingelogd als <?php echo $_SESSION['name']; ?> &nbsp;
<a href="#" id="logout">Log uit</a>
</div>