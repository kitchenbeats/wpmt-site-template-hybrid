<?php

namespace MHSP\Security;

class Data_Validation {

    public function sanitize_text($text) {
        return sanitize_text_field($text);
    }

    public function sanitize_url($url) {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    // Add more validation methods as needed
}

