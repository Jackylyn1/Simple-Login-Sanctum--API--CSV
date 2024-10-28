<?php
namespace App\Http\Contracts;
use Illuminate\Http\Request;

/**
 * Interface for handling file operations.
 *
 * Provides a method for uploading files to the server, including error handling.
 */
interface FileHandlerInterface
{
    /**
     * Upload a file to the server.
     *
     * Handles the file upload from the incoming request, storing it in the designated
     * location on the server. Returns a boolean indicating success or throws an exception
     * if the upload fails.
     *
     * @param \Illuminate\Http\Request $request The request containing the file to be uploaded.
     * @return bool True if the upload is successful.
     * @throws \Exception If the upload fails, an exception is thrown with an error message.
     */
    public function upload(Request $request): bool | \Exception;
}