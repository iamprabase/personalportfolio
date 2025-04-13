<?php
namespace App\Controllers;

use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\ArticleModel;
use App\Models\PageModel;
use App\Models\CommentModel;
use Cocur\Slugify\Slugify;
use Slim\Csrf\Guard;

class AdminController extends BaseController {
    protected $articleModel;
    protected $pageModel;
    protected $commentModel;

    public function __construct(Guard $csrf) {
        parent::__construct($csrf);

        $this->articleModel = new ArticleModel();
        $this->pageModel    = new PageModel();
        $this->commentModel = new CommentModel();
    }

    public function dashboard(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->view->render($response, 'admin/dashboard.twig');
    }
    
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // CSRF token name and value
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
        // Pass the CSRF token to the view
        $this->view->getEnvironment()->addGlobal('csrf', [
            'token_name_key' => $nameKey,
            'token_value_key' => $valueKey,
            'token_name'     => $name,
            'token_value'    => $value,
        ]);
        return $this->view->render($response, 'admin/article_form.twig', ['article' => null]);
    }
    
    public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $data = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        // Add the uploaded file to the data array for validation
        $data['featured_image'] = $uploadedFiles['featured_image'] ?? null;

        // Define validation rules
        $rules = [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
        ];

        // Add profile picture validation rules only if a file is uploaded
        if ($data['featured_image'] && $data['featured_image']->getError() === UPLOAD_ERR_OK) {
            $rules['featured_image'] = 'file|mimes:jpeg,jpg,png|max:2048';
        }


        // Validate input
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
            return $this->view->render($response, 'admin/article_form.twig', [
                'errors' => $errors,
                'article' => $data // Pre-fill the form with the submitted data
            ]);
        }

        // Handle profile picture upload
        $featuredImage = $data['featured_image'];
        $featuredImagePath = null;
        if ($featuredImage && $featuredImage->getError() === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/featured_images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Generate a unique filename and sanitize it
            $filename = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $featuredImage->getClientFilename());
            $featuredImage->moveTo($uploadDir . $filename);
            $featuredImagePath = '/uploads/featured_images/' . $filename;
        }

        // Create a Slugify instance
        $slugify = new Slugify();

        // Generate a slug from a title
        $slug = $slugify->slugify($data['title']);

        $data['slug'] = $slug;

        $this->articleModel->createArticle($data['title'], $data['content'], $data['slug'], $featuredImagePath);
        
        $response->getBody()->write("Article created successfully!");
        return $response;
    }
    
    public function edit(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $article = $this->articleModel->getArticleById($id);
        if (!$article) {
            $response->getBody()->write("Article not found");
            return $response->withStatus(404);
        }

        // CSRF token name and value
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();
        $name = $request->getAttribute($nameKey);
        $value = $request->getAttribute($valueKey);
        // Pass the CSRF token to the view
        $this->view->getEnvironment()->addGlobal('csrf', [
            'token_name_key' => $nameKey,
            'token_value_key' => $valueKey,
            'token_name'     => $name,
            'token_value'    => $value,
        ]);

        return $this->view->render($response, 'admin/article_form.twig', ['article' => $article]);
    }
    
    public function update(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $uploadedFiles = $request->getUploadedFiles();

        // Add the uploaded file to the data array for validation
        $data['featured_image'] = $uploadedFiles['featured_image'] ?? null;

        // Define validation rules
        $rules = [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'slug' => 'required|alpha_dash|min:3|max:100'
        ];

        // Add featured image validation rules only if a file is uploaded
        if ($data['featured_image'] && $data['featured_image']->getError() === UPLOAD_ERR_OK) {
            $rules['featured_image'] = 'file|mimes:jpeg,jpg,png|max:2048';
        }

        // Validate input
        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
            $article = $this->articleModel->getArticleById($id);
            return $this->view->render($response, 'admin/article_form.twig', [
                'errors' => $errors,
                'article' => array_merge($article, $data) // Merge existing data with submitted data
            ]);
        }

        // Retrieve the existing article to get the current featured image path
        $article = $this->articleModel->getArticleById($id);
        $oldFeaturedImagePath = $article['featured_image'] ?? null;

        // Handle featured image upload
        $featuredImage = $data['featured_image'];
        $featuredImagePath = $oldFeaturedImagePath; // Default to the old image path
        if ($featuredImage && $featuredImage->getError() === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/featured_images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate a unique filename and sanitize it
            $filename = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $featuredImage->getClientFilename());
            $featuredImage->moveTo($uploadDir . $filename);
            $featuredImagePath = '/uploads/featured_images/' . $filename;

            // Delete the old featured image if it exists
            if ($oldFeaturedImagePath && file_exists(__DIR__ . '/../../public' . $oldFeaturedImagePath)) {
                unlink(__DIR__ . '/../../public' . $oldFeaturedImagePath);
            }
        }

        // Update the article with the new data
        $this->articleModel->updateArticle($id, $data['title'], $data['content'], $data['slug'], $featuredImagePath);
        $response->getBody()->write("Article updated successfully!");
        return $response;
    }
    
    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];

        // Retrieve the article to get the current featured image path
        $article = $this->articleModel->getArticleById($id);
        $featuredImagePath = $article['featured_image'] ?? null;

        // Delete the article
        $this->articleModel->deleteArticle($id);

        // Delete the featured image if it exists
        if ($featuredImagePath && file_exists(__DIR__ . '/../../public' . $featuredImagePath)) {
            unlink(__DIR__ . '/../../public' . $featuredImagePath);
        }

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
