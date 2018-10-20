<?php
/**
 * Created by PhpStorm.
 * User: diaa
 * Date: 19/10/18
 * Time: 09:37 ص
 */
//use JWTAuth;
//use Tymon\JWTAuth\Exceptions\JWTException;

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException ;


class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_user_name_or_password'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'failed_to_create_token'], 500);
        }

        return response()->json(compact('token'));
    }



    public function getAuthUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_missing'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }




    public function register(Request $request)
    {
        // simple validator here
        // we do not make requst here for simple validate
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:3|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        // assign role to user
        $role=Role::where('name' , 'sales-agent')->first();
        if($role->id)
        {

            $user->roles()->attach($role->id);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'),201);
    }


}
