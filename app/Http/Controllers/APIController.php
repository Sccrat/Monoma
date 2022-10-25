<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Candidatos;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Support\Facades\Redis;

class APIController extends Controller
{
    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function Createlead(Request $request)
    {
        $candidatos = new Candidatos();
        $candidatos->name = $request->name;
        $candidatos->source = $request->source;
        $candidatos->owner = $request->owner;
        $candidatos->save();

        return response()->json([
            'success'   =>  true,
            'errors' => [],
            'data'      =>  $candidatos
        ], 200);
    }

    public function lead($id)
    {
        $candidatos = Candidatos::find($id);

        return response()->json([
            'success' =>  true,
            'errors' => [],
            'data'   =>  $candidatos
        ], 200);
    }

    public function Allleads()
    {
        $candidatos = cache('leads', function () {
            return Candidatos::all();
        });

        // $candidatos = Candidatos::all();

        return response()->json([
            'success'   =>  true,
            'errors' => [],
            'data'      =>  $candidatos
        ], 200);
    }
}
