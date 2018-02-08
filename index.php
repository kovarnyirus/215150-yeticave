<?php
require_once('functions.php');
require_once ('templates/data_templates.php');

$page_content = render_template('templates/index.php', ['ads_list' => $ads_list ]);
$layout_content = render_template("templates/layout.php", [

        ]);
print ($layout_content);
