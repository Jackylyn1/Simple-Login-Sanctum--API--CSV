@include('skeletonhead')
<h2 class="text-2xl font-semibold mb-4">Please login</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium">E-Mail</label>
        <input type="email" name="email" id="email" required class="mt1 block w-full border-grey-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-grey-800 dark:text-white dark:focus:border-indigo-500 dark:focus:ring-indigo-500">    
    </div>
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Password</label>
        <input type="password" name="password" id="password" required class="mt-1 block w-full border-grex-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-500 dark:focus:ring-indigo-500">
    </div>
    <div>
        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-600">Login</button>
    </div>
</form>
@include('skeletonbottom')