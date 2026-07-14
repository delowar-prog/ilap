@extends('layouts.frontend_master')

@section('web_contents')
<!-- Main Wrapper: Full screen, centered content, strict white background -->
  <div class="min-h-screen bg-white flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 font-sans">
    
    <!-- Central Split Card Container -->
    <div class="w-full max-w-4xl bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col md:flex-row min-h-[500px]">
      
      <!-- Left Column: Image/Illustration Section -->
      <div class="w-full md:w-1/2 bg-slate-50 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-gray-100">
        <!-- Replace the src with your actual iLAP branding asset or illustration -->
        <img 
          src="https://i.pinimg.com/736x/03/81/75/038175e217e62658bc236f9a6e817e2f.jpg" 
          alt="iLAP Portal Illustration" 
          class="w-full h-auto  object-contain mix-blend-multiply"
        />
      </div>

      <!-- Right Column: Welcome Content & Actions Section -->
      <div class="w-full md:w-1/2 flex flex-col justify-center p-8 sm:p-12">
        <!-- Tagline / Badge -->
        <div class="mb-4">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
            International Student Portal
          </span>
        </div>

        <!-- System Branding & Welcome Message -->
        <div class="space-y-3 mb-8">
          <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
            Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">iLAP</span>
          </h1>
          <p class="text-base text-slate-500 leading-relaxed">
            Your centralized portal for global admissions, multi-campus management, and automated verification. Connect with your future today.
          </p>
        </div>

        <!-- Action CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 w-full">
          <!-- Login Button -->
            <a href="{{ route('login') }}">
            <button 
            type="button"
            class="flex-1 inline-flex justify-center items-center px-5 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm"
          >
            Sign In to Account
          </button>
            </a>
          
          <!-- Register Button -->
          <a href="{{ route('register') }}">
            <button 
            type="button"
            class="flex-1 inline-flex justify-center items-center px-5 py-3 border border-gray-200 text-sm font-semibold rounded-xl text-slate-700 bg-white hover:bg-slate-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
          >
           Student Registration
          </button>
          </a>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 border-t border-gray-100 pt-4 text-center md:text-left">
          <p class="text-xs text-slate-400">
            &copy; 2026 iLAP System. Secure Multi-Campus Network.
          </p>
        </div>
      </div>

    </div>
  </div>

@endsection