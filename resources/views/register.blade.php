<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign Up</h2>
            @if (session('error'))
            <div id="error-message" class="mb-4 p-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            <form id="registerForm" class="space-y-4" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="Your Name" value="{{old('name')}}"
                        required
                        maxlength="30" />
                    @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="your@email.com" value="{{old('email')}}"
                        required
                        maxlength="255" />

                    @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="••••••••"
                        required
                        minlength="8"
                        maxlength="255" />
                    @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="••••••••"
                        required
                        minlength="8"
                        maxlength="255" />
                </div>

                <div class="flex justify-center">
                    <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                </div>
                @error('g-recaptcha-response')
                <p class="text-sm text-red-600 mt-1 text-center">{{ $message }}</p>
                @enderror

                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors" type="submit" id="signUpButton">
                    Sign Up
                </button>
            </form>

            <div class=" mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var signUpButton = document.getElementById('signUpButton');
            signUpButton.disabled = true;
            signUpButton.innerHTML = 'Signing Up...';

            setTimeout(function() {
                signUpButton.disabled = false;
                signUpButton.innerText = 'Sign Up';
            }, 4000);
        });
    </script>

</body>

</html>