<?php

namespace Core\Http\Traits;

/**
 * Request Validator
 *
 * TODO:
 * 1. use SESSION not error()
 * 2. improve variable/function names
 * 3. refactor
 */
trait Validator
{

    protected $input;

    public function validate(array $data)
    {
        foreach ($data as $field => $rules) {

            $this->input = $field;
            $field = request($field);
            $total_rules = count($rules);
            for ($i = 0; $i < $total_rules; $i++) {
                if (!str_contains($rules[$i], ':')) {
                    $rules[$i] = "{$rules[$i]}:";
                }

                [$rule, $parameter] = explode(':', $rules[$i]);
                if (!$this->$rule($field, $parameter)) {

                }
            }
        }

        return $this;
    }

    protected function required($request)
    {
        if (empty($request)) {
            error("{$this->input} is required.");
        }
    }

    protected function min($request, $value)
    {
        if (strlen($request) < $value) {
            error("{$this->input} is too short.");
        }
    }

    protected function max($request, $value)
    {
        if (strlen($request) > $value) {
            error("{$this->input} is too long.");
        }
    }

    protected function email($request)
    {
        if (!filter_var($request, FILTER_VALIDATE_EMAIL)
            || !preg_match('/^[a-zA-Z0-9@.]*$/', $request)) {
            error("invalid email format");
        }
    }
}
