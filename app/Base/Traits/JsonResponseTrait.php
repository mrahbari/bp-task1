<?php
/**
 * @author Mojtaba Rahbari <mojtaba.rahbari@gmail.com | mojtabarahbari.ir>
 * @copyright Copyright &copy; from 2022 Mojtaba.
 * @version 1.0.0
 * @date 2022/02/06 15:00 PM
 *
 * ------------------------------------------
 * Json Response Trait
 * ------------------------------------------
 *
 * This trait makes it easier to return the JSON response from controllers
 * accompanied with proper status code
 */

namespace App\Base\Traits;

use App\Base\Http\Resources\BaseApiCollection;
use App\Base\Http\Resources\BaseApiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

trait JsonResponseTrait
{

    public array $successMeta = ['success' => true, 'status' => 'success'];
    public array $failedMeta = ['success' => false, 'status' => 'error'];
    public string $key = 'data';

    /**
     * The request has succeeded.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns

     * @return JsonResponse
     */
    protected function apiOk($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = @array_merge(['message' => trans('modules.message.succeed')], $this->successMeta);
        return $this->_partialResponse(200, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request has been fulfilled and resulted in a new resource being created.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiCreated($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = @array_merge(['message' => trans('modules.message.created')], $this->successMeta);
        return $this->_partialResponse(201, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request has been accepted for processing, but the processing has not been completed.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiUpdated($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;//@array_merge(['message' => trans('modules.message.updated')], $this->successMeta);
        $data = @array_merge(['message' => trans('modules.message.updated')], $this->successMeta);
        return $this->_partialResponse(202, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request has been accepted for processing, but the processing has not been completed.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiAccepted($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.accepted')], $this->successMeta);
        return $this->_partialResponse(202, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request has been accepted for processing, but the processing has not been completed.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiDeleted($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.deleted')], $this->successMeta);
        return $this->_partialResponse(202, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request has been accepted for processing, but the processing has not been completed.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiChanged($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.changed')], $this->successMeta);
        return $this->_partialResponse(202, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request has been accepted for processing, but the processing has not been completed.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiRestored($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.restored')], $this->successMeta);
        return $this->_partialResponse(202, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request successfully deleted the resource
     *
     * @return JsonResponse
     */
    protected function apiNoContent(): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.no_data')], $this->successMeta);
        return $this->_partialResponse(204, $data, $meta);
    }

    /**
     * The server understands the content type of the request entity,
     * and the syntax of the request entity is correct,
     * but was unable to process the contained instructions.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiFailed($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = @array_merge(['message' => trans('modules.message.failed')], $this->failedMeta);
        return $this->_partialResponse(422, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request could not be understood by the server due to malformed syntax.
     * The client SHOULD NOT repeat the request without modifications.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiBadRequest($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.bad_request')], $this->failedMeta);
        return $this->_partialResponse(400, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The request requires user authentication.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns
     * @return JsonResponse
     */
    protected function apiUnauthorized($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.unauthorized')], $this->failedMeta);
        return $this->_partialResponse(401, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The server understood the request, but is refusing to fulfill it.
     * Authorization will not help and the request SHOULD NOT be repeated.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns

     * @return JsonResponse
     */
    protected function apiForbidden($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.forbidden')], $this->failedMeta);
        return $this->_partialResponse(403, $data, $extra, $meta, $apiColumns);
    }

    /**
     * The server has not found anything matching the Request-URI.
     * No indication is given of whether the condition is temporary or permanent.
     *
     * @param null $data
     * @param array|null $extra
     * @param array|null $apiColumns

     * @return JsonResponse
     */
    protected function apiNotFound($data = null, ?array $extra = [], ?array $apiColumns = []): JsonResponse
    {
        $meta = null;
        $data = @array_merge(['message' => trans('modules.message.not_found')], $this->failedMeta);
        return $this->_partialResponse(404, $data, $extra, $meta, $apiColumns);
    }

    /**
     * @param $data
     * @param $statusCode
     * @param array|null $apiColumns

     * @return JsonResponse
     */
    protected function apiException($data, $statusCode, ?array $apiColumns = []): JsonResponse
    {
        return $this->_partialResponse($statusCode, $data, null, null, $apiColumns);
    }

    /**
     * @param $data
     * @param array $apiColumns
     * @return array|mixed
     */
    protected function toResource($data, array $apiColumns = [])
    {
        $apiColumns = !empty($apiColumns) ? $apiColumns : null;
        return !empty($data) && !is_array($data) ? (new BaseApiResource($data))->columns($apiColumns)->resolve() : $data;
    }

    /**
     * @param $data
     * @param array $apiColumns
     * @return array
     */
    protected function toResourceCollection($data, array $apiColumns = []): array
    {
        if (empty($data))
            return [];

        [$meta, $links] = $this->_makeCollectionParams($data);
        $apiColumns = !empty($apiColumns) ? $apiColumns : null;
        $data = ((new BaseApiCollection($data))->columns($apiColumns))->resolve();

        if (!empty($meta) && !empty($links))
            return ['data' => $data, 'meta' => $meta, 'links' => $links];

        return $data;
    }

    /**
     * The request has been accepted for processing, but the processing has not been completed.
     *
     * @param int $responseStatus
     * @param null $data
     * @param array|null $extra
     * @param array|null $meta
     * @param array|null $apiColumns

     * @return JsonResponse
     */
    private function _partialResponse(int $responseStatus = 202, $data = null, ?array $extra = [], ?array $meta = [], ?array $apiColumns = []): JsonResponse
    {
        $this->apiColumns = $apiColumns;

        //Convert messageBags to string just for API guard
        $message = '';
        if (is_api_guard() && !empty($extra['message']) && $extra['message'] instanceof MessageBag) {
            $messages = $extra['message']->toArray();
            foreach ($messages as $key => $value)
                $message .= @array_shift($value) . '||';

            //$extra['message'] = !empty($message) ? $message : $extra['message'];
            $extra['success'] = false;
            $extra['status'] = 'error';
            $data['error'] = !empty($message) ? $message : $extra['message'];
            $data['code'] = 'VALIDATION_EXCEPTION';
        }

        //Added for response Integration
        if (empty($data) && empty($extra)) {
            $result = null;
        } elseif (!empty($data['links']) && !empty($data['meta'])) {   //is collection
            $meta = $data['meta'];
            $links = $data['links'];
            $data = $data['data'] ?? [];
            $result = $extra !== null ? compact('data', 'meta', 'links', 'extra') : compact('data', 'meta', 'links');
        } elseif (!empty($data['data'])) {   //is collection
            $result = compact('data');
        } else {
            $result = $extra !== null ? compact('data', 'extra') : compact('data');
        }

        return response()->json($result, $responseStatus);
    }

    /**
     * @param null $data
     * @return array
     *
     * Note: As i wanted to keep JsonResponse As response of main method, i tricked with below scenario
     */
    private function _makeCollectionParams($data = null): array
    {
        $meta = $links = [];
        if ($data !== null) {
            $dataArray = $data->toArray();
            if (isset($dataArray['data'])) {
                unset($dataArray['data']);
            }
            //dump($dataArray);
            if (isset($dataArray['links']) && is_array($dataArray['links'])) {
                $links = $dataArray['links'];
                unset($dataArray['links']);
                $meta = is_array($dataArray) ? $dataArray : null;
            }
        }
        return [$meta, $links];
    }
}
