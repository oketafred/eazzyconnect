<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Group;
use Inertia\Response;
use Illuminate\Support\Facades\Log;
use App\Services\ContactImportService;
use App\Http\Requests\ImportContactRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class ContactImportController extends Controller
{
    public function __construct(protected ContactImportService $contactImportService)
    {
    }

    public function index(Group $group): Response
    {
        return Inertia::render('Contacts/Imports/Index', [
            'group' => $group,
            'contactCount' => $group->contacts()->count(),
        ]);
    }

    public function store(ImportContactRequest $request, Group $group)
    {
        try {
            $this->contactImportService->import($request->file('file'), $group->id);
        } catch (ValidationException $exception) {
            return redirect()->back()->with('import_error', json_encode($exception->failures()));
        } catch (\Exception $exception) {
            Log::error($exception);

            return redirect()->back()
                ->with('error', 'Something when wrong. Please try again later.');
        }

        return redirect()->route('groups.show', $group->id)
            ->with('success', 'Contacts imported successfully');
    }
}
