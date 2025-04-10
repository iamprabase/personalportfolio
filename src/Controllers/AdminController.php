<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\ArticleModel;
use App\Models\PageModel;       // A new model for pages (see note below)
use App\Models\CommentModel;

class AdminController extends BaseController {
    protected $articleModel;
    protected $pageModel;
    protected $commentModel;

    public function __construct() {
        $this->articleModel = new ArticleModel();
        $this->pageModel    = new PageModel();
        $this->commentModel = new CommentModel();
    }

    public function dashboard(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->view->render($response, 'admin/dashboard.twig');
    }
    
    public function newArticle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->view->render($response, 'admin/edit_article.twig', ['article' => null]);
    }
    
    public function createArticle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $data = $request->getParsedBody();

        // Define validation rules
        $rules = [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'slug' => 'required|alpha_dash|min:3|max:100'
        ];

        // Validate input
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
            return $this->view->render($response, 'admin/edit_article.twig', [
                'errors' => $errors,
                'article' => $data // Pre-fill the form with the submitted data
            ]);
        }

        $this->articleModel->createArticle($data['title'], $data['content'], $data['slug']);
        $response->getBody()->write("Article created successfully!");
        return $response;
    }
    
    public function editArticle(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $article = $this->articleModel->getArticleById($id);
        if (!$article) {
            $response->getBody()->write("Article not found");
            return $response->withStatus(404);
        }
        return $this->view->render($response, 'admin/edit_article.twig', ['article' => $article]);
    }
    
    public function updateArticle(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $data = $request->getParsedBody();

        // Define validation rules
        $rules = [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'slug' => 'required|alpha_dash|min:3|max:100'
        ];

        // Validate input
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
            $article = $this->articleModel->getArticleById($id);
            return $this->view->render($response, 'admin/edit_article.twig', [
                'errors' => $errors,
                'article' => array_merge($article, $data) // Merge existing data with submitted data
            ]);
        }

        // Update the article
        $this->articleModel->updateArticle($id, $data['title'], $data['content'], $data['slug']);
        $response->getBody()->write("Article updated successfully!");
        return $response;
    }
    
    public function deleteArticle(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $this->articleModel->deleteArticle($id);
        $response->getBody()->write("Article deleted successfully!");
        return $response;
    }
    
    // PAGE MANAGEMENT (similar structure as articles, for CMS pages)
    // Create a new page (SEO related)
    public function newPage(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->view->render($response, 'admin/edit_page.twig', ['page' => null]);
    }

    // Process new page creation
    public function createPage(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $data = $request->getParsedBody();
        $this->pageModel->createPage($data['title'], $data['content'], $data['meta_title'], $data['meta_description'], $data['canonical_url'], $data['language']);
        $response->getBody()->write("Page created successfully!");
        return $response;
    }

    // Edit a page (display current values)
    public function editPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $page = $this->pageModel->getPageById($id);
        if (!$page) {
            $response->getBody()->write("Page not found");
            return $response->withStatus(404);
        }
        return $this->view->render($response, 'admin/edit_page.twig', ['page' => $page]);
    }

    // Process page update
    public function updatePage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $this->pageModel->updatePage($id, $data['title'], $data['content'], $data['meta_title'], $data['meta_description'], $data['canonical_url'], $data['language']);
        $response->getBody()->write("Page updated successfully!");
        return $response;
    }

    // Delete a page
    public function deletePage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $this->pageModel->deletePage($id);
        $response->getBody()->write("Page deleted successfully!");
        return $response;
    }

    // COMMENT MANAGEMENT
    public function manageComments(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $comments = $this->commentModel->getAllComments();
        return $this->view->render($response, 'admin/comments.twig', ['comments' => $comments]);
    }
    public function deleteComment(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $this->commentModel->deleteComment($id);
        $response->getBody()->write("Comment deleted successfully!");
        return $response;
    }
}
