<?php


namespace App\Common;

trait ApiResponser
{
    protected function success(int $code = 200, $data = null, $message = 'Success')
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function created($data = null, $message = 'Resource Created')
    {
        return $this->success(201, $data, $message);
    }

    protected function updated($data = null, $message = 'Resource Updated')
    {
        return $this->success(200, $data, $message);
    }

    protected function deleted($message = 'Resource Deleted')
    {
        return $this->success(200, null, $message);
    }

    protected function notFound($message = 'Resource Not Found')
    {
        return $this->error(404, null, $message);
    }

    protected function validationError($errors, $message = 'Validation Error')
    {
        return $this->error(422, ['validation_errors' => $errors], $message);
     
    }

}
