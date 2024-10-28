<?php
namespace App\Http\Services;
use App\Http\Contracts\FileHandlerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Contact;

class ContactCSVHandlerService implements FileHandlerInterface {

    public function upload(\Illuminate\Http\Request $request): bool | \Exception{
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
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}