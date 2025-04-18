<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\ArticleModel;
use App\Models\UserModel;
use App\Models\CommentModel;
use App\Utils\Validator;
use Cocur\Slugify\Slugify;
use Slim\Csrf\Guard;

class AdminController extends BaseController
{
  protected $articleModel;
  protected $commentModel;
  protected $userModel;

  private static $config = null; // Holds the configuration

  public function __construct(Guard $csrf)
  {
    parent::__construct($csrf);

    $this->articleModel = new ArticleModel();
    $this->commentModel = new CommentModel();
    $this->userModel = new UserModel();
  }

  /**
   * Sets the configuration for the database connection.
   *
   * @param array $config The database configuration (host, dbname, user, pass, charset)
   */
  public static function setConfig(array $config): void
  {
    self::$config = $config;
  }

  /**
   * Return Article Lists page
   */
  public function listArticles(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $queryParams = $request->getQueryParams();
    $page = isset($queryParams['page']) ? (int) $queryParams['page'] : 1;
    $perPage = $totalArticles = $this->articleModel->getTotalArticles();

    $articles = $this->articleModel->getPaginatedArticles($page, $perPage);

    $totalPages = $totalArticles > 0 ? ceil($totalArticles / $perPage) : 0;

    $this->addCsrfToView($request);

    return $this->view->render($response, 'admin/articles.twig', [
      'articles' => $articles,
      'currentPage' => $page,
      'totalPages' => $totalPages,
      'page' => [
        'meta_title' => self::$config['meta_title'],
        'meta_description' => self::$config['meta_description'],
        'canonical_url' => self::$config['canonical_url'],
        'language' => self::$config['language'],
      ],
    ]);
  }

  /**
   * Return List comments
   */
  public function listComments(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $queryParams = $request->getQueryParams();
    $page = isset($queryParams['page']) ? (int) $queryParams['page'] : 1;
    $perPage = $totalComments = $this->commentModel->getTotalComments();

    $comments = $this->commentModel->getPaginatedComments($page, $perPage);

    $totalPages = $totalComments > 0 ? ceil($totalComments / $perPage) : 0;

    $this->addCsrfToView($request);

    return $this->view->render($response, 'admin/comments.twig', [
        'comments' => $comments,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'page' => [
            'meta_title' => self::$config['meta_title'],
            'meta_description' => self::$config['meta_description'],
            'canonical_url' => self::$config['canonical_url'],
            'language' => self::$config['language'],
        ],
    ]);
  }

  /**
   * Return Admin dashboard page
   */
  public function dashboard(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $queryParams = $request->getQueryParams();
    $page = isset($queryParams['page']) ? (int) $queryParams['page'] : 1;
    $perPage = $totalUsers = $this->userModel->getTotalUsers();

    $users = $this->userModel->getPaginatedUsers($page, $perPage);

    $totalPages = $totalUsers > 0 ? ceil($totalUsers / $perPage) : 0;

    $this->addCsrfToView($request);

    return $this->view->render($response, 'admin/dashboard.twig', [
      'users' => $users,
      'currentPage' => $page,
      'totalPages' => $totalPages,
      'page' => [
        'meta_title' => self::$config['meta_title'],
        'meta_description' => self::$config['meta_description'],
        'canonical_url' => self::$config['canonical_url'],
        'language' => self::$config['language'],
      ],
    ]);
  }

