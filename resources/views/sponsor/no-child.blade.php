{{-- resources/views/sponsor/no-child.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Child Assigned | Sponsor Dashboard</title>
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

<div class="max-w-md w-full text-center">
    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-child text-orange-400 text-4xl"></i>
    </div>
    <h1 class="text-2xl font-black text-gray-800 mb-3">Welcome, {{ $sponsor->first_name }}!</h1>
    <p class="text-gray-600 mb-6">
        Your account is active, but you don't have a child assigned yet. Please contact us to complete your sponsorship.
    </p>
    <a href="mailto:sponsors@hopeimpact.org"
       class="inline-block px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-lg transition">
        <i class="fas fa-envelope mr-2"></i>Contact Us
    </a>
    <form method="POST" action="{{ route('sponsor.logout') }}" class="mt-6">
        @csrf
        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
            <i class="fas fa-sign-out-alt mr-1"></i>Logout
        </button>
    </form>
</div>

</body>
</html>
