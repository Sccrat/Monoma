<?php

namespace Tests\Unit\Services;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Tests\Services\ManagementPermissionsTrait;
use Tests\TestCase;
use Tests\Unit\Seeders\UserTestSeeder;
use Tests\Unit\Traits\ApiMethodsTrait;

/**
 * Abstract Class AuthenticateTest para implementacion de metodos del logueo y
 * deslogueo en las clases Tests de CRUDS.
 *
 * Esta Clase abstracta es usada por las clases de Test que utilizarán los siguientes metodos
 * para hacer la autenticacion, abstraccion y revocación del Token.
 *
 * @author(s) Yerson Danian Morales Rivera - Juan Pablo Patiño Ramírez
 */
abstract class AuthenticateTest extends TestCase
{
    use ApiMethodsTrait;

    protected string $token;
    protected $user;

    /**
     * @method setup
     * Este metodo se ejecuta antes de cada Test especifico. Se encarga de efectuar el metodo
     * login que hace la autenticacion para poder hacer las solicitudes HTTP.
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
        $this->seed(UserTestSeeder::class);
        $this->login();
    }

    /**
     * @method tearDown
     * Este metodo se ejecuta al final cada Test especifico. Se encarga de efectuar el metodo logout para
     * garantizar la integridad de la informacion.
     * @return void
     */
    public function tearDown(): void
    {
        $this->logout();
        unset($this->token);
    }

    /**
     * @method login
     * Hace la solicitud de autenticacion para el logueo en el sistema y abstrae el token.
     * @return void
     */
    private function login(): void
    {
        $credentials = ['email' => env('UNIT_TEST_USERNAME'), 'password' => env('UNIT_TEST_PASSWORD')];
        $login = $this->post('api/login', $credentials);
        $this->token = 'Bearer ' . $login['accessToken'];
        $this->user = $login['user'];
    }

    /**
     * @method logout
     * Hace la solicitud de deslogueo para sistema y revoca el token.
     * @return void
     */
    private function logout(): void
    {
        $this->get('api/v1/logout', ['authorization' => $this->token]);
    }

    /**
     * Encargado de resivir una variable response y extraer sus valores solo
     * en caso de error por parte del controlador a testear.
     * @param object $reponse Respuesta del controlador.
     * @return string Exepcion extraida de la respuesta del controlador.
     */
    protected function getResponse(?object $response)
    {
        if (isset($response->original)) {
            $keys = array_keys(is_array($response->original) ? $response->original : []);
            foreach ($keys as $key) {
                if (!is_array($response[$key])) {
                    $exeption[] = "$key : " . $response[$key];
                }
            }
        }

        return empty($keys) ? null : implode(' ', $exeption);
    }

    /**
     * Metodo en cargado de validar la respuesta brindada y asertar las posibles variantes.
     * @param object Respuesta devuelta por la API consumida
     */
    protected function validateResponse(object $response)
    {
        $code = $response->getStatusCode();
        switch ($code) {
            case Response::HTTP_OK:
                $response->assertOk();
                break;
            case Response::HTTP_CREATED:
                $response->assertCreated();
                break;
            case Response::HTTP_NO_CONTENT:
                $response->assertStatus(Response::HTTP_NO_CONTENT);
                break;
            default:
                throw new InvalidArgumentException(" Codes expected: 200, 201, 204. Given $code");
                break;
        }
    }
}
