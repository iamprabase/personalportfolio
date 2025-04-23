<?php
namespace App\Controllers;

use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\UserModel;
use Slim\Csrf\Guard;

class AuthController extends BaseController
{
  protected $userModel;


  public function __construct(Guard $csrf)
  {
    parent::__construct($csrf);

    $this->userModel = new UserModel();
  }

  public function showLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $this->addCsrfToView($request);

    return $this->view->render($response, 'frontend/index.twig');
  }

  public function showAdminLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $this->addCsrfToView($request);

    return $this->view->render($response, 'auth/backend_login.twig');
  }

  public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
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

      $this->addCsrfToView($request);
      return $this->view->render($response, 'frontend/index.twig', [
        'errors' => $errors,
        'data' => $data // Pass back the input data to pre-fill the form
      ]);
    }

    // Retrieve user by username
    $user = $this->userModel->getUserByUsername($data['username']);
    if (!$user || !password_verify($data['password'], $user['password'])) {

      $this->addCsrfToView($request);
      return $this->view->render($response, 'frontend/index.twig', [
        'errors' => ['general' => ['Invalid username or password.']],
        'data' => $data
      ]);
    }

    // On successful login, store user info in session
    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username'],
      'email' => $user['email'],
      'is_admin' => (bool) $user['is_admin']
    ];

    $is_admin = $_SESSION['user']['is_admin'];

    $this->flash->addMessage('success', 'Login successful!');
    // Redirect to home or profile
    return $response->withHeader('Location', $is_admin ? '/admin' : '/admin')->withStatus(302);
  }

  public function adminLogin(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
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

      $this->addCsrfToView($request);

      return $this->view->render($response, 'auth/backend_login.twig', [
        'errors' => $errors,
        'data' => $data // Pass back the input data to pre-fill the form
      ]);
    }

    // Retrieve user by username
    $user = $this->userModel->getUserByUsername($data['username']);
    if (!$user || !password_verify($data['password'], $user['password'])) {

      $this->addCsrfToView($request);

      return $this->view->render($response, 'auth/backend_login.twig', [
        'errors' => ['general' => ['Invalid username or password.']],
        'data' => $data
      ]);
    }

    // On successful login, store user info in session
    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username'],
      'email' => $user['email'],
      'is_admin' => (bool) $user['is_admin']
    ];

    $is_admin = $_SESSION['user']['is_admin'];

    $this->flash->addMessage('success', 'Login successful!');

    // Redirect to home or profile
    return $response->withHeader('Location', $is_admin ? '/admin' : '/')->withStatus(302);
  }

  public function showRegister(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {

    $this->addCsrfToView($request);

    return $this->view->render($response, 'auth/register.twig');
  }

  public function showAdminRegister(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {

    $this->addCsrfToView($request);

    return $this->view->render($response, 'auth/register.twig');
  }

  public function register(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $data = $request->getParsedBody();
    $uploadedFiles = $request->getUploadedFiles();

    // Add the uploaded file to the data array for validation
    $data['profile_picture'] = $uploadedFiles['profile_picture'] ?? null;

    // Define validation rules
    $rules = [
      'username' => 'required|alpha_num|min:3|max:20',
      'email' => 'required|email',
      'password' => 'required|min:8',
      'password_confirm' => 'required|same:password',
      'full_name' => 'required|min:3|max:50',
      'city' => 'alpha_num|max:50',
      'country' => 'alpha_num|max:50',
    ];

    // Add profile picture validation rules only if a file is uploaded
    if ($data['profile_picture'] && $data['profile_picture']->getError() === UPLOAD_ERR_OK) {
      $rules['profile_picture'] = 'file|mimes:jpeg,jpg,png|max:2048';
    }

    // Validate input
    $validator = new Validator();
    if (!$validator->validate($data, $rules)) {
      $errors = $validator->getErrors();
      $this->addCsrfToView($request);

      return $this->view->render($response, 'auth/register.twig', [
        'errors' => $errors,
        'data' => $data // Pass back the input data to pre-fill the form
      ]);
    }

    // Handle profile picture upload
    $profilePicture = $data['profile_picture'];
    $profilePicturePath = null;
    if ($profilePicture && $profilePicture->getError() === UPLOAD_ERR_OK) {
      $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }
      $filename = uniqid() . '-' . $profilePicture->getClientFilename();
      $profilePicture->moveTo($uploadDir . $filename);
      $profilePicturePath = '/uploads/profile_pictures/' . $filename;
    }

    // Check if user already exists
    if ($this->userModel->getUserByUsername($data['username'])) {
      $this->addCsrfToView($request);
      return $this->view->render($response, 'auth/register.twig', [
        'errors' => ['username' => ['Username already taken.']],
        'data' => $data // Pass back the input data to pre-fill the form
      ]);
    }

    // Hash the password and register user
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    $userId = $this->userModel->registerUser($data['username'], $data['email'], $data['full_name'], $hashedPassword, $profilePicturePath, $data['city'], $data['country']);
    if (!$userId) {
      $this->addCsrfToView($request);
      return $this->view->render($response, 'auth/register.twig', [
        'errors' => ['general' => ['Registration failed. Please try again.']],
        'data' => $data // Pass back the input data to pre-fill the form
      ]);
    }

    // Optionally log in the new user immediately
    $_SESSION['user'] = [
      'id' => $userId,
      'username' => $data['username'],
      'email' => $data['email'],
      'profile_picture' => $profilePicturePath,
      'is_admin' => false
    ];

    // Redirect to home or profile
    return $response->withHeader('Location', '/')->withStatus(302);
  }

  public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $is_admin = $_SESSION['user']['is_admin'] ?? false;
    // Destroy user session here
    session_destroy();
    return $response->withHeader('Location', $is_admin ? '/admin/login' : '/')->withStatus(302);
  }

  public function editProfile(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    // CSRF token name and value
    $this->addCsrfToView($request);

    return $this->view->render($response, '/auth/update_profile.twig', [
      'user_id' => $_SESSION['user']['id']
    ]);
  }

  public function updateProfile(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args['id'];
    if ($id != $_SESSION['user']['id'] && !$_SESSION['user']['is_admin']) {
      return $response->withHeader('Location', '/')->withStatus(302);
    }

    $data = $request->getParsedBody();
    $uploadedFiles = $request->getUploadedFiles();

    // Add the uploaded file to the data array for validation
    $data['profile_picture'] = $uploadedFiles['profile_picture'] ?? NULL;

    // Define validation rules
    $rules = [];

    if (!empty($data['password'])) {
      $rules['password'] = 'required|min:8';
      $rules['password_confirm'] = 'required|same:password';
    }

    // Add profile picture validation rules only if a file is uploaded
    if ($data['profile_picture'] && $data['profile_picture']->getError() === UPLOAD_ERR_OK) {
      $rules['profile_picture'] = 'file|mimes:jpeg,jpg,png|max:2048';
    }

    // Validate input
    $validator = new Validator();
    if (!$validator->validate($data, $rules)) {
      $errors = $validator->getErrors();
      $this->addCsrfToView($request);

      return $this->view->render($response, 'auth/update_profile.twig', [
        'errors' => $errors,
        'user_id' => $_SESSION['user']['id'],
        'data' => $data // Pass back the input data to pre-fill the form
      ]);
    }

    // Handle profile picture upload
    $profilePicture = $data['profile_picture'];
    $profilePicturePath = $_SESSION['user']['profile_picture'];
    if ($profilePicture && $profilePicture->getError() === UPLOAD_ERR_OK) {
      $uploadDir = __DIR__ . '/../../public/uploads/profile_pictures/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }
      $filename = uniqid() . '-' . $profilePicture->getClientFilename();
      $profilePicture->moveTo($uploadDir . $filename);
      $profilePicturePath = '/uploads/profile_pictures/' . $filename;
    }


    // Hash the password and register user
    $hashedPassword = !empty($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : NULL;

    $userId = $this->userModel->updateProfile($id, $profilePicturePath, $hashedPassword);

    if (!$userId) {
      $this->addCsrfToView($request);
      return $this->view->render($response, 'auth/update_profile.twig', [
        'errors' => ['general' => ['Update failed. Please try again.']],
        'data' => $data // Pass back the input data to pre-fill the form
      ]);
    }

    // Optionally log in the new user immediately
    $_SESSION['user']['profile_picture'] = $profilePicturePath;
    ;

    $this->flash->addMessage('success', 'Profile Updated Successfully');
    // Redirect to home or profile
    return $response->withHeader('Location', '/update-profile')->withStatus(302);
  }
}
