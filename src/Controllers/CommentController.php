<?php
namespace App\Controllers;

use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\CommentModel;
use App\Models\ArticleModel;
use Slim\Csrf\Guard;

class CommentController extends BaseController {
    protected $commentModel;

    protected $articleModel;

    public function __construct(Guard $csrf) {
        parent::__construct($csrf);

        $this->commentModel = new CommentModel();
        $this->articleModel = new ArticleModel();
    }

    /**
     * Sets the configuration for the database connection.
     *
     * @param array $config The database configuration (host, dbname, user, pass, charset)
     */
    public static function setConfig(array $config): void {
        self::$config = $config;
    }

    public function store(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['article_id'];
        $data = $request->getParsedBody();
        $rules = [
            'comment_text' => 'required|min:3|max:1024',
        ];

        $article = $this->articleModel->getArticleById($id);
        if (!$article) {
            return $response
                ->withHeader('Location', '/article/' . $article['slug'])
                ->withStatus(302);
        }

        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();
            $_SESSION['comment_errors'] = implode('<br/>', $errors['comment_text']);
            return $response
                ->withHeader('Location', '/article/' . $article['slug'])
                ->withStatus(302);
        }

        $this->commentModel->createComment($id, $data['comment_text']);
        $_SESSION['comment_success'] = 'Comment added successfully!';
        return $response
            ->withHeader('Location', '/article/' . $article['slug'])
            ->withStatus(302);
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $rules = [
            'comment_text' => 'required|min:3|max:1024',
        ];

        $comment = $this->commentModel->getCommentById($id);

        if (!$comment) {
          $payload = json_encode([
            'ok' => false,
            'error' => 'Related comment not found!',
          ]);

          $response->getBody()->write($payload);

          return $response
              ->withHeader('Content-Type', 'application/json')
              ->withStatus(403);
        }

        if($comment['user_id'] != $_SESSION['user']['id'] && !$_SESSION['user']['is_admin']) {
          $payload = json_encode([
            'ok' => false,
            'error' => 'You aren\'t allowed to edit this comment!',
          ]);

          $response->getBody()->write($payload);

          return $response
              ->withHeader('Content-Type', 'application/json')
              ->withStatus(403);
        }

        $validator = new Validator();
        if (!$validator->validate($data, $rules)) {
            $errors = $validator->getErrors();

            $payload = json_encode([
              'ok' => false,
              'error' => implode('<br/>', $errors['comment_text']),
            ]);

            $response->getBody()->write($payload);

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(403);
        }

        $this->commentModel->updateComment($id, $data['comment_text']);

        $payload = json_encode([
          'ok' => true,
          'message' => 'Comment updated successfully!',
          'comment_text' => $data['comment_text']
        ]);

        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);

    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'];

        $comment = $this->commentModel->getCommentById($id);
        if($comment['user_id'] != $_SESSION['user']['id'] && !$_SESSION['user']['is_admin']) {
          $payload = json_encode([
            'ok' => false,
            'error' => 'You aren\'t allowed to delete this comment!',
          ]);

          $response->getBody()->write($payload);

          return $response
              ->withHeader('Content-Type', 'application/json')
              ->withStatus(403);
        }
        $this->commentModel->deleteComment($id);

        $payload = json_encode([
          'ok' => true,
          'message' => 'Comment deleted successfully!',
        ]);

        $response->getBody()->write($payload);

//        return $response
//            ->withHeader('Content-Type', 'application/json')
//            ->withStatus(200);
        return $response->withHeader('Location', '/admin/comments')->withStatus(302);

    }
}
