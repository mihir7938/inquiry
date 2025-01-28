<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\AuthenticateService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authService, $userService;

    public function __construct(AuthenticateService $authService, UserService $userService) {
        $this->authService = $authService;
        $this->userService = $userService;
    }
    public function getLogin(Request $request)
    {
        if (!Auth::check()) {
            $users = $this->userService->getAllUsers();
            return view('auth.login')->with('users', $users);
        }
        $url = url('/office');
        return redirect($url);
    }

    /**
     * Loigin user.
     *
     * @param  LoginRequest
     *
     * @return redirect
     */
    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userService->getUserById($request->name);
            $input = [
                'email' => $user->email,
                'password' => $request->password,
                'status' => true
            ];
            $is_auth = Auth::attempt($input, $request->has('remember_me') ? true : false);
            if ($is_auth) {
                if ($request->ajax()) {
                    return response()->json(['status' => true]);
                } else {
                    $url = url('/office');
                    return redirect($url);
                }
            } else {
                throw new \Exception('Invalid name or password, please try again.');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $e->getMessage()]);
            } else {
                $request->session()->put('message', $e->getMessage());
                $request->session()->put('alert-type', 'alert-danger');
                return redirect('/auth/login');
            }
        }
    }

    public function logout(Request $request)
    {
        $user = User::find(Auth::user()->id);
        Auth::logout();
        $request->session()->flush();
        $request->session()->put('message', 'Logged out successfully!');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('login');
    }

    public function forgetPassword(Request $request)
    {
        return view('auth.forget-password');
    }

    /**
     * Loads forgot password view.
     *
     * @param  NULL
     *
     * @return redirect to forgot password view
     */
    public function resetPassword(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->email;
            $this->authService->sendResetPasswordEmail($email);
            $request->session()->put('message', 'A link to reset your password has been sent to your email.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('forget_password');
        } catch (\Exception $e) {
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-danger');

            return redirect()->route('forget_password');
        }
    }

    /**
     * Page for resetting password.
     *
     * @param type $token
     *
     * @return type view
     */
    public function getChangePassword(Request $request, $token)
    {
        $user = $this->authService->getUserByToken($token);
        if ($user) {
            return view('auth.new-password', ['user' => $user]);
        } else {
            $request->session()->put('message', 'Incorrect password reset link. Please try again.');
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('forget_password');
        }
    }

    /**
     * Process change password.
     *
     * @param type $token
     */
    public function postChangePassword(ResetPasswordRequest $request, $token)
    {
        $user = $this->authService->getUserByToken($token);
        if ($user) {
            $user->remember_token = '';
            $this->authService->changeUserPassword($user, $request->password);
            $request->session()->put('message', 'You have successfully changed your password. Please log in with new password.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('login');
        } else {
            $request->session()->put('message', 'Incorrect password reset link. Please try again.');
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('forget_password');
        }
    }
}
