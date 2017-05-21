<!doctype html>
<html>
<head>
	<title>Codeigniter Rest API CRUD Generator</title>
	<link rel="stylesheet" href="core/bootstrap.min.css"/>
</head>
<body>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Rest API CRUD Generator 1.0</a>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-8">
				<h3 style="margin-top: 0px">Backup Database</h3>
				<HR>

					<?php
//MySQL server and database
					$dbhost = 'localhost';
					$dbuser = 'root';
					$dbpass = '';
					$dbname = 'db_project_iofficial';
					$tables = '*';

//Call the core function
					backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables);

//Core function
					function backup_tables($host, $user, $pass, $dbname, $tables = '*') {
						$link = mysqli_connect($host,$user,$pass, $dbname);

    // Check connection
						if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
							exit;
						}

						mysqli_query($link, "SET NAMES 'utf8'");

    //get all of the tables
						if($tables == '*')
						{
							$tables = array();
							$result = mysqli_query($link, 'SHOW TABLES');
							while($row = mysqli_fetch_row($result))
							{
								$tables[] = $row[0];
							}
						}
						else
						{
							$tables = is_array($tables) ? $tables : explode(',',$tables);
						}

						$return = '';
    //cycle through
						foreach($tables as $table)
						{
							$result = mysqli_query($link, 'SELECT * FROM '.$table);
							$num_fields = mysqli_num_fields($result);
							$num_rows = mysqli_num_rows($result);

							$return.= 'DROP TABLE IF EXISTS '.$table.';';
							$row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
							$return.= "\n\n".$row2[1].";\n\n";
							$counter = 1;

        //Over tables
							for ($i = 0; $i < $num_fields; $i++) 
        {   //Over rows
        	while($row = mysqli_fetch_row($result))
        	{   
        		if($counter == 1){
        			$return.= 'INSERT INTO '.$table.' VALUES(';
        		} else{
        			$return.= '(';
        		}

                //Over fields
        		for($j=0; $j<$num_fields; $j++) 
        		{
        			$row[$j] = addslashes($row[$j]);
        			$row[$j] = str_replace("\n","\\n",$row[$j]);
        			if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
        			if ($j<($num_fields-1)) { $return.= ','; }
        		}

        		if($num_rows == $counter){
        			$return.= ");\n";
        		} else{
        			$return.= "),\n";
        		}
        		++$counter;
        	}
        }
        $return.="\n\n\n";
    }

    //save file
    $fileName = 'db-backup-'.(md5(implode(',',$tables))).'.sql';
    $handle = fopen($fileName,'w+');
    fwrite($handle,$return);
    if(fclose($handle)){
    	echo "<span class='alert text-center alert-info'>Done, the file name is: ".$fileName."</span>";
    	echo "<br>";
    	echo "<br>";
    	echo "<a class='btn pull-right btn-success' href=' ".$fileName."'>Download</a>";
    	exit; 
    }
}
?>
</div>
<div class="col-md-2">
</div>
</div>
</div>

</body>
</html>
