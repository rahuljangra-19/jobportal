 <header>
     <div class="container flex">
         <div class="col">
             @if (!Auth::check() || (auth()->check() && (auth()->user()->role == 'employee' || auth()->user()->role == 'company')))
                 <a href="{{ route('index') }}"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></a>
             @endif
             {{-- @can('admin')
                 <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/images/logo.png') }}" class="logo"></a>
             @endcan --}}
         </div>
         <div class="col">
             <ul class="menu">
                 @if (!Auth::check() || (auth()->check() && (auth()->user()->role == 'employee' || auth()->user()->role == 'company')))
                     <li class="{{ Route::currentRouteName() == 'index' ? 'active' : '' }}">
                         <a href="{{ route('index') }}">Home</a>
                     </li>
                 @endif

                 @guest
                     <li class="{{ Route::currentRouteName() == 'find.jobs' ? 'active' : '' }}"><a
                             href="{{ route('find.jobs') }}">Find a job</a></li>
                 @endguest

                 @can('employee')
                     <li class="{{ Route::currentRouteName() == 'find.jobs' ? 'active' : '' }}"><a
                             href="{{ route('find.jobs') }}">Find a job</a></li>
                 @endcan

                 @can('company')
                     <li class="{{ Route::currentRouteName() == 'find.candidates' ? 'active' : '' }}"><a
                             href="{{ route('find.candidates') }}">Find Candidate</a></li>
                     <li class="{{ Route::currentRouteName() == 'post.job' ? 'active' : '' }}"><a
                             href="{{ route('post.job') }}">Post a job</a></li>
                 @endcan
                 @if (!Auth::check() || (auth()->check() && (auth()->user()->role == 'employee' || auth()->user()->role == 'company')))
                     <li><a href="{{ route('contact') }}">contact</a></li>
                 @endif
             </ul>
         </div>

         <div class="col three">
             @guest
                 <a href="{{ route('login') }}" class="button-alt">Log In</a>
                 <a href="{{ route('register') }}" class="button">Register</a>
             @endguest
             @auth
                 <ul class="menu profile">
                     @php
                         // Check if the feature_image key exists and is not empty
                         $imagePath = isset(Auth::user()->image) ? env('IMAGE_PATH') . Auth::user()->image : null;
                     @endphp
                     <li>
                         <a href="#">
                             @if ($imagePath && File::exists(storage_path('app/' . Auth::user()->image)))
                                 <img src="{{ $imagePath }}" alt="" class="profile-pic">
                             @else
                                 <img src="{{ asset('assets/admin/images/faces/face1.jpg') }}" class="profile-pic">
                             @endif
                         </a>
                         <ul class="sub-menu profiles">
                             <li class="name">
                                 <h5>{{ Str::ucfirst(Auth::user()->user_name) }}</h5>
                             </li>
                             @if (Auth::user()->is_profile_completed)
                                 <li><a href="{{ route('settings') }}">Profile Setting</a></li>
                             @else
                                 <li><a href="{{ route('profile') }}">Profile complete</a></li>
                             @endif
                             @can('company')
                                 <li><a href="{{ route('my.job') }}">My Jobs</a></li>
                             @endcan
                             @can('employee')
                                 <li><a href="{{ route('applied.jobs') }}">Applied Jobs</a></li>
                             @endcan
                             <li> <a href="{{ route('logout') }}" onclick="return confirm('Are you sure?')">Logout</a></li>
                         </ul>
                     </li>
                 </ul>
             @endauth
         </div>
     </div>
 </header>
