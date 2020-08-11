<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

abstract class AbstractApiController extends Controller
{
    /**
     * The HTTP response headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * The HTTP response meta data.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * The HTTP response data.
     *
     * @var mixed
     */
    protected $data = null;

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @param array $headers
     *
     * @return $this
     */
    protected function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array $meta
     *
     * @return $this
     */
    protected function setMetaData(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    protected function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param int $statusCode
     *
     * @return $this
     */
    protected function setStatusCode($statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param mixed $item
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function item($item): JsonResponse
    {
        return $this->setData($item)->respond();
    }

    /**
     * @param \Illuminate\Support\Collection $collection
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function collection($collection): JsonResponse
    {
        return $this->setData($collection)->respond();
    }

    /**
     * @param \Illuminate\Contracts\Pagination\Paginator $paginator
     * @param \Illuminate\Http\Request                   $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function paginator(Paginator $paginator, Request $request): JsonResponse
    {
        foreach ($request->query as $key => $value) {
            if ($key != 'page') {
                $paginator->addQuery($key, $value);
            }
        }

        $pagination = [
            'pagination' => [
                'total'        => $paginator->total(),
                'count'        => count($paginator->items()),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages'  => $paginator->lastPage(),
                'links'        => [
                    'next_page'     => $paginator->nextPageUrl(),
                    'previous_page' => $paginator->previousPageUrl(),
                ],
            ],
        ];

        return $this->setMetaData($pagination)->setData($paginator->getCollection())->respond();
    }

    /**
     * Respond with a no content response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function noContent(): JsonResponse
    {
        return $this->setStatusCode(204)->respond();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond(): JsonResponse
    {
        $response = [];
        if (!empty($this->meta)) {
            $response['meta'] = $this->meta;
        }

        $response['data'] = $this->data;

        if ($this->data instanceof Arrayable) {
            $response['data'] = $this->data->toArray();
        }

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $this->setHeaders(array_merge($headers, $this->headers));

        return Response::json($response, $this->statusCode, $this->headers);
    }
}
