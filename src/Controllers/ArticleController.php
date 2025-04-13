<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\ArticleModel;
use App\Models\CommentModel;
use App\Models\LanguageModel;
use Slim\Csrf\Guard;

class ArticleController extends BaseController {
    protected $articleModel;
    protected $commentModel;
    protected $languageModel;

    private static $config = null; // Holds the configuration

    public function __construct(Guard $csrf) {
        parent::__construct($csrf);
        
        $this->articleModel  = new ArticleModel();
        $this->commentModel  = new CommentModel();
        $this->languageModel = new LanguageModel();
    }

    /**
     * Sets the configuration for the database connection.
     *
     * @param array $config The database configuration (host, dbname, user, pass, charset)
     */
    public static function setConfig(array $config): void {
        self::$config = $config;
    }

    // Home page: list all articles
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $queryParams = $request->getQueryParams();
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
        $perPage = 2; // Number of articles per page

        $articles = $this->articleModel->getPaginatedArticles($page, $perPage);
        $totalArticles = $this->articleModel->getTotalArticles();

        $totalPages = ceil($totalArticles / $perPage);

        return $this->view->render($response, 'index.twig', [
            'articles' => $articles,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    // View a single article by its slug
    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $slug = $args['slug'];
        $article = $this->articleModel->getArticleBySlug($slug);

        if (!$article) {
            $response->getBody()->write("Article not found");
            return $response->withStatus(404);
        }
        $comments = $this->commentModel->getCommentsByArticleId($article['id']);

        $current_user_id = $_SESSION['user']['id'] ?? null;
        $is_admin = $_SESSION['user']['is_admin'] ? true : false;

        $this->addCsrfToView($request); // Use the method from BaseController

        return $this->view->render($response, 'article.twig', [
          'article' => $article,
          'comments'=> $comments,
          'current_user_id' => $current_user_id,
          'is_admin' => $is_admin,
            // Pass page meta for SEO/Open Graph tag rendering
            'page'     => [
                'meta_title'        => $article['meta_title'],
                'meta_description'  => $article['meta_description'],
                'canonical_url'     => $article['canonical_url'],
                'language'          => $article['language']
            ]
          ]);
    }
}
