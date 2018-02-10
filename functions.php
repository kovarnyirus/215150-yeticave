<?php
function render_template ($name_template, $array_data) {
    $PATH = 'templates/';
    $EXTENSION ='.php';
    $address_template = $PATH . $name_template . $EXTENSION;
    if (!file_exists($address_template)){
        return '';
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

function time_tomorrow(){
    $ts = time();
    $ts_midnight = strtotime('tomorrow');
    $secs_to_midnight = $ts_midnight - $ts;
    $hours = floor($secs_to_midnight / 3600);
    $minutes = floor(($secs_to_midnight % 3600) / 60);
    return "$hours : $minutes";
}
