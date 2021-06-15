<?php


namespace App\Models;


use App\Exception\ReportNotFoundException;
use Core\ORM\Database;
use Core\ORM\Model;

class Report extends Model {

    private ?int $id = null;
    private int|null|User $author = null;
    private ?int $post = null;
    private ?string $createdAt = null;

    public function __construct() {
        $this->author = User::getFromSession();
    }

    protected function getData(): array {
        return [
            "id" => $this->id,
            "author" => $this->getAuthorId(),
            "post" => $this->getPost(),
            "createdAt" => $this->getCreatedAt()
        ];
    }

    public function serialize(): ?string {
        return serialize($this->getData());
    }

    /**
     * @throws ReportNotFoundException
     */
    public function unserialize($data) {
        if (!$data) throw new ReportNotFoundException();
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function loadBy(string $key, string $value): self {
        $prepare = Database::getPDO()->prepare("select * from report where $key = :value;");
        $prepare->execute([
            "value" => $value
        ]);
        $report = new Report();
        $report->unserialize($prepare->fetchObject());
        return $report;
    }

    public static function getAll() {
        $prepare = Database::getPDO()->prepare("select id from report");
        $prepare->execute();
        $reports = [];
        foreach ($prepare->fetchAll(\PDO::FETCH_ASSOC) as $value) {
            $reports[] = self::loadBy("id", $value["id"]);
        }

        return $reports;
    }

    /**
     * @return int|null
     */
    public function getPost(): ?int
    {
        return $this->post;
    }

    /**
     * @param int|null $post
     */
    public function setPost(?int $post): void
    {
        $this->post = $post;
    }


    public function getAuthorId(): int {
        if ($this->author instanceof User) {
            return $this->author->getId();
        } else return $this->author;
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
}