@extends('layouts.frontend_master')

@section('web_contents')
<!-- Main Wrapper: Full screen, centered content, strict white background -->
  <div class="min-h-screen bg-white flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 font-sans">
    
    <!-- Central Split Card Container -->
    <div class="w-full max-w-4xl bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col md:flex-row min-h-[500px]">
      
      <!-- Left Column: Image/Illustration Section -->
      <div class="w-full md:w-1/2 bg-slate-50 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-gray-100">
        <img 
          src="https://i.pinimg.com/736x/03/81/75/038175e217e62658bc236f9a6e817e2f.jpg" 
          alt="iLAP Portal Illustration" 
          class="w-full h-auto object-contain mix-blend-multiply"
        />
      </div>

      <!-- Right Column: Login Form -->
      <div class="w-full md:w-1/2 flex flex-col justify-center p-8 sm:p-12">
        <div class="mb-8 text-center md:text-left">
          <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
            Sign In
          </h1>
          <p class="text-base text-slate-500 mt-2 leading-relaxed">
            Welcome back! Please enter your details.
          </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                <div class="mt-1">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors @error('email') border-red-500 @enderror">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <div class="mt-1">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors @error('password') border-red-500 @enderror">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-700 cursor-pointer">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Log in
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">Register here</a>
        </div>
      </div>
    </div>
  </div>
@endsection
