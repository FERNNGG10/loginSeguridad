<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign In</h2>
      @if (session('success'))
        <div id="success-message" class="mb-4 p-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded-lg">
          {{ session('success') }}
        </div>
      @endif
      @if (session('error'))
        <div id="error-message" class="mb-4 p-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg">
            {{ session('error') }}
        </div>
      @endif
      <form id="loginForm" class="space-y-4" method="POST" action="{{ route('login.post') }}">
        @csrf
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            name="email"
            type="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            placeholder="your@email.com" />
            @error('email')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input
            name="password"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            placeholder="••••••••" />
            @error('password')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-center">
          <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
        </div>
        @error('g-recaptcha-response')
          <p class="text-sm text-red-600 mt-1 text-center">{{ $message }}</p>
        @enderror

        <button id="loginButton" type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
          Sign In
        </button>
      </form>

      <div class="mt-6 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="{{route('register')}}" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign up</a>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        var loginButton = document.getElementById('loginButton');
        loginButton.disabled = true;
        loginButton.innerHTML = 'Signing In...';
    });
  </script>

</body>

</html>