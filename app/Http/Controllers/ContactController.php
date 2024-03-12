<?php

namespace App\Http\Controllers;

use App\Rules\Phone;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Group $group, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => [
                'required',
                new Phone(),
                'unique:contacts,phone_number,NULL,id,group_id,'.$group->id,
            ],
        ], [
            'phone_number.required' => 'The phone number is required.',
            'phone_number.phone' => 'is not a valid ugandan phone number',
            'phone_number.unique' => 'The phone number has already been taken in this group.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(
                'error', $validator->errors()->first()
            );
        }

        $validatedData = $validator->validated();
        $validatedData['user_id'] = auth()->id();

        $group->contacts()->create($validatedData);

        return to_route('groups.show', $group->id)
            ->with('success', 'Contact added successfully');
    }
}
