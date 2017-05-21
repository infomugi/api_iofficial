<?php 

$string = "
<form action=\"<?php echo \$action; ?>\" method=\"post\">
    <div class=\"col-md-10 form-normal form-horizontal clearfix\">
        ";
        foreach ($non_pk as $row) {
            if ($row["data_type"] == 'text')
            {
                $string .= "\n\t    <div class=\"row form-group\">
                <div class=\"col-sm-4 control-label col-xs-12\">
                    <label class=\"required\" for=\"".$row["column_name"]."\">".label($row["column_name"])." </label>
                </div>
                <div class=\"col-md-8 col-xs-12\" data-toggle=\"tooltip\" title=\"".label($row["column_name"])."\">
                    <textarea class=\"form-control\" rows=\"3\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"><?php echo $".$row["column_name"]."; ?></textarea>
                    <?php echo form_error('".$row["column_name"]."') ?>
                </div>
            </div>";
        } else
        {
            $string .= "\n\t    <div class=\"row form-group\">
            <div class=\"col-sm-4 control-label col-xs-12\">
                <label class=\"required\" for=\"".$row["data_type"]."\">".label($row["column_name"])." </label>
            </div>
            <div class=\"col-md-8 col-xs-12\" data-toggle=\"tooltip\" title=\"".label($row["column_name"])."\">
                <input type=\"text\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo $".$row["column_name"]."; ?>\" />
                <?php echo form_error('".$row["column_name"]."') ?>
            </div>
        </div>";
    }
}
$string .= "\n\t    <button type=\"submit\" class=\"btn btn-primary pull-right\"><?php echo \$button ?></button> ";
$string .= "\n\t    <input type=\"hidden\" name=\"".$pk."\" value=\"<?php echo $".$pk."; ?>\" /> ";
$string .= "\n\t    <a href=\"<?php echo site_url('".$c_url."') ?>\" class=\"btn btn-default pull-right\">Cancel</a>";
$string .= "\n\t</div></form>
";

$hasil_view_form = createFile($string, $target."views/" . $c_url . "/" . $v_form_file);

?>