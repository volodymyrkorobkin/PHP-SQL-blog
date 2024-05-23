<?php


class Post {
    private $id;
    private $userId;
    private $title;
    private $description;
    private $content;
    private $createdOn;
    private $updatedOn;

    public function __construct($id, $userId, $title, $description, $content, $createdOn, $updatedOn) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->createdOn = $createdOn;
        $this->updatedOn = $updatedOn;
    }

    public function getId() {
        return $this->id;
    }


    private function editTitle($title) {
        // TODO: validate title
        // if invalid, throw exception
        // otherwise, return true
        $this->title = $title;
        return true;
    }

    private function editDescription($description) {
        $this->description = $description;
        return true;
    }

    private function editContent($content) {
        $this->content = $content;
        return true;
    }


    public function edit($title = null, $description = null, $content = null) {
        if ($title) {
            $this->title = $title;
        }
        if ($description) {
            $this->description = $description;
        }
        if ($content) {
            $this->content = $content;
        }
    }
}