  // ARTICLE MANAGEMENT
  public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $this->addCsrfToView($request); // Use the method from BaseController
    return $this->view->render($response, 'admin/article_form.twig', ['article' => null]);
  }

  public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $data = $request->getParsedBody();
    $uploadedFiles = $request->getUploadedFiles();

    $data['featured_image'] = $uploadedFiles['featured_image'] ?? null;

    $rules = [
      'title' => 'required|min:3|max:255',
      'content' => 'required|min:10',
      'post_type' => 'max:50',
    ];

    if ($data['featured_image'] && $data['featured_image']->getError() === UPLOAD_ERR_OK) {
      $rules['featured_image'] = 'file|mimes:jpeg,jpg,png|max:2048';
    }

    $validator = new Validator();
    if (!$validator->validate($data, $rules)) {
      $this->addCsrfToView($request);
      $errors = $validator->getErrors();
      return $this->view->render($response, 'admin/article_form.twig', [
        'errors' => $errors,
        'article' => $data
      ]);
    }

    $featuredImagePath = $this->handleFileUpload($data['featured_image'], 'featured_images');
    $slug = (new Slugify())->slugify($data['title']);

    $this->articleModel->createArticle($data['title'], $data['content'], $slug, $featuredImagePath, $data['post_type'] );

    $this->flash->addMessage('success', 'Article created successfully!');

    return $response->withHeader('Location', '/admin')->withStatus(302);
  }

  public function edit(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args['id'];
    $article = $this->articleModel->getArticleById($id);
    if (!$article) {
      return $response->withStatus(404)->write("Article not found");
    }

    $this->addCsrfToView($request); // Use the method from BaseController
    return $this->view->render($response, 'admin/article_form.twig', ['article' => $article]);
  }

  public function update(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args['id'];
    $data = $request->getParsedBody();
    $uploadedFiles = $request->getUploadedFiles();

    $data['featured_image'] = $uploadedFiles['featured_image'] ?? null;

    $rules = [
      'title' => 'required|min:3|max:255',
      'content' => 'required|min:10',
      'post_type' => 'max:50',
    ];

    if ($data['featured_image'] && $data['featured_image']->getError() === UPLOAD_ERR_OK) {
      $rules['featured_image'] = 'file|mimes:jpeg,jpg,png|max:2048';
    }

    $validator = new Validator();
    if (!$validator->validate($data, $rules)) {
      $this->addCsrfToView($request);
      $errors = $validator->getErrors();
      $article = $this->articleModel->getArticleById($id);
      return $this->view->render($response, 'admin/article_form.twig', [
        'errors' => $errors,
        'article' => array_merge($article, $data)
      ]);
    }

    $article = $this->articleModel->getArticleById($id);
    $oldFeaturedImagePath = $article['featured_image'] ?? null;

    $featuredImagePath = $this->handleFileUpload($data['featured_image'], 'featured_images', $oldFeaturedImagePath);

    $slug = (new Slugify())->slugify($data['title']);

    $this->articleModel->updateArticle($id, $data['title'], $data['content'], $slug, $featuredImagePath, $data['post_type']);

    $this->flash->addMessage('success', 'Article updated successfully!');

    return $response->withHeader('Location', '/admin')->withStatus(302);
  }

  public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $id = $args['id'];
    $article = $this->articleModel->getArticleById($id);
    $featuredImagePath = $article['featured_image'] ?? null;

    $this->articleModel->deleteArticle($id);

    if ($featuredImagePath && file_exists(__DIR__ . '/../../public' . $featuredImagePath)) {
      unlink(__DIR__ . '/../../public' . $featuredImagePath);
    }

    $this->flash->addMessage('success', 'Article deleted successfully!');

    return $response->withHeader('Location', '/admin')->withStatus(302);
  }

  // PAGE MANAGEMENT (similar structure as articles, for CMS pages)
  // Create a new page (SEO related)
  public function newPage(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    return $this->view->render($response, 'admin/edit_page.twig', ['page' => null]);
  }

  // Process new page creation
  // public function createPage(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
  //     $data = $request->getParsedBody();
  //     $this->pageModel->createPage($data['title'], $data['content'], $data['meta_title'], $data['meta_description'], $data['canonical_url'], $data['language']);
  //     $response->getBody()->write("Page created successfully!");
  //     return $response;
  // }

  // // Edit a page (display current values)
  // public function editPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
  //     $id = $args['id'];
  //     $page = $this->pageModel->getPageById($id);
  //     if (!$page) {
  //         $response->getBody()->write("Page not found");
  //         return $response->withStatus(404);
  //     }
  //     return $this->view->render($response, 'admin/edit_page.twig', ['page' => $page]);
  // }

  // // Process page update
  // public function updatePage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
  //     $id = $args['id'];
  //     $data = $request->getParsedBody();
  //     $this->pageModel->updatePage($id, $data['title'], $data['content'], $data['meta_title'], $data['meta_description'], $data['canonical_url'], $data['language']);
  //     $response->getBody()->write("Page updated successfully!");
  //     return $response;
  // }

  // // Delete a page
  // public function deletePage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
  //     $id = $args['id'];
  //     $this->pageModel->deletePage($id);
  //     $response->getBody()->write("Page deleted successfully!");
  //     return $response;
  // }

  // HELPER METHODS
  private function handleFileUpload($file, string $directory, ?string $oldFilePath = null): ?string
  {
    if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
      return $oldFilePath;
    }

    $uploadDir = __DIR__ . "/../../public/uploads/$directory/";
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $filename = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $file->getClientFilename());
    $file->moveTo($uploadDir . $filename);

    if ($oldFilePath && file_exists(__DIR__ . '/../../public' . $oldFilePath)) {
      unlink(__DIR__ . '/../../public' . $oldFilePath);
    }

    return "/uploads/$directory/$filename";
  }
}
