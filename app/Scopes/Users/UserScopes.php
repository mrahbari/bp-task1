<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 */

namespace App\Scopes\Users;

use Illuminate\Database\Eloquent\Builder;

trait UserScopes
{
    /**
     * Scope a query to only include filters.
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     *
     * select * from `tbl_users` where `active` = true and exists
        (select * from `tbl_user_details` where `tbl_users`.`id` = `tbl_user_details`.`user_id` and exists
        (select * from `tbl_countries` where `tbl_user_details`.`citizenship_country_id` = `tbl_countries`.`id` and `iso2` = 'AT')) order by `id` desc
     */
    public function scopeSearch(Builder $query, array $params = []): Builder
    {
        $params = array_merge(request()->all(), $params);
        $id = !empty($params['id']) ? hashids_decode($params['id']) : null;
        $active = isset($params['active']) ? (bool)$params['active'] : null;
        $countryIso2 = !empty($params['country_iso2']) ? $params['country_iso2'] : null;
        $orderColumn = !empty($params['sort']) ? $params['sort'] : null;
        $orderDirection = !empty($params['direction']) ? $params['direction'] : 'desc';

        if ($id !== null) {
            $query->where('id', '=', $id);
        }

        if ($active !== null) {
            $query->where('active', '=', $active);
        }

        if ($countryIso2 !== null) {
            $query->whereHas('details.country', function (Builder $q) use ($countryIso2) {
                $q->where('iso2', $countryIso2);
            });
        }

        if ($orderColumn !== null) {
            $query->orderBy($orderColumn, $orderDirection);
        }

        return $query;
    }

    /**
     * Scope a query to order posts by latest rows
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }
}
