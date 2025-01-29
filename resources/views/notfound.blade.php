<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 flex items-center justify-center h-screen m-0">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-indigo-600">404</h1>
        <p class="text-2xl mt-4 text-gray-700">Oops! The page you are looking for does not exist.</p>
        <p class="mt-4">
            <a href="{{ route('login') }}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-bold py-2 px-4 rounded-lg transition-colors">
                Go back to Home
            </a>
        </p>
    </div>
</body>

</html>