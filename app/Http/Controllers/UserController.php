<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private userService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function login(): Response
    {
        return response()
            ->view("user.login", [
                "title" => "Login"
        ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $username = $request->input("user");
        $password = $request->input("password");

        if(empty($username) || empty($password)){
            return response()
                ->view("user.login", [
                    "title" => "Login",
                    "error" => "Username and password must be filled"
                ]);
        }

        if ($this->userService->login($username, $password)) {
            $request->session()->put("user", $username);
            return redirect('/');
        }

        return response()
            ->view("user.login", [
                "title" => "Login",
                "error" => "Username or password is incorrect"
            ]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect('/login');
    }
}
