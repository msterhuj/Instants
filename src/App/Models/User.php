<?php

namespace App\Models;

use Core\ORM\Database;
use Core\ORM\Model;
use DateTime;

class User extends Model {

    private ?int $id = null;
    private ?string $username = null;
    private ?string $description = null;
    private ?string $email = null;
    private ?string $pwd = null;
    private array $role = [];
    private ?string $vreg = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;
    private ?string $dateOfBirth = null;

    protected function getData(): array {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "description" => $this->description,
            "email" => $this->email,
            "pwd" => $this->pwd,
            "role" => serialize($this->role),
            "vreg" => $this->vreg,
            "createdAt" => $this->getCreatedAt(),
            "updatedAt" => $this->getUpdatedAt(),
            "dateOfBirth" => $this->getDateOfBirth(),
        ];
    }


    public function serialize(): ?string {
        return serialize($this->getData());
    }

    public function unserialize($data): User {
        foreach ($data as $key => $value) {
            if (is_array($this->$key)) $this->$key = unserialize($value);
            else $this->$key = $value;
        }
        return $this;
    }

    public static function loadBy(string $key, string $value): \stdClass|User {
        $con = Database::getPDO();
        $prepare = $con->prepare("select * from user where $key = :value;");
        $prepare->execute(["value" => $value]);
        $result = $prepare->fetchObject();
        $user = new User();
        $user->unserialize($result);
        return $user;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @param string $username

     */
    public function setUsername(string $username) {
        $this->username = $username;

    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     * @return User
     */
    public function setDescription(string $description): User {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPwd(): string {
        return $this->pwd;
    }

    /**
     * @param string $pwd
     * @return User
     */
    public function setPwd(string $pwd): User {
        $this->pwd = password_hash($pwd, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array {
        return $this->role;
    }

    /**
     * @param string $role
     * @return User
     */
    public function addRoles(string $role): User {
        if (!in_array($role, $this->role))
            $this->role[] = $role;
        return $this;
    }
    /**
     * @param string $role
     * @return User
     */
    public function delRoles(string $role): User {
        if (($key = array_search($role, $this->role)) !== false)
            unset($this->role[$key]);

        return $this;
    }

    /**
     * @return string
     */
    public function getVreg(): string {
        return $this->vreg;
    }

    /**
     * @param string|null $vreg
     * @return User
     */
    public function setVreg(string $vreg = null): User {
        $this->vreg = $vreg;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string {
        if (empty($this->createdAt)) {
            $this->createdAt = date('Y-m-d H:i:s');
        }
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string {
        $this->updatedAt = date('Y-m-d H:i:s');
        return $this->updatedAt;
    }

    /**
     * @return DateTime|null
     */
    public function getDateOfBirth(): ?string {
        return $this->dateOfBirth;
    }

    /**
     * @param string|null $dateOfBirth
     */
    public function setDateOfBirth(?string $dateOfBirth): void {
        $this->dateOfBirth = $dateOfBirth;
    }
}