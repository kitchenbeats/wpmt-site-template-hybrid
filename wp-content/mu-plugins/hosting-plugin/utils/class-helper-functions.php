<?php

namespace MHSP\Utils;

class Helper_Functions {

    public static function get_option($option_name, $default = '') {
        return get_option($option_name, $default);
    }

    public static function update_option($option_name, $value) {
        return update_option($option_name, $value);
    }

    // Add more helper functions as needed
}

