<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Two-Factor Authentication</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Two-Factor Authentication</h2>
      @error('code')
      <div id="error-message" class="mb-4 p-4 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg">
        {{ $message }}
      </div>
      @enderror
      <form id="codeForm" class="space-y-4" method="POST" action="{{ route('2fa.verify', ['id' => $id]) }}">
        @csrf
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Authentication Code</label>
          <input
            name="code"
            type="number"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
            placeholder="Enter 6-digit code"
            required
            oninput="if(this.value.length > 6) this.value = this.value.slice(0, 6);"
            />
        </div>

        <button id="sendCode" type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors">
          Verify
        </button>
      </form>

      <div class="mt-6 text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Back to login</a>
      </div>
    </div>
  </div>

  <script>
        document.getElementById('codeForm').addEventListener('submit', function(event) {
            var sendCodeButton = document.getElementById('sendCode');
            sendCodeButton.disabled = true;
            sendCodeButton.innerHTML = 'Sending Code...';

            setTimeout(function() {
                signUpButton.disabled = false;
                signUpButton.innerText = 'Verify';
            }, 4000);
        });
  </script>
</body>

</html>