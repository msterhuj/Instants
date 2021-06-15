<?php

namespace App\Models;

use App\Exception\PostNotFoundException;
use Core\ORM\Database;
use Core\ORM\Model;
use Core\Router\Route;

class Post extends Model {

    private ?int $id = null;
    private int|null|User $author = null;
    private ?string $content = null;
    private ?string $createdAt = null;
    private int|null|Post $replyTo = null;

    /**
     * Post constructor.
     */
    public function __construct() {
        $this->author = User::getFromSession();
    }


    /**
     * Implement parent method
     */

    /**
     * @return array
     */
    protected function getData(): array {
        return [
            "id" => $this->getId(),
            "author" => $this->getAuthorId(),
            "content" => $this->getContent(),
            "createdAt" => $this->getCreatedAt(),
            "replyTo" => $this->getReplyToId()
        ];
    }

    /**
     * @return string|null
     */
    public function serialize(): ?string {
        return serialize($this->getData());
    }

    /**
     * @throws PostNotFoundException
     */
    public function unserialize($data): Post {
        if (!$data) throw new PostNotFoundException();
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Post
     * @throws PostNotFoundException
     */
    public static function loadBy(string $key, string $value): self {
        $con = Database::getPDO();
        $prepare = $con->prepare("select * from post where $key = :values;");
        $prepare->execute(["values" => $value]);
        $post = new Post();
        $post->unserialize($prepare->fetchObject());
        return $post;
    }

    /**
     * Object logic
     */

    public function isLiked() {
        $con = Database::getPDO();
        $prepare = $con->prepare("select * from `like` where post = :post and user = :user");
        $prepare->execute([
            "user" => intval($_SESSION["USER"]),
            "post" => intval(Route::getRouteParam())
        ]);
        return !empty($prepare->fetchObject());
    }

    /**
     * @return bool
     */
    public function like(): bool {
        $con = Database::getPDO();
        $liked = $this->isLiked();
        if ($liked) {
            // remove like
            $prepare = $con->prepare("delete from `like` where post = :post and user = :user");
        } else {
            // add like
            $prepare = $con->prepare("insert into `like` (post, user) value (:post, :user)");
        }
        $prepare->execute([
            "user" => intval($_SESSION["USER"]),
            "post" => intval(Route::getRouteParam())
        ]);
        return $liked;
    }

    /**
     * Getter Setter
     */

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int {
        if ($this->author instanceof User) {
            return $this->author->getId();
        } else return $this->author;
    }

    /**
     * @return User
     */
    public function getAuthor(): User {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string {
        if (empty($this->createdAt)) {
            $this->createdAt = date('Y-m-d H:i:s');
        }
        return $this->createdAt;
    }

    /**
     * @return ?int
     */
    public function getReplyToId(): ?int {
        if ($this->replyTo instanceof Post) return $this->replyTo->getId();
        return $this->replyTo;
    }

    /**
     * Get parent post
     * @return Post
     * @throws PostNotFoundException
     */
    public function getReplyTo(): Post {
        if ($this->replyTo instanceof Post) return $this->replyTo;
        return self::loadBy("id", $this->replyTo);
    }

    /**
     * @param Post $replyTo
     * @return Post
     */
    public function setReplyTo(Post $replyTo): self {
        $this->replyTo = $replyTo;
        return $this;
    }
}