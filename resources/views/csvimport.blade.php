@include('skeletonhead')
<h2 class="text-2xl font-semibold mb-4">Import CSV File</h2>
<form method="POST" action="{{ route('import.csv.upload') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="csv_file" class="block text-sm font-medium">Upload CSV File</label>
        <input type="file" name="csv_file" id="csv_file" accept=".csv" required class="mt-1 block w-full border-grey-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-grey-800 dark:text-white dark:focus:border-indigo-500 dark:focus:ring-indigo-500">
    </div>
    <div>
        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-600">
            Import
        </button>
    </div>
</form>            
@include('skeletonbottom')