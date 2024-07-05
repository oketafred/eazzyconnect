<?php

namespace App\Imports;

use Exception;
use App\Rules\Phone;
use App\Models\Contact;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContactsImport implements ToCollection, WithHeadingRow, WithValidation
{
    private PhoneNumberUtil $phoneUtil;

    public function __construct(
        public int $user_id,
        public int $group_id,
        $phoneUtil = null
    ) {
        $this->phoneUtil = $phoneUtil ?: PhoneNumberUtil::getInstance();
    }

    public function collection(Collection $collection): void
    {
        foreach ($collection as $row) {
            try {
                Contact::query()->create([
                    'user_id' => $this->user_id,
                    'group_id' => $this->group_id,
                    'phone_number' => $row['phone_number'],
                ]);
            } catch (Exception $exception) {
                Log::error("Failed to import contact: {$exception->getMessage()}");
            }
        }
    }

    public function rules(): array
    {
        return [
            'phone_number' => [
                'required',
                new Phone(),
                'unique:contacts,phone_number,NULL,id,group_id,'.$this->group_id,
            ],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        try {
            $phoneNumber = $this->phoneUtil->parse($data['phone_number'], 'UG');
            $formattedPhoneNumber = $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::E164);
            $data['phone_number'] = $formattedPhoneNumber;
        } catch (NumberParseException $exception) {
            Log::error($exception);
        }

        return $data;
    }
}
