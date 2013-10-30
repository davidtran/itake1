<?php

class ApiUserIdentity extends CUserIdentity {

    protected $userId;

    public function __construct(User $user) {
        $this->username = $user->email;
        $this->userId = $user->id;
    }

    public function getId() {
        return $this->userId;
    }

}
