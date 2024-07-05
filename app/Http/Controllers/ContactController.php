<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreContactRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContactController extends Controller
{
    public function template(): BinaryFileResponse
    {
        $path = public_path('ContactsTemplate.csv');
        return response()->download($path);
    }

    public function store(StoreContactRequest $request, Group $group): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        $group->contacts()->create($validatedData);

        return to_route('groups.show', $group->id)
            ->with('success', 'Contact added successfully');
    }
}
