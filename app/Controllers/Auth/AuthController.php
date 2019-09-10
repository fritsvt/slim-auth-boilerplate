<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Auth\Auth;
use Slim\Flash\Messages;
use App\Models\User;

class AuthController extends Controller
{
    public function getRegister(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'auth/register.twig');
    }

    public function getLogin(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'auth/login.twig');
    }

    public function postRegister(Request $request, Response $response, Auth $auth)
    {
        $validation = $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:200|confirmed',
            'g-recaptcha-response'=>'required|recaptcha'
        ]);
        if ($validation->fails()) {
            return redirect()->route('register');
        }

        $user = User::create([
            'name' => input('name'),
            'username' => input('username'),
            'email' => input('email'),
            'password' => password_hash(input('password'), PASSWORD_BCRYPT),
            'user_level' => 1
        ]);

        $auth->attempt($user->email, input('password'));

        return redirect()->route('home');
    }

    public function postLogin(Request $request, Response $response, Auth $auth, Messages $flash)
    {
        $validation = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:200',
            'g-recaptcha-response'=> 'required|recaptcha'
        ]);
        if ($validation->fails()) {
            return redirect()->route('login');
        }

        $auth = $auth->attempt(
            input('email'),
            input('password')
        );
        if (!$auth) {
            $flash->addMessage('error', 'Username or password incorrect');
            return redirect()->route('login');
        }

        return redirect()->route('home');
    }

    public function logout(Request $request, $response, Auth $auth)
    {
        $auth->logout();

        return redirect()->route('home');
    }

}
