<?php
namespace App\Controllers;

use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\UserModel;

class AuthController extends BaseController {
    protected $userModel;

    
    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function showLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->view->render($response, 'login.twig');
    }
    
    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $data = $request->getParsedBody();

        // Define validation rules
        $rules = [
            'username' => 'required|alpha_num|min:3|max:20',
            'password' => 'required|min:8'
        ];

        // Validate input
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
            return $this->view->render($response, 'login.twig', [
                'errors' => $errors,
                'data'   => $data // Pass back the input data to pre-fill the form
            ]);
        }

        // Retrieve user by username
        $user = $this->userModel->getUserByUsername($data['username']);
        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->view->render($response, 'login.twig', [
                'errors' => ['general' => ['Invalid username or password.']],
                'data'   => $data
            ]);
        }

        // On successful login, store user info in session
        $_SESSION['user'] = [
            'id'       => $user['id'],
            'username' => $user['username'],
            'email'    => $user['email'],
            'is_admin'    => (bool) $user['is_admin']
        ];

        $is_admin = $_SESSION['user']['is_admin'];

        $this->flash->addMessage('success', 'Login successful!');
        // Redirect to home or profile
        return $response->withHeader('Location', $is_admin ? '/admin' : '/admin')->withStatus(302);
    }
    
    public function showRegister(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->view->render($response, 'register.twig');
    }
    
    public function register(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $data = $request->getParsedBody();

        // Define validation rules
        $rules = [
            'username'         => 'required|alpha_num|min:3|max:20',
            'email'            => 'required|email',
            'password'         => 'required|min:8',
            'password_confirm' => 'required'
        ];

        // Validate input
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
            return $this->view->render($response, 'register.twig', [
              'errors' => $errors,
              'data'   => $data // Pass back the input data to pre-fill the form
            ]);
        }

        // Check if passwords match
        if ($data['password'] !== $data['password_confirm']) {
            return $this->view->render($response, 'register.twig', [
              'errors' => ['password_confirm' => ['Passwords do not match.']],
              'data'   => $data // Pass back the input data to pre-fill the form
            ]);
        }

        // Check if user already exists
        if ($this->userModel->getUserByUsername($data['username'])) {
            return $this->view->render($response, 'register.twig', [
              'errors' => ['username' => ['Username already taken.']],
              'data'   => $data // Pass back the input data to pre-fill the form
            ]);
        }

        // Hash the password and register user
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $userId = $this->userModel->registerUser($data['username'], $data['email'], $hashedPassword);
        if (!$userId) {
            return $this->view->render($response, 'register.twig', [
              'errors' => ['general' => ['Registration failed. Please try again.']],
              'data'   => $data // Pass back the input data to pre-fill the form
            ]);
        }

        // Optionally log in the new user immediately
        $_SESSION['user'] = [
            'id'       => $userId,
            'username' => $data['username'],
            'email'    => $data['email']
        ];

        // Redirect to home or profile
        return $response->withHeader('Location', '/')->withStatus(302);
    }
    
    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Destroy user session here
        session_destroy();
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
