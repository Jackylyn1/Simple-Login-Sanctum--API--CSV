<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Response;
class APICSVImportController extends BaseController
{
    /** 
     * upload CSV
     * 
     * @param Request $request;
     * @return \Illuminate\Http\Response | \Illuminate\Http\JsonResponse
    */
    public function upload(Request $request): Response | JsonResponse {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        try {
            $spreadsheet = IOFactory::load($request->file('csv_file')->getPathname());
            $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $headers = array_shift($data);
            foreach ($data as $csvrow) {
                $mappedData = array_combine($headers, $csvrow);
                $email = strtolower(trim($mappedData['email']??''));
                Contact::updateOrCreate(['email' => $email], [
                    'company_name' => $mappedData['companyname'] ?? '',
                    'first_name'   => $mappedData['firstname'] ?? '',
                    'last_name'    => $mappedData['lastname'] ?? '',
                    'phone_number' => $mappedData['phonenumber'] ?? '',
                ]);
            }
            return $this->sendResponse('CSV imported successfully.',[]);
        } catch (\Exception $e) {
            return $this->sendError('Error importing CSV: ' . $e->getMessage());
        }
    }   
}
