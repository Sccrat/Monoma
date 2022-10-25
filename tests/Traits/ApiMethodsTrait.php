<?php

namespace Tests\Unit\Traits;

/**
 * Trait ApiMethodsTrait para implementacion de metodos de API en las clases Tests de CRUDS.
 * Este Trait es usado por las clases de Test, que utilizarán los methodos
 * para hacer solicitudes Http a la API.
 *
 * @author(s) Juan Pablo Patiño - Yerson Danian Morales Rivera
 */
trait ApiMethodsTrait
{
    protected $apiVersion = 'api/';

    /**
     * @method doPost
     * @param string $url
     * @param array $data
     * @return mixed Respuesta de la solicitud a la API
     */
    public function doPost(string $url, array $data, array $request = [])
    {
        $headers = ['authorization' => $this->token];
        $data = array_merge($data, $request);
        $response = $this->post($this->apiVersion . $url, $data, $headers);

        return $response;
    }

    /**
     * @method doGet
     * @param string $url
     * @param array $data Data for request
     * @return mixed Respuesta de la solicitud a la API
     */
    public function doGet(string $url, array $request = [])
    {
        $headers = ['authorization' => $this->token];
        $response = $this->get($this->apiVersion . $url . '?' . http_build_query($request), $headers);

        return $response;
    }

    /**
     * @method doPut
     * @param string $url
     * @param array $data
     * @param int $id
     * @return mixed Respuesta de la solicitud a la API
     */
    public function doPut(string $url, int $id, array $data, array $request = [])
    {
        $headers = ['authorization' => $this->token];
        $data = array_merge($data, $request);
        $response = $this->put($this->apiVersion . $url . $id, $data, $headers);

        return $response;
    }

    /**
     * @method doDelete
     * @param string $url
     * @param mixed $id
     * @return mixed Respuesta de la solicitud a la API
     */
    public function doDelete(string $url, ?int $id = null, array $data = [])
    {
        $headers = ['authorization' => $this->token];
        $response = $this->delete($this->apiVersion . $url . $id, $data, $headers);

        return $response;
    }

    /**
     * @method doFind
     * @param string $url
     * @param mixed $id
     * @return mixed Respuesta de la solicitud a la API
     */
    public function doFind(string $url, int $id)
    {
        $headers = ['authorization' => $this->token];
        $response = $this->get($this->apiVersion . $url . $id, $headers);

        return $response;
    }
}
