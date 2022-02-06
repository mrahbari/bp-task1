<?php
/**
 * helper\app.php
 *
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mike.
 * @version 1.0.0
 * @date 2022/02/04 18:15 PM
 */

use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('get_api_versions')) {

    /**
     * return valid api versions
     * @param bool $implode
     * @return string|string[]
     */
    function get_api_versions(bool $implode = true)
    {
        $permitted_versions = [api_version()]; //['v1', 'v2']
        return ($implode === true) ? implode('|', $permitted_versions) : $permitted_versions;
    }
}

if (!function_exists('api_version')) {

    /**
     * return valid api versions
     *
     */
    function api_version(): string
    {
        return 'v1';
    }
}

if (!function_exists('hashids_encode')) {
    /**
     * Encode the given id.
     *
     * @param $idOrArray
     * @return string
     */
    function hashids_encode($idOrArray): string
    {
        return Hashids::encode($idOrArray);
    }
}

if (!function_exists('hashids_decode')) {
    /**
     * Decode the given value.
     *
     * @param $value
     * @param bool $strict
     * @return array|\Hashids\Hashids|mixed|null
     */
    function hashids_decode($value, bool $strict = false)
    {
        if (empty($value)) {
            return null;
        }

        if (is_array($value)) {
            $decode_ids = [];
            foreach ($value as $id) {
                $decode_ids[] = ((strlen($id) === 11) || ($strict === true)) ? Hashids::decode($id) : $id;
            }
            $return = $decode_ids;
        } else {
            $return = ((strlen($value) === 11) || ($strict === true)) ? Hashids::decode($value) : $value;
        }

        if (!isset($return)) {
            return null;
        }

        if (is_array($return) && count($return) === 1) {
            return $return[0];
        }

        return $return;
    }
}

if (!function_exists('trans_boolean')) {

    /**
     * return   0->No, 1->Yes value
     * @param int $value
     * @return mixed
     */
    function trans_boolean(int $value = 0): string
    {
        $trans_boolean = trans('modules.boolean.false');
        if ($value === 1) {
            $trans_boolean = trans('modules.boolean.true');
        }

        return $trans_boolean;
    }
}

if (!function_exists('is_api_guard')) {
    /**
     * Check weather guard is api
     *
     * @return bool
     */
    function is_api_guard(): bool
    {
        //handle api guards
        return request()->segment(1) === 'api' || request()->segment(2) === 'api';
    }
}
