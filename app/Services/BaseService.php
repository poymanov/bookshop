<?php

namespace App\Services;

use Validator;
use Illuminate\Http\Request;

class BaseService
{
    const VALIDATION_RULES = [];

    /**
     * @param Request $request
     * @return array
     */
    public function validateJsonRequest(Request $request)
    {
        $validator = Validator::make($request->all(), static::VALIDATION_RULES);

        if ($validator->fails()) {
            $message = 'Validation failed';
            $errorData = $this->getFailedValidationData($message, $validator->errors());

            return [false, $errorData];
        }

        return [true, $validator->getData()];
    }

    /**
     * @return array
     */
    public function deletedResponseData()
    {
        $message = 'Successfully deleted';

        return $this->createJsonResponseData($message);
    }

    /**
     * @param $instance
     * @param $routeName
     * @return array
     */
    public function createdResponseDataBase($instance, $routeName)
    {
        $message = 'Successfully created';

        $data = $this->createJsonResponseData($message);
        $data['data']['url'] = route($routeName, $instance);

        return $data;
    }

    /**
     * @param $instance
     * @param $routeName
     * @return array
     */
    public function updatedResponseDataBase($instance, $routeName)
    {
        $message = 'Successfully updated';

        $data = $this->createJsonResponseData($message);
        $data['data']['url'] = route($routeName, $instance);

        return $data;
    }

    /**
     * @param $errors
     * @return array
     */
    protected function getFailedValidationData($message, $errors)
    {
        $data = $this->createJsonResponseData($message);
        $data['data']['errors'] = $errors;

        return $data;
    }

    /**
     * @param $message
     * @return array
     */
    protected function createJsonResponseData($message)
    {
        return [
            'data' => [
                'message' => $message,
            ]
        ];
    }
}
