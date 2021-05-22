<?php

namespace App\Models;

use App\Exception\UserNotFoundException;
use Core\ORM\Database;
use Core\ORM\Model;
use Core\Router\Route;
use DateTime;

class User extends Model {

    private ?int $id = null;
    private ?string $picture = null;
    private ?string $username = null;
    private ?string $description = null;
    private ?string $email = null;
    private ?string $pwd = null;
    private array $role = [];
    private ?string $vreg = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;
    private ?string $dateOfBirth = null;

    /**
     * Implement parent method
     */

    /**
     * @return array
     */
    protected function getData(): array {
        return [
            "id" => $this->id,
            "picture" => $this->picture,
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

    /**
     * @return string
     */
    public function serialize(): string {
        return serialize($this->getData());
    }

    /**
     * @param $data
     * @return self
     * @throws UserNotFoundException
     */
    public function unserialize($data): self {
        if (!$data) throw new UserNotFoundException();
        if (is_string($data)) $data = unserialize($data);
        foreach ($data as $key => $value) {
            if (is_array($this->$key)) $this->$key = unserialize($value);
            else $this->$key = $value;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return self
     * @throws UserNotFoundException
     */
    public static function loadBy(string $key, string $value): self {
        $con = Database::getPDO();
        $user = new User();
        $prepare = $con->prepare("select * from " . $user->getTableName() . " where $key = :value;");
        $prepare->execute(["value" => $value]);
        $result = $prepare->fetchObject();
        $user->unserialize($result);
        return $user;
    }

    public static function getAll() {
        $con = Database::getPDO();
        $prepare = $con->prepare("select id from user");
        $prepare->execute();
        $users = [];
        foreach ($prepare->fetchAll(\PDO::FETCH_ASSOC) as $value) {
            $users[] = self::loadBy("id", $value['id']);
        }
        return $users;
    }

    /**
     * Object logic
     */

    public function generateGravatarPicture() {
        $this->picture = "https://www.gravatar.com/avatar/".
            md5( strtolower( trim( $this->email ) ) ).
            "?s=240&d=monsterid&r=g";
        return $this;
    }
    
    /**
     * @param string $role
     * @return self
     */
    public function addRoles(string $role): self {
        if (!in_array($role, $this->role))
            $this->role[] = $role;
        return $this;
    }

    /**
     * @param string $role
     * @return self
     */
    public function delRoles(string $role): self {
        if (($key = array_search($role, $this->role)) !== false)
            unset($this->role[$key]);

        return $this;
    }

    public function hasRole(string $role): bool {
        return in_array($role, $this->role);
    }

    public function emailValidated(): bool {
        return empty($this->vreg);
    }

    /**
     * @param string $pwd
     * @return bool
     */
    public function checkPwd(string $pwd): bool {
        return password_verify($pwd, $this->pwd);
    }

    /**
     * @throws UserNotFoundException
     */
    public static function getFromSession(): User {
        return self::loadBy("id", $_SESSION["USER"]);
    }

    public function isFollowee() {
        $con = Database::getPDO();
        $prepare = $con->prepare("select * from `follow` where follower = :follower and followee = :followee");
        $prepare->execute([
            "follower" => intval($_SESSION["USER"]),
            "followee" => intval(Route::getRouteParam())
        ]);
        return !empty($prepare->fetchObject());
    }

    public function follow() {
        $con = Database::getPDO();
        $followed = $this->isFollowee();
        if ($followed) {
            $prepare = $con->prepare("delete from `follow` where follower = :follower and followee = :followee");
        } else {
            $prepare = $con->prepare("insert into `follow` (follower, followee) value (:follower, :followee)");
        }
        $prepare->execute([
            "follower" => intval($_SESSION["USER"]),
            "followee" => intval(Route::getRouteParam())
        ]);
        return $followed;
    }

    /**
     * Getter Setter
     */

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPicture(): string {
        return $this->picture;
    }

    /**
     * @param string|null $picture
     * @return self
     */
    public function setPicture(?string $picture): self {
        $this->picture = $picture;
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
     * @return self
     */
    public function setUsername(string $username): self {
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
     * @return self
     */
    public function setDescription(string $description): self {
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
     * @return self
     */
    public function setEmail(string $email): self {
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
     * @return self
     */
    public function setPwd(string $pwd): self {
        $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getVreg(): string {
        return $this->vreg;
    }

    /**
     * @param string|null $vreg
     * @return self
     */
    public function setVreg(string $vreg = null): self {
        $this->vreg = $vreg;
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
     * @return string
     */
    public function getUpdatedAt(): string {
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
     * @return User
     */
    public function setDateOfBirth(?string $dateOfBirth): self {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }
}