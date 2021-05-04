<?php

namespace App\Models;

use App\Exception\PostNotFoundException;
use Core\ORM\Database;
use Core\ORM\Model;

class Post extends Model {

    private ?int $id = null;
    private int|null|User $author = null;
    private ?string $content = null;
    private ?string $createdAt = null;
    private ?Post $replyTo = null;

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
    public static function loadBy(string $key, string $value): Post {
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
        if ($this->author instanceof  User) return $this->author;
        // else todo get user objet set it and return user
    }

    /**
     * @param int $author
     */
    public function setAuthor(int $author): void {
        $this->author = $author;
        // todo set author objet by author id
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void {
        $this->content = $content;
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
     * @return int
     */
    public function getReplyToId(): int {
        // todo make retunr id by reply to post
        return 0;
    }

    /**
     * @return Post
     */
    public function getReplyTo(): Post {
        return $this->replyTo;
    }

    /**
     * @param Post $replyTo
     */
    public function setReplyTo(Post $replyTo): void {
        $this->replyTo = $replyTo;
    }
}