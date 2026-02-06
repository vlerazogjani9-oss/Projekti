<?php

class Validator
{
    private $errors = []; // ENCAPSULATION OF THE ERRORS

    public function validateRegister($data) {
        $this->errors = [];
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $password_confirm = $data['password_confirm'] ?? '';

        if (strlen($name) < 2) {
            $this->errors['name'] = 'Emri duhet të jetë të paktën 2 karaktere.';
        }
        if (empty($email)) {
            $this->errors['email'] = 'Email është i detyrueshëm.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email i pavlefshëm.';
        }
        if (strlen($password) < 6) {
            $this->errors['password'] = 'Fjalëkalimi duhet të jetë të paktën 6 karaktere.';
        }
        if ($password !== $password_confirm) {
            $this->errors['password_confirm'] = 'Fjalëkalimet nuk përputhen.';
        }
        return empty($this->errors);
    }

    public function validateLogin($data) {
        $this->errors = [];
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if (empty($email)) {
            $this->errors['email'] = 'Email është i detyrueshëm.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email i pavlefshëm.';
        }
        if (empty($password)) {
            $this->errors['password'] = 'Fjalëkalimi është i detyrueshëm.';
        }
        return empty($this->errors);
    }

    public function validateContact($data) {
        $this->errors = [];
        $name = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        $message = trim($data['message'] ?? '');

        if (strlen($name) < 2) {
            $this->errors['name'] = 'Emri duhet të jetë të paktën 2 karaktere.';
        }
        if (empty($email)) {
            $this->errors['email'] = 'Email është i detyrueshëm.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email i pavlefshëm.';
        }
        if (strlen($message) < 10) {
            $this->errors['message'] = 'Mesazhi duhet të jetë të paktën 10 karaktere.';
        }
        return empty($this->errors);
    }

    public function validateNewsProduct($data, $requireFile = false) {
        $this->errors = [];
        $title = trim($data['title'] ?? '');
        $body = trim($data['body'] ?? $data['description'] ?? '');

        if (strlen($title) < 1) {
            $this->errors['title'] = 'Titulli është i detyrueshëm.';
        }
        if (strlen($body) < 1) {
            $this->errors['body'] = 'Përmbajtja është e detyrueshme.';
        }
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getFirstError() {
        return empty($this->errors) ? '' : reset($this->errors);
    }
}
