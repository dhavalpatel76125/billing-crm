<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="w-full h-screen flex justify-center items-center">
        <div class="w-full max-w-md bg-white p-8 shadow-md rounded-md">
            <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>

            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-sm text-red-500">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    @error('email') border-red-500 @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 
                    @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full py-3 mt-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
