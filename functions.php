<?php
function render_template ($address_template, $array_data) {
    if (!file_exists($address_template)){
      return  print ('');
    };
    extract($array_data);
    ob_start();
    require_once ($address_template);

    return ob_get_clean();

}
