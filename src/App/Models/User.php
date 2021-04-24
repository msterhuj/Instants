<?php

namespace App\Models;

use Core\ORM\Model;

class User extends Model {

    private ?int $id = null;
    private ?string $username = null;
    private ?string $description = null;
    private ?string $email = null;
    private ?string $pwd = null;
    private ?array $roles = null;
    private ?string $vreg = null;
    private ?int $createdAt = null;
    private ?int $updatedAt = null;

    /**
     * User constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param string $vreg
     */
    public static function ActivateByVreg(string $vreg) {
        echo $vreg;
        // todo get user by vreg and add role 'user' to user account clean vreg var
    }

    /**
     * @return array
     */
    protected function getData(): array {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "description" => $this->description,
            "email" => $this->email,
            "pwd" => $this->pwd,
            "role" => $this->roles,
            "vreg" => $this->vreg,
            "createdAt" => $this->getCreatedAt(),
            "updatedAt" => $this->getUpdatedAt()
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
     * @return User
     */
    public function setId(int $id): User {
        $this->id = $id;
        return $this;
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
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): User {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return string
     */
    public function getVreg(): string {
        return $this->vreg;
    }

    /**
     * @param string $vreg
     * @return User
     */
    public function setVreg(string $vreg): User {
        $this->vreg = $vreg;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCreatedAt(): ?int {
        return $this->createdAt;
    }

    /**
     * @param int|null $createdAt
     */
    public function setCreatedAt(?int $createdAt): void {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int|null
     */
    public function getUpdatedAt(): ?int {
        return $this->updatedAt;
    }

    /**
     * @param int|null $updatedAt
     */
    public function setUpdatedAt(?int $updatedAt): void {
        $this->updatedAt = $updatedAt;
    }
}