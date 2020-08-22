<?php

namespace common\models\web;

class Response
{

    private $success = false;
    private $message = null;
    private $data = null;

    /**
     * Merge model errors into data -> errors
     * @param $model
     * @param string $message
     */
    public function merge($model, $message = 'validate')
    {
        if ($model) {
            if ($model->getErrors()) {
                if (!isset($this->data['errors'])) {
                    $this->data['errors'] = [];
                }

                foreach ($model->getErrors() as $key => $errors) {
                    if (!isset($this->data['errors'][$key])) {
                        $this->data['errors'][$key] = [];
                    }

                    foreach ($errors as $error) {
                        $this->data['errors'][$key][] = $error;
                    }
                }

                if ($message) {
                    $this->message = $message;
                }
            }
        }
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        return ($this->success === true);
    }

    /**
     * @param $value
     */
    public function setSuccess($value)
    {
        $this->success = $value;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $value
     */
    public function setMessage($value)
    {
        $this->message = $value;
    }

    /**
     * @return array mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $value
     */
    public function setData($value)
    {
        $this->data = $value;
    }

    /**
     * Get a value from data attribute
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getDataValue($key, $default = null)
    {
        if (is_array($this->data) && isset($this->data[$key])) {
            return $this->data[$key];
        }

        return $default;
    }

    /**
     * Set error list overriding current possible errors
     * @param $value
     */
    public function setDataErrors($value)
    {
        $this->data['errors'] = $value;
    }

    /**
     * Clear data attribute
     */
    public function clearData()
    {
        $this->data = [];
    }

    /**
     * Clear all attributes
     */
    public function clear()
    {
        $this->success = false;
        $this->message = null;
        $this->data = null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @param string $error
     */
    public function addDataError($key, $error)
    {
        if (!isset($this->data['errors'])) {
            $this->data['errors'] = [];
        }

        if (!isset($this->data['errors'][$key])) {
            $this->data['errors'][$key] = [];
        }

        $this->data['errors'][$key][] = $error;
    }

    /**
     * Encode to JSON
     * @return string
     */
    public function __toString()
    {
        return json_encode([
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ]);
    }

}