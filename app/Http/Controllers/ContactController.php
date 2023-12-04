<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Group $group, Request $request)
    {
        $validated = $this->validate($request, [
           'phone_number' => 'string|max:255'
        ]);

        $validated['user_id'] = Auth::id();

        $group->contacts()->create($validated);

        return to_route('groups.show', $group->id);
    }
}
