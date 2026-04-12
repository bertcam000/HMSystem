<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <wireui:scripts />
    @livewireStyles
    
</head>

<body class="flex transition-all ease-linear duration-300 bg-[#f8fcfc]"  x-data="{sb:false, sb2:true}">

    <button class="z-30 block lg:hidden fixed top-4 left-0 pl-3" href="" @click="sb = true" x-show="!sb"><x-icon name="bars-3" /></button>
    {{-- <button class="z-10 fixed top-16 -left-2 h-10 pl-3 bg-gray-900 rounded-full" href="" @click="sb2 = true" x-show="!sb2">></button> --}}

    {{-- MOBILE SIDEBAR --}}
    <div class="fixed z-30 bg-gray-900 h-screen text-white w-72 md:static lg:hidden overflow-y-scroll" x-show="sb"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-72"
        x-transition:enter-end="translate-x-0" 
        x-transition:leave="transition ease-in duration-300 "
        x-transition:leave-start="translate-x-0" 
        x-transition:leave-end="-translate-x-72" 
        x-cloak>
        <div class="  relative text-center ">
            <div class="py-4  flex items-center pl-4 gap-3">
                <img src="{{ asset('images/bcplogo2.png') }}" width="70px" alt="" class="rounded-full">
                <div class="text-3xl font-bold">HMS</div>
            </div>
            <button class="absolute top-0 right-0" href="" @click="sb = false"><x-icon name="x-circle" /></button>
        </div>
        <div class=" pl-6 mt-4 text-[11px] text-[gray]">MAIN MENU</div>
        {{-- <hr class=" h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" /> --}}
        <div class="mt-4 px-4  grid gap-3">
             @can('view-page')
            <div class="flex justify-between items-center px-3 py-3 rounded-md hover:bg-gray-800">
                <a href="/dashboard" class="flex items-center gap-1">
                    <x-icon name="squares-2x2" />
                    Dashboard
                </a>
                <div>Sign</div>
            </div>
            @endcan
            <div class=" px-3 py-3 rounded-md hover:bg-gray-800" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center">
                    <a wire:navigate href="/bookings" @click="dropdown1=true" @click.away="dropdown1=false" class="flex items-center gap-1">
                        <x-icon name="users" />
                        Bookings
                    </a>
                    
                </div>
                
            </div>
            <div class=" px-3 py-3 rounded-md hover:bg-gray-800" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center">
                    <a wire:navigate href="/rooms" @click="dropdown1=true" @click.away="dropdown1=false" class="flex items-center gap-1">
                        <x-icon name="user-group" />
                        rooms
                    </a>
                    
                    <div class="rounded-full bg-red-500 px-2">5</div>
                </div>
            </div>
            
            <div class=" px-3 py-3 rounded-md hover:bg-gray-800" x-data="{dropdown2:false}">
                <div class="flex justify-between items-center">
                    <a href="/guests" class="flex items-center gap-1">
                        <x-icon name="document-arrow-up" />
                        Guest
                    </a>
                </div>
              
            </div>
            <div class=" px-3 py-3 rounded-md hover:bg-gray-800" x-data="{dropdown2:false}">
                <div class="flex justify-between items-center">
                    <a href="/housekeeping" class="flex items-center gap-1">
                        <x-icon name="document-arrow-up" />
                        Housekeeping
                    </a>
                </div>
              
            </div>
            <div class=" px-3 py-3 rounded-md hover:bg-gray-800" x-data="{dropdown2:false}">
                @can('view-page')
                <div class="flex justify-between items-center">
                    <a href="/invoices" class="flex items-center gap-1">
                        <x-icon name="document-arrow-up" />
                        Invoices
                    </a>
                </div>
                @endcan
              
            </div>
            <div class="px-3 py-3 rounded-md hover:bg-gray-800">
                <div class="flex items-center gap-1">
                    <x-icon name="rectangle-stack" />
                    Housekeeping
                </div>
            </div>

            
            <div class="px-3 py-3 rounded-md hover:bg-gray-800">
                <div>Logout</div>
            </div>
        </div>

    </div>
    {{-- MOBILE SIDEBAR --}}

    {{-- LARGE SCREEN SIDEBAR --}}
    <div  :class="!sb2 ? 'w-0' : 'w-72'" class="fixed transition-all duration-300 z-10 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 h-screen text-gray-300 font-semibold hidden lg:block md:static overflow-y-scroll relative" 
        
    >
        <div class="border-b-[1px] border-gray-700  relative text-center ">
            <div class="py-4  flex items-center pl-3 gap-3">
                <img src="{{ asset('images/bcplogo2.png') }}" width="50px" alt="" class="">
                <div class="text-xl font-semibold font-sans">LaNuevoHotel</div>
            {{-- <button class="absolute top-0 right-5" href="" @click="sb2 = false">x</button> --}}

            </div>
        </div>
        {{-- <div class=" pl-6 mt-4 text-[11px] text-[gray]">MAIN MENU</div> --}}
        {{-- <hr class=" h-0.5 border-t-0 bg-neutral-100 dark:bg-white/10" /> --}}
        <div class="   grid gap-1 mt-5">
            @can('view-page')
            <a  href="/dashboard" class="{{ request()->is('dashboard') ? 'bg-[#f8fcfc] text-black hover:bg-none' : '' }} flex justify-between items-center px-3 py-3 rounded-l-full hover:bg-[#f8fcfc] hover:text-black" >
                <div class="flex items-center gap-4 px-2">
                    <x-icon name="squares-2x2" />
                    Dashboard
                </div>
                {{-- <div>Sign</div> --}}
            </a>
            @endcan
            <a wire:navigate href="/bookings" class=" px-3 py-3    {{ request()->is('bookings') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center ">
                    <div class=" flex items-center gap-4 px-2">
                        <x-icon name="clipboard-document-list" />
                        Bookings
                    </div>
                </div>
            </a>
            
            <a wire:navigate href="/rooms" class=" px-3 py-3    {{ request()->is('rooms') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center ">
                    <div class=" flex items-center gap-4 px-2">
                        <x-icon name="building-office" />
                        Rooms
                    </div>
                </div>
            </a>
            @can('view-page')
            <a wire:navigate href="/room-type" class=" px-3 py-3    {{ request()->is('room-type') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center ">
                    <div class=" flex items-center gap-4 px-2">
                        <x-icon name="building-office" />
                        Room Type
                    </div>
                </div>
            </a>
            @endcan
            <a wire:navigate  href="/guests" class=" px-3 py-3    {{ request()->is('guests') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div  class="flex justify-between items-center ">
                    <div class=" flex items-center gap-4 px-2">
                        <x-icon name="user-group" />
                        Guests
                    </div>
                </div>
            </a>
            <a wire:navigate href="/events" class=" px-3 py-3    {{ request()->is('events') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div  class="flex justify-between items-center ">
                    <div class=" flex items-center gap-4 px-2">
                        <x-icon name="calendar-days" />
                        Events
                    </div>
                </div>
            </a>
            @can('view-page')
            <div class=" px-3 py-3    {{ request()->is('task-management') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center ">
                    <a wire:navigate href="/housekeeping" @click="dropdown1=true" @click.away="dropdown1=false" class=" flex items-center gap-4 px-2">
                        <x-icon name="currency-dollar" />
                        Housekeeping
                    </a>
                </div>
            </div>
           
            <div class=" px-3 py-3    {{ request()->is('task-management') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center ">
                    <a wire:navigate href="/invoices" @click="dropdown1=true" @click.away="dropdown1=false" class=" flex items-center gap-4 px-2">
                        <x-icon name="briefcase" />
                        Invoices
                    </a>
                </div>
            </div>
            <div class=" px-3 py-3    {{ request()->is('task-management') ? 'bg-[#f8fcfc] text-black rounded-l-full' : '' }} rounded-l-full hover:bg-[#f8fcfc] hover:text-black" x-data="{dropdown1:false}">
                <div class="flex justify-between items-center ">
                    <a wire:navigate href="/night-audit" @click="dropdown1=true" @click.away="dropdown1=false" class=" flex items-center gap-4 px-2">
                        <x-icon name="moon"/>
                        Night Audit
                    </a>
                </div>
            </div>
            @endcan

            <livewire:layout.navigation />

            
        </div>

    </div>
    {{-- LARGE SCREEN SIDEBAR --}}

    {{-- CONTAINER --}}
    <div class=" w-full h-screen flex flex-col overflow-auto">
        {{-- NAV BAR --}}
        <div class="z-20 lg:hidden w-full h-12 flex justify-between bg-white lg:flex lg:items-center lg:justify-between px-4 py-4 lg:px-5 sticky top-0 shadow-[rgba(0,_0,_0,_0.10)_0px_3px_8px]">
            <div class="relative hidden lg:flex items-center">
                <button :class="!sb2 ? 'rotate-90' : 'rotate-270'" class=" pr-2 mr-2 transition-all duration-300  rounded-full text-black text-center" href="" @click="!sb2 ? sb2 = true : sb2 = false"><x-icon name="bars-3" /></button>
                <input type="text" class="bg-[#f8fcfc] border border-blue-900/50 outline-blue-900/50 px-1 py-1 rounded-md" placeholder="Search...">
                <x-icon name="magnifying-glass" class="absolute right-1 w-5" />
            </div>
            
            <div>
                &nbsp;
            </div>
            <div class="ml-10 lg:hidden">
                HMS
            </div>
            <div class="relative flex justify-center items-center space-x-3 " x-cloak x-data="{notif: false, logout: false}">
                <button class="">
                    <x-icon name="bell-alert"  color="gray" @click="notif = true" />
                </button>
                {{-- NOTIFICATION CONTAINER --}}
                <template x-if="true">
                    <div x-show="notif" x-cloak @click.away="notif = false" x-transition class="overflow-auto grid gap-3 p-3 absolute -bottom-80 lg:-bottom-73 -left-64 lg:-left-64  h-72 lg:h-80 w-72 lg:w-80 rounded-md bg-white shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px]">
                        <div class="w-full h-16 bg-green-500 flex justify-center items-center gap-2 px-2" >
                            <x-avatar sm src="https://avatarfiles.alphacoders.com/364/364538.png" />
                            <div>
                                <div class="text-sm font-bold">Notification Title</div>
                                <div class="text-[10px] lg:text-[11px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. .....</div>
                            </div>
                        </div>
                        <div class="w-full h-16 bg-green-500 flex justify-center items-center gap-2 px-2">
                            <x-avatar sm src="https://avatarfiles.alphacoders.com/364/364538.png" />
                            <div>
                                <div class="text-sm font-bold">Notification Title</div>
                                <div class="text-[10px] lg:text-[11px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. .....</div>
                            </div>
                        </div>
                        <div class="w-full h-16 bg-green-500 flex justify-center items-center gap-2 px-2">
                            <x-avatar sm src="https://avatarfiles.alphacoders.com/364/364538.png" />
                            <div>
                                <div class="text-sm font-bold">Notification Title</div>
                                <div class="text-[10px] lg:text-[11px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. .....</div>
                            </div>
                        </div>
                        <div class="w-full h-16 bg-green-500 flex justify-center items-center gap-2 px-2">
                            <x-avatar sm src="https://avatarfiles.alphacoders.com/364/364538.png" />
                            <div>
                                <div class="text-sm font-bold">Notification Title</div>
                                <div class="text-[10px] lg:text-[11px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. .....</div>
                            </div>
                        </div>
                        <div class="w-full h-16 bg-green-500 flex justify-center items-center gap-2 px-2">
                            <x-avatar sm src="https://avatarfiles.alphacoders.com/364/364538.png" />
                            <div>
                                <div class="text-sm font-bold">Notification Title</div>
                                <div class="text-[10px] lg:text-[11px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. .....</div>
                            </div>
                        </div>
                        <div class="w-full h-16 bg-green-500 flex justify-center items-center gap-2 px-2">
                            <x-avatar sm src="https://avatarfiles.alphacoders.com/364/364538.png" />
                            <div>
                                <div class="text-sm font-bold">Notification Title</div>
                                <div class="text-[10px] lg:text-[11px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. .....</div>
                            </div>
                        </div>
                    </div>
                </template>
                {{-- NOTIFICATION CONTAINER --}}
                <button class="">
                    <x-icon name="question-mark-circle"  color="gray" class="" />
                </button>
                <button class="hidden lg:flex lg:items-center" @click=" logout = true ">
                    <x-avatar sm src="https://avatarfiles.alphacoders.com/364/364538.png" class="bg-gray-600" />
                </button>
                {{-- Logout --}}
                <template x-if="true">
                    <div x-show="logout" x-cloak @click.away="logout = false" x-transition class="overflow-auto grid gap-3 p-3 absolute  top-10 rounded-md bg-white shadow-[rgba(0,_0,_0,_0.24)_0px_3px_8px]">
                        <div>
                            <a href="">Profile</a>
                            <form action="logout" method="POST">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </template>
                {{-- Logout --}}
            </div>
            
        </div>
        {{-- NAV BAR --}}

        {{-- CONTENT AREA --}}
        <div class="w-full p-4 space-y-4 ">
            {{-- <nav class="flex py-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                  <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                      <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                      </svg>
                      {{ $head1 }}
                    </a>
                  </li>
                  <li>
                    <div class="flex items-center">
                      <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                      </svg>
                      <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $head2 }}</a>
                    </div>
                  </li>
                  <li aria-current="page">
                    <div class="flex items-center">
                      <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                      </svg>
                      <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ $head3 }}</span>
                    </div>
                  </li>
                </ol>
            </nav> --}}
           {{ $slot }}
        </div>
        {{-- CONTENT AREA --}}
    </div>
    @livewireScripts
</body>
</html>