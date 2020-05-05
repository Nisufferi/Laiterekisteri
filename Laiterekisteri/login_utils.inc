<?php
	
	function check_session()
	{
		if ( !isset($_SESSION['username']))
		{
			header("Location: login.php?virhe=2");
			exit();
		}
	}
?>