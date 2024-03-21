<?php

namespace App\Http\Controllers\API;

use App\Helper\Helpers;
use App\Http\Controllers\AppBaseController;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\UnauthorizedException;
use phpDocumentor\Reflection\Types\Object_;

use function Symfony\Component\VarDumper\Dumper\esc;

class AuthController extends AppBaseController
{

    public function login(Request $request)
    {
        $credentials = request(['phone', 'password', 'active' => 1]);
        if (!Auth::attempt($credentials)) {
            return $this->sendError('Invalid username or password');
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        $user->userPermission;
        $user->permissionGroup;
        $user->roles;
        $user->branches;

        $result =
            [
                'access_token' => $tokenResult->accessToken,
                'user'         => $user,
                'token_type'   => 'Bearer',
            ];
        return $this->sendResponse($result, 'Login successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ], 200);
    }

}
