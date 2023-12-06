<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Group;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Validators\ValidationException;

class ContactImportController extends Controller
{
    public function index(Group $group): Response
    {
        return Inertia::render('Contacts/Imports/Index', [
            'group' => $group,
            'contactCount' => $group->contacts()->count()
        ]);
    }

    public function store(Group $group, Request $request)
    {
        try {
            $file = $request->file('file');
            $filename = mt_rand() . $file->getClientOriginalName();
            $filepath = $file->storeAs('imports', $filename);

            Excel::import(
                new ContactsImport(Auth::id(), $group->id),
                $filepath,
                'local',
                \Maatwebsite\Excel\Excel::CSV
            );

            Storage::disk('local')->delete($filepath);
        } catch (ValidationException $exception) {
            return redirect()->back()->with('error', json_encode($exception->failures()));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('groups.show', $group->id)
            ->with('success', 'Contacts imported successfully');
    }
}