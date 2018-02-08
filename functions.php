<?php
function render_template ($address_template, $array_data) {
    if (!file_exists($address_template)){
        return  print ('');
    };
    extract($array_data);
    ob_start();
    require_once ($address_template);

    return ob_get_clean();

};

function format_price($price) {
    $ceil_num = ceil($price);
    if ($ceil_num > 1000) {
        $ceil_num = number_format($ceil_num, 0, '', ' ');
    }

    return $ceil_num . '  &#8381';
};
