<?php

namespace App\Controllers\Auth;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Flash\Messages as Flash;
use App\Validation\Contracts\ValidatorInterface;
use Respect\Validation\Validator as v;
use App\Validation\Forms\RegisterForm;
use App\Validation\Forms\LoginForm;
use App\Auth\Auth;
use Slim\Flash\Messages;
use Slim\Router;
use App\Models\User;
use App\Helpers\Config;

class AuthController
{
    public function getRegister(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'auth/register.twig');
    }

    public function getLogin(Request $request, Response $response, Twig $view)
    {
        return $view->render($response, 'auth/login.twig');
    }

    public function postRegister(Request $request, Response $response, ValidatorInterface $validator, Auth $auth, Router $router)
    {
        $validation = $validator->validate($request, RegisterForm::rules($auth, $request->getParam('password'), $request->getParam('password_verify')));
        if ($validation->fails()) {
            return $response->withRedirect($router->pathFor('register'));
        }

        $user = User::create([
            'name' => $request->getParam('name'),
            'username' => $request->getParam('username'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT),
            'user_level' => 1
        ]);

        $auth->attempt($user->email, $request->getParam('password'));

        return $response->withRedirect($router->pathFor('login'));

    }

    public function postLogin(Request $request, Response $response, Twig $view, Auth $auth, ValidatorInterface $validator, Router $router, Messages $flash, User $user, Config $config)
    {
        $validation = $validator->validate($request, LoginForm::rules());
        if ($validation->fails()) {
            return $response->withRedirect($router->pathFor('login'));
        }

        $auth = $auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );
        if (!$auth) {
            $flash->addMessage('error', 'Username or password incorrect');
            return $response->withRedirect($router->pathFor('login'));
        }

        return $response->withRedirect($router->pathFor('home'));
    }

    public function logout(Request $request, $response, Auth $auth, Router $router)
    {
        $auth->logout();

        return $response->withRedirect($router->pathFor('home'));
    }

}
