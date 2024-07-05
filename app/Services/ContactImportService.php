<?php

namespace App\Services;

use App\Imports\ContactsImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Validators\ValidationException;

class ContactImportService
{
    public function import($file, $groupId)
    {
        $filename = mt_rand() . $file->getClientOriginalName();
        $filepath = $file->storeAs('imports', $filename);

        try {
            Excel::import(new ContactsImport(Auth::id(), $groupId), $filepath, 'local', \Maatwebsite\Excel\Excel::CSV);
            Storage::disk('local')->delete($filepath);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new \Exception('Something went wrong. Please try again later.', 0, $exception);
        }
    }
}
