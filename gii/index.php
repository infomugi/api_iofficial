<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
require_once 'core/harviacode.php';
require_once 'core/helper.php';
require_once 'core/process.php';
?>
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
            <form action="index.php" method="POST">
                <HR>
                    <h5 style="margin-top: 0px">Pilih Tabel - <a href="<?php echo $_SERVER['PHP_SELF'] ?>">Refresh</a></h5>
                    <div class="form-group">
                        <select id="table_name" name="table_name" class="form-control" onchange="setname()">
                            <option value="">Please Select</option>
                            <?php
                            $table_list = $hc->table_list();
                            $table_list_selected = isset($_POST['table_name']) ? $_POST['table_name'] : '';
                            foreach ($table_list as $table) {
                                ?>
                                <option value="<?php echo $table['table_name'] ?>" <?php echo $table_list_selected == $table['table_name'] ? 'selected="selected"' : ''; ?>><?php echo $table['table_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <HR>
                        <h5 style="margin-top: 0px">Jenis API</h5>
                        <div class="form-group">
                            <div class="row">
                                <?php $jenis_tabel = isset($_POST['jenis_tabel']) ? $_POST['jenis_tabel'] : 'reguler_table'; ?>
                                <div class="col-md-4">
                                    <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                        <label>
                                            <input type="radio" name="jenis_tabel" value="reguler_table" <?php echo $jenis_tabel == 'reguler_table' ? 'checked' : ''; ?>>
                                            Default API
                                        </label>
                                    </div>                            
                                </div>
                                <div class="col-md-4">
                                    <div class="radio" style="margin-bottom: 0px; margin-top: 0px">
                                        <label>
                                            <input type="radio" name="jenis_tabel" value="datatables" <?php echo $jenis_tabel == 'datatables' ? 'checked' : ''; ?>>
                                            Advance API
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display:none">
                            <HR>
                                <h5 style="margin-top: 0px">Export Data</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <?php $export_excel = isset($_POST['export_excel']) ? $_POST['export_excel'] : ''; ?>
                                                <label>
                                                    <input type="checkbox" name="export_excel" value="1" <?php echo $export_excel == '1' ? 'checked' : '' ?>>
                                                    Export Excel
                                                </label>
                                            </div>
                                        </div>    
                                    </div>    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <?php $export_word = isset($_POST['export_word']) ? $_POST['export_word'] : ''; ?>
                                                <label>
                                                    <input type="checkbox" name="export_word" value="1" <?php echo $export_word == '1' ? 'checked' : '' ?>>
                                                    Export Word
                                                </label>
                                            </div>
                                        </div>    
                                    </div>    
                                </div>    
                            </div>    

                            <HR>
                                <h5 style="margin-top: 0px">Controller & Model</h5>
                                <div class="form-group">
                                    <label>Ganti Nama Controller</label>
                                    <input type="text" id="controller" name="controller" value="<?php echo isset($_POST['controller']) ? $_POST['controller'] : '' ?>" class="form-control" placeholder="Nama Controller" />
                                </div>
                                <div class="form-group">
                                    <label>Ganti Nama Model</label>
                                    <input type="text" id="model" name="model" value="<?php echo isset($_POST['model']) ? $_POST['model'] : '' ?>" class="form-control" placeholder="Nama Model" />
                                </div>
                                <HR>
                                    <input type="submit" value="Generate" name="generate" class="btn btn-success pull-right" onclick="javascript: return confirm('This will overwrite the existing files. Continue ?')" />

                                    <a href="backup.php" class="btn btn-primary">Backup Database</a>

                                    <div style="display:none">
                                        <input type="submit" value="Generate All" name="generateall" class="btn btn-info" onclick="javascript: return confirm('WARNING !! This will generate code for ALL TABLE and overwrite the existing files\
                                        \nPlease double check before continue. Continue ?')" />
                                        <a href="core/setting.php" class="btn btn-default">Setting</a>
                                    </div>

                                </form>
                                <br>

                                <?php
                                foreach ($hasil as $h) {
                                    echo '<p>' . $h . '</p>';
                                }
                                ?>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function capitalize(s) {
                            return s && s[0].toUpperCase() + s.slice(1);
                        }

                        function setname() {
                            var table_name = document.getElementById('table_name').value.toLowerCase();
                            if (table_name != '') {
                                document.getElementById('controller').value = capitalize(table_name);
                                document.getElementById('model').value = capitalize(table_name) + '_model';
                            } else {
                                document.getElementById('controller').value = '';
                                document.getElementById('model').value = '';
                            }
                        }
                    </script>
                </body>
                </html>
