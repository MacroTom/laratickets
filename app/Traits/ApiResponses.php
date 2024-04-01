<?php

namespace App\Traits;

trait ApiResponse
{

    protected function respond(int $code, string $message, array $data = [], array $errors = [])
    {
        $returnable['message'] = $message;
        if (count($data) > 0) $returnable['data'] = $data;
        if (count($errors) > 0) $returnable['errors'] = $errors;
        return response($returnable, $code);
    }

    public function notFound($message = "Resource not found!", $errors = [])
    {
        return $this->respond(404, $message, errors: $errors);
    }

    public function serverError($message = "An unexpected error occured!", $errors = [])
    {
        return $this->respond(500, $message, errors: $errors);
    }

    public function unauthenticated($message = 'Unauthenticated')
    {
        return $this->respond(401, $message);
    }

    public function success(string $message = 'success', array $data = [])
    {
        return $this->respond(200, $message, data: $data);
    }

    public function error(string $message = 'Oops! an error occurred.', array $errors = [])
    {
        return $this->respond(400, $message, errors: $errors);
    }

    public function custom(int $code = 422, string $message = '', array $data = [], array $errors = [])
    {
        return $this->respond($code,$message,$data,$errors);
    }
}
