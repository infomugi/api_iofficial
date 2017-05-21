<?php 

$string = "
<div class=\"row\" style=\"margin-bottom: 10px\">
    <div class=\"col-md-4\">
        <?php echo anchor(site_url('".$c_url."/create'),'Add ".ucfirst($table_name)."', 'class=\"btn btn-primary\"'); ?>
    </div>
    <div class=\"col-md-4 text-center\">
        <div style=\"margin-top: 8px\" id=\"message\">
            <?php echo \$this->session->userdata('message') <> '' ? \$this->session->userdata('message') : ''; ?>
        </div>
    </div>
    <div class=\"col-md-4 text-right\">
        <form action=\"<?php echo site_url('$c_url/index'); ?>\" class=\"form-inline\" method=\"get\">
            <div class=\"input-group\">
                <input type=\"text\" class=\"form-control\" name=\"q\" value=\"<?php echo \$q; ?>\">
                <span class=\"input-group-btn\">
                    <?php 
                    if (\$q <> '')
                    {
                        ?>
                        <a href=\"<?php echo site_url('$c_url'); ?>\" class=\"btn btn-default\">Reset</a>
                        <?php
                    }
                    ?>
                    <button class=\"btn btn-primary\" type=\"submit\">Search</button>
                </span>
            </div>
        </form>
    </div>
</div>
<table class=\"table table-bordered\" style=\"margin-bottom: 10px\">
    <tr>
        <th>No</th><th>Action</th>";
        foreach ($non_pk as $row) {
            $string .= "\n\t\t<th>" . label($row['column_name']) . "</th>";
        }
        $string .= "\n\t\t
    </tr>";
    $string .= "<?php
    foreach ($" . $c_url . "_data as \$$c_url)
    {
        ?>
        <tr>";

            $string .= "\n\t\t\t<td style=\"text-align:center\"><?php echo ++\$start ?></td>";
            $string .= "\n\t\t\t<td style=\"text-align:center\">"
            . "\n\t\t\t\t <div class=\"btn-group\">
            <button type=\"button\" class=\"btn btn-default btn-sm dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">
                <i class=\"fa fa-gear\"></i> Aksi <span class=\"caret\"></span>
            </button>
            <ul class=\"dropdown-menu dropdown-menu-act\" role=\"menu\"><?php "
                . "\n\t\t\t\techo \"<li>\".anchor(site_url('".$c_url."/read/'.$".$c_url."->".$pk."),'<i class=\"fa fa-eye\"></i> View').\"</li>\"; "
                . "\n\t\t\t\techo ''; "
                . "\n\t\t\t\techo \"<li>\".anchor(site_url('".$c_url."/update/'.$".$c_url."->".$pk."),'<i class=\"fa fa-edit\"></i> Edit').\"</li>\"; "
                . "\n\t\t\t\techo ''; "
                . "\n\t\t\t\techo \"<li>\".anchor(site_url('".$c_url."/delete/'.$".$c_url."->".$pk."),'<i class=\"fa fa-close\"></i> Delete','onclick=\"javasciprt: return confirm(\\'Are You Sure ?\\')\"').\"</li>\"; "
                . "\n\t\t\t\t?></ul>
            </div>"
            . "\n\t\t\t</td>";

            foreach ($non_pk as $row) {
                $string .= "\n\t\t\t<td><?php echo $" . $c_url ."->". $row['column_name'] . " ?></td>";
            }




            $string .=  "\n\t\t</tr>
            <?php
        }
        ?>
    </table>
    <div class=\"row\">
        <div class=\"col-md-6\">
            <a href=\"#\" class=\"btn btn-primary\">Total Record : <?php echo \$total_rows ?></a>";
            if ($export_excel == '1') {
                $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/excel'), 'Excel', 'class=\"btn btn-primary\"'); ?>";
            }
            if ($export_word == '1') {
                $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/word'), 'Word', 'class=\"btn btn-primary\"'); ?>";
            }
            if ($export_pdf == '1') {
                $string .= "\n\t\t<?php echo anchor(site_url('".$c_url."/pdf'), 'PDF', 'class=\"btn btn-primary\"'); ?>";
            }
            $string .= "\n\t    </div>
            <div class=\"col-md-6 text-right\">
                <?php echo \$pagination ?>
            </div>
        </div>
        ";


        $hasil_view_list = createFile($string, $target."views/" . $c_url . "/" . $v_list_file);

        ?>