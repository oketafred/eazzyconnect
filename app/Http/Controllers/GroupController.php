<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class GroupController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Groups/Index', [
            'groups' => Group::query()
                ->orderByDesc('id')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return inertia('Groups/Create');
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $request->user()->groups()->create($validated);

        return redirect('/groups')
            ->with('success', 'Group created successfully');
    }

    public function show(Group $group)
    {
        return inertia('Groups/Show', [
            'group' => $group,
            'contacts' => $group->contacts()
                ->paginate(20)
                ->withQueryString()
                ->through(fn($contact) => [
                    'id' => $contact->id,
                    'createdAt' => $contact->created_at,
                    'phoneNumber' => $contact->phone_number,
                ]),
            'contactCount' => $group->contacts()->count()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return inertia('Groups/Edit', [
            'group' => $group
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $validated = $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $group->update($validated);

        return redirect('/groups')
            ->with('success', 'Group updated successfully');
    }
}
