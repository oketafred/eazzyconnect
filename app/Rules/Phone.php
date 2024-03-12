<?php

namespace App\Rules;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            return $phoneUtil->isValidNumber(
                $phoneUtil->parse($value, 'UG')
            );
        } catch (NumberParseException $exception) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute is not a valid ugandan phone number.';
    }
}
