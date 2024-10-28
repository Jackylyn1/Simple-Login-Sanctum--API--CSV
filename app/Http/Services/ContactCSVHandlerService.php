<?php
namespace App\Http\Services;
use App\Http\Contracts\FileHandlerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Contact;

/**
 * Service for handling CSV file uploads and processing contact data.
 *
 * This service implements the FileHandlerInterface and provides functionality
 * to upload and parse CSV files, mapping data to the `Contact` model.
 */
class ContactCSVHandlerService implements FileHandlerInterface 
{
    /**
     * Uploads and processes a CSV file from the incoming request.
     *
     * This method reads the uploaded CSV file, extracts header information, 
     * and maps each row's data to corresponding fields in the `Contact` model.
     * If a contact with the same email exists, it updates the record; otherwise, 
     * it creates a new one.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the CSV file.
     * @return bool|\Exception Returns true on successful upload and data processing,
     *                         or returns the exception if an error occurs.
     */
    public function upload(\Illuminate\Http\Request $request): bool | \Exception
    {
        try {
            $spreadsheet = IOFactory::load($request->file('csv_file')->getPathname());
            $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $headers = array_shift($data);

            foreach ($data as $csvrow) {
                $mappedData = array_combine($headers, $csvrow);
                $email = strtolower(trim($mappedData['email'] ?? ''));
                
                Contact::updateOrCreate(
                    ['email' => $email],
                    [
                        'company_name' => $mappedData['companyname'] ?? '',
                        'first_name'   => $mappedData['firstname'] ?? '',
                        'last_name'    => $mappedData['lastname'] ?? '',
                        'phone_number' => $mappedData['phonenumber'] ?? '',
                    ]
                );
            }
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}