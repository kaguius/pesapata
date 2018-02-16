<?php
	
	$host='localhost';
	$db='pesapata_direct';
	$user='root';
	$pwd='kaguius';
	
	if (mysql_connect($host,$user,$pwd))
	{
		if (!mysql_select_db($db))
		{
        		echo 'Database Error: ','Unable to select the specified HR database for use.';
		}
	}
	else
	{
        	echo 'Database Error: ','Unable to connect to the HR database server.';
	}
?>
