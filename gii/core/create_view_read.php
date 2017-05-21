<?php 

$string = "
<h2 style=\"margin-top:0px\">Detail ".ucfirst($table_name)."</h2>
<a href=\"<?php echo site_url('".$c_url."/create') ?>\" class=\"btn btn-primary\">Add ".ucfirst($table_name)."</a>
<a href=\"<?php echo site_url('".$c_url."/index') ?>\" class=\"btn btn-primary\"> Manage ".ucfirst($table_name)."</a>
<HR>
	<table class=\"table\">";
		foreach ($non_pk as $row) {
			$string .= "\n\t    <tr><td>".label($row["column_name"])."</td><td><?php echo $".$row["column_name"]."; ?></td></tr>";
		}
		$string .= "\n\t</table>
		";
		$hasil_view_read = createFile($string, $target."views/" . $c_url . "/" . $v_read_file);

		?>