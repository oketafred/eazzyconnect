<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Group;
use App\Rules\Phone;
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
                'unique:contacts,phone_number,NULL,id,group_id,' . $group->id,
            ]
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
