<?php

namespace MHSP\Utils;

class API {

    public static function make_request($endpoint, $method = 'GET', $body = null) {
        $url = MHSP_API_URL . $endpoint;
        $args = array(
            'method'  => $method,
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . WPMT_API_KEY,
                'X-Site-ID' => WPMT_SITE_ID,
                'X-Waas-ID' => WPMT_WAAS_ID,
            ),
        );

        if ($body) {
            $args['body'] = wp_json_encode($body);
        }

        $response = wp_remote_request($url, $args);
        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'message' => $response->get_error_message()
            );
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        if ($response_code >= 200 && $response_code < 300) {
            return array(
                'success' => true,
                'message' => isset($response_data['message']) ? $response_data['message'] : 'Request succeeded',
                'data' => $response_data
            );
        } else {
            return array(
                'success' => false,
                'message' => isset($response_data['message']) ? $response_data['message'] : 'Unknown error'
            );
        }
    }
}

