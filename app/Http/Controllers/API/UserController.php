<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
* @OA\Info(title="API Usuarios", version="1.0")
*
* @OA\Server(url="http://nexoabogados.test/")
*
* @OA\PathItem(path="/api/users")
*/

class UserController extends Controller
{

   /**
    * @param Request $request
    * @return Response
    *
    * @OA\Get(
    *     path="/api/users",
    *     summary="Mostrar usuarios",
    *     description="Mostrar todos los usuarios",
    *     operationId="index",
    *     tags={"users"},
    *     @OA\Parameter(
    *       name="page",
    *         in="query",
    *         description="pagina a mostrar por defecto es 1",
    *         required=false,
    *         @OA\Schema(
    *             type="integer",
    *             format="int32"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="limit",
    *         in="query",
    *         description="resultados por pagina por defecto 20",
    *         required=false,
    *         @OA\Schema(
    *             type="integer",
    *             format="int32"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar todos los usuarios."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function index(Request $request)
    {

        $limit = $request->limit ? $request->limit : 20;
        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $skip = ($page - 1) * $limit;

        $users = User::skip($skip)->take($limit)->get();
         //   $users = User::all();
            return response()->json(['success' => true, 'data' => $users], 200);
    }


    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear usuario",
     *     description="Crear un usuario",
     *     operationId="store",
     *     tags={"users"},
     *     @OA\RequestBody(
     *         description="Crear un usuario",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Juan"),
     *             @OA\Property(property="email", type="string", example="nico@gmail.com"),
     *             @OA\Property(property="password", type="string", example=123456),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *       description="Crear un usuario."
     *   ),
     *  @OA\Response(
     *       response="default",
     *      description="Ha ocurrido un error."
     *  )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $users = User::create($input);
        return response()->json(['success' => true, 'data' => $users], 200);
    }


    /**
    * @param Request $request
    * @param $id
    * @return Response
    *
    * @OA\Get(
    *     path="/api/users/{id}",
    *     summary="Mostrar usuario",
    *     description="Mostrar un usuario",
    *     operationId="show",
    *     tags={"users"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del usuario a mostrar",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar un usuario."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function show($id)
    {
        /** @var Users $users */
        $users = User::find($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
        }

        return response()->json(['success' => true, 'data' => $users], 200);
    }


    /**
    * @param Request $request
    * @param $id
    * @return Response
    *
    * @OA\Put(
    *     path="/api/users/{id}",
    *     summary="Actualizar usuario",
    *     description="Actualizar un usuario",
    *     operationId="update",
    *     tags={"users"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del usuario a actualizar",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
    *         )
    *     ),
    *     @OA\RequestBody(
    *         description="Actualizar un usuario",
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Property(property="name", type="string", example="Juan"),
    *             @OA\Property(property="email", type="string", example="nicotestagrossa@gmail.com"),
    *             @OA\Property(property="password", type="string", example=123456),
    *        ),
    *    ),
    *    @OA\Response(
    *        response=200,
    *       description="Actualizar un usuario."
    *   ),
    *  @OA\Response(
    *       response="default",
    *      description="Ha ocurrido un error."
    *  )
    * )
    */

    public function update(Request $request, $id)
    {
        $input = $request->all();

        /** @var Users $users */
        $users = User::find($id);
        if (empty($users)) {
            return $this->sendError('Users not found');
        }
        $users = User::update($input, $id);
        return response()->json(['success' => true, 'data' => $users], 200);
    }


    /**
    * @param Request $request
    * @param $id
    * @return Response
    *
    * @OA\Delete(
    *     path="/api/users/{id}",
    *     summary="Eliminar usuario",
    *     description="Eliminar un usuario",
    *     operationId="destroy",
    *     tags={"users"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del usuario a eliminar",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Eliminar un usuario."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */

   public function destroy($id)
   {
       /** @var Users $users */
       $users = User::find($id);

       if (empty($users)) {
           return $this->sendError('Users not found');
       }

       $users->delete();

         return response()->json(['success' => true, 'data' => ''], 200);

   }

}
