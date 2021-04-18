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
    private ?string $verified_code = null;

    /**
     * User constructor.
     */
    public function __construct() {
        parent::__construct(tabPrefix: "test_");
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
            "verified_code" => $this->verified_code
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
     * @return User
     */
    public function setUsername(string $username): User {
        $this->username = $username;
        return $this;
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
    public function getVerifiedCode(): string {
        return $this->verified_code;
    }

    /**
     * @param string $verified_code
     * @return User
     */
    public function setVerifiedCode(string $verified_code): User {
        $this->verified_code = $verified_code;
        return $this;
    }
}