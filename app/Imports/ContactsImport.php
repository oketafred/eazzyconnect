<?php

namespace App\Imports;

use App\Models\Contact;
use App\Rules\Phone;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ContactsImport implements
    ToCollection, WithHeadingRow, WithValidation
{
    public function __construct(
        public int $user_id,
        public int $group_id
    )
    {
    }

    public function collection(Collection $collection): void
    {
        foreach ($collection as $row)
        {
            try {
                Contact::query()->create([
                    'user_id' => $this->user_id,
                    'group_id' => $this->group_id,
                    'phone_number' => $row['phone_number'],
                ]);
            } catch (Exception $exception) {
                Log::info($exception->getMessage());
            }
        }
    }


    public function rules(): array
    {
        return [
            'phone_number' => [
                'required',
                new Phone(),
                'unique:contacts,phone_number,NULL,id,group_id,' . $this->group_id,
            ],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $phoneNumber = $phoneUtil->parse($data['phone_number'], "UG");
            $formattedPhoneNumber = $phoneUtil->format($phoneNumber, PhoneNumberFormat::E164);
            $data['phone_number'] = $formattedPhoneNumber;
        } catch (NumberParseException $exception) {
            Log::error($exception);
        }
        return $data;
    }
}
