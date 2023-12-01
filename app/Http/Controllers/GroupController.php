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
            'groups' => Group::all()
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

        return redirect('/groups');
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

        return redirect('/groups');
    }
}
