<?php

namespace App\Http\Middleware;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\User;

class CustomerMiddleware
{
    /**
     * Store the user data
     * @var
     */
    protected $user_data;

    /**
     * Validate request
     * @param Request $request
     */
    protected function validate(Request $request)
    {

        $authorizationToken = $request->header('Authorization');


        // If the token is wrongly formatted
        if (stripos($authorizationToken, ' ') === false || stripos($authorizationToken, 'Bearer') === false) {
           return  response()->json(
                [
                    'status_code' => 401,
                    'message' => 'Authorization failed, Token not sent properly.'
                ],
                401
            );
            
        }

        $token = explode(' ', $authorizationToken)[1];

        // If no token was specified
        if (!$token) {
            return response()->json(['status_code' => 401, 'message' => 'Authorization failed, token not sent.'], 401);
            
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
           return response()->json(['status_code' => 403, 'message' => 'Provided token is expired.'], 403);
           
        } catch (\Exception $e) {
            return response()->json(['status_code' => 403, 'message' => 'Invalid token sent.'], 403);
           
        }

        // Fetch the User data
        $this->user_data = $this->getUserData($credentials->sub);

        // If the user data is invalid
        if (!$this->user_data) {
          return  response()->json(['status_code' => 403, 'message' => 'Provided token is invalid.'], 403);
        }

        return true;
    }

    /**
     * Set the User data
     * @param $id
     * @return mixed
     */
    protected function getUserData($id)
    {
        $user = true;
        return User::find($id);
    }

    /**
     * Check if the User is Authorized to perform the $next action
     * @param $request
     * @param \Closure $next
     * @param null $guard
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        // Check Permissions
       $response =   $this->validate($request);
       
       if($response !== true){
           return $response;
       }

        $request->auth = $this->user_data;
    
        return $next($request);
    }
}
