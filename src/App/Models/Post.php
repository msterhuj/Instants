<?php

namespace App\Models;

use Core\ORM\Model;

class Post extends Model {

    private int $id;
    private User|int $author;
    private string $content;
    private int $createdAt;
    private Post $replyTo;

    /**
     * @inheritDoc
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
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
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
     * @return int
     */
    public function getCreatedAt(): int {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt(int $createdAt): void {
        $this->createdAt = $createdAt;
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