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
    public function validate(array $data)
    {
        foreach ($data as $field => $rules) {
            $field = request($field);
            $total_rules = count($rules);

            for ($i = 0; $i < $total_rules; $i++) {
                if (!str_contains($rules[$i], ':')) {
                    $rules[$i] = "{$rules[$i]}:";
                }

                [$rule, $parameter] = explode(':', $rules[$i]);
                $this->$rule($field, $parameter);
            }
        }

        return $this;
    }

    protected function required($request)
    {
        if (!isset($request)) {
            error("{$request} is required.");
        }
    }

    protected function min($request, $value)
    {
        if (strlen($request) < $value) {
            error("{$request} is too short.");
        }
    }

    protected function max($request, $value)
    {
        if (strlen($request) > $value) {
            error("{$request} is too long.");
        }
    }

    protected function email($request)
    {
        if (!filter_var($request, FILTER_VALIDATE_EMAIL)
            || !preg_match('/^[a-zA-Z0-9@.]*$/', $request)) {
            error("invalid email");
        }
    }
}
