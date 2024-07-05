<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Group;
use Inertia\Response;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
{
    public const PER_PAGE = 20;

    public function index(): Response
    {
        return Inertia::render('Groups/Index', [
            'groups' => Group::query()
                ->orderByDesc('id')
                ->paginate(self::PER_PAGE)
                ->withQueryString()
                ->through(fn ($contact) => [
                    'id' => $contact->id,
                    'createdAt' => $contact->created_at->diffForHumans(),
                    'title' => $contact->title,
                    'description' => $contact->description,
                ]),
        ]);
    }

    public function create()
    {
        return inertia('Groups/Create');
    }

    public function store(StoreGroupRequest $request)
    {
        $validated = $request->validated();
        $request->user()->groups()->create($validated);

        return redirect('/groups')
            ->with('success', 'Group created successfully');
    }

    public function show(Group $group)
    {
        return inertia('Groups/Show', [
            'group' => $group,
            'contacts' => $group->contacts()
                ->paginate(self::PER_PAGE)
                ->withQueryString()
                ->through(fn ($contact) => [
                    'id' => $contact->id,
                    'createdAt' => $contact->created_at->diffForHumans(),
                    'phoneNumber' => $contact->phone_number,
                ]),
            'contactCount' => $group->contacts()->count(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        return inertia('Groups/Edit', [
            'group' => $group,
        ]);
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $validated = $request->validated();
        $group->update($validated);

        return redirect('/groups')
            ->with('success', 'Group updated successfully');
    }
}
