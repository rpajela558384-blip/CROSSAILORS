<nav x-data="{ open: false }" class="bg-brand-700 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Brand --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-white font-bold text-lg tracking-wide hover:opacity-90 transition">
                    <svg class="w-7 h-7 text-brand-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 9l10 6 10-6-10-6zM2 17l10 6 10-6M2 13l10 6 10-6"/>
                    </svg>
                    <span>Crossailors</span>
                    <span class="hidden sm:inline text-brand-300 text-xs font-normal ml-1">| BSMT Portal</span>
                </a>
            </div>

            {{-- Desktop Links --}}
            <div class="hidden sm:flex sm:items-center sm:gap-1">
                @auth
                    @if(auth()->user()->isAdmin())
                        {{-- Admin: Dashboard + Accounts --}}
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-800' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('admin.users.*') ? 'bg-brand-800' : '' }}">Accounts</a>
                    @elseif(auth()->user()->isOfficer())
                        {{-- Officer: Home + Dashboard + My Tickets --}}
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('home') ? 'bg-brand-800' : '' }}">Home</a>
                        <a href="{{ route('officer.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('officer.*') ? 'bg-brand-800' : '' }}">Dashboard</a>
                        <a href="{{ route('tickets.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('tickets.*') ? 'bg-brand-800' : '' }}">My Tickets</a>
                    @else
                        {{-- Student: Home + Officers + Tickets --}}
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('home') ? 'bg-brand-800' : '' }}">Home</a>
                        <a href="{{ route('officers.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('officers.index') ? 'bg-brand-800' : '' }}">Officers</a>
                        <a href="{{ route('tickets.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('tickets.*') ? 'bg-brand-800' : '' }}">Tickets</a>
                    @endif

                    {{-- Notification Bell (all authenticated) --}}
                    <div class="relative ml-1" x-data="notificationBell()" x-init="init()">
                        <button @click="toggle()" class="relative p-2 rounded-full text-white hover:bg-brand-600 transition focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span x-show="unread > 0" x-text="unread" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold"></span>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-200 z-50 overflow-hidden">
                            <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                                <span class="font-semibold text-slate-800 text-sm">Notifications</span>
                                <button @click="markAllRead()" class="text-xs text-brand-700 hover:underline">Mark all read</button>
                            </div>
                            <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                                <template x-if="notifications.length === 0">
                                    <p class="px-4 py-6 text-center text-slate-400 text-sm">No notifications</p>
                                </template>
                                <template x-for="n in notifications" :key="n.id">
                                    <a :href="(window.__notificationsVisitUrl || '/notifications/{id}/visit').replace('{id}', n.id)"
                                       class="block px-4 py-3 hover:bg-slate-50 transition"
                                       :class="n.read_at ? '' : 'bg-brand-50'">
                                        <p class="text-sm text-slate-800 leading-snug" :class="n.read_at ? '' : 'font-semibold'" x-text="n.data.message"></p>
                                        <p class="text-xs text-slate-400 mt-1" x-text="n.created_at"></p>
                                    </a>
                                </template>
                            </div>
                            <a href="{{ route('notifications.index') }}" class="block text-center py-2 text-xs text-brand-700 hover:bg-slate-50 border-t border-slate-100">View all</a>
                        </div>
                    </div>

                    {{-- User Dropdown --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 ml-2 px-3 py-1.5 rounded-full bg-brand-600 hover:bg-brand-500 text-white text-sm font-medium transition focus:outline-none">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-6 h-6 rounded-full object-cover" alt="">
                                @else
                                    <span class="w-6 h-6 rounded-full bg-brand-300 flex items-center justify-center text-xs font-bold text-brand-900">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                                @endif
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @if(!auth()->user()->isAdmin())
                                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            @endif
                            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                            </form>
                            <button type="button"
                                @click="$dispatch('confirm-action', {
                                    title: 'Log Out',
                                    message: 'Are you sure you want to log out of your account?',
                                    type: 'warning',
                                    action: () => document.getElementById('logout-form').submit()
                                })"
                                class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition">
                                Log Out
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('home') ? 'bg-brand-800' : '' }}">Home</a>
                    <a href="{{ route('officers.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-600 transition {{ request()->routeIs('officers.index') ? 'bg-brand-800' : '' }}">Officers</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium text-white border border-white/30 hover:bg-brand-600 transition ml-2">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm font-medium bg-white text-brand-700 hover:bg-brand-50 transition ml-1">Register</a>
                @endauth
            </div>

            {{-- Hamburger --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-white hover:bg-brand-600 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-brand-800 border-t border-brand-600">
        <div class="px-3 py-2 space-y-1">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Accounts</a>
                @elseif(auth()->user()->isOfficer())
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Home</a>
                    <a href="{{ route('officer.dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Dashboard</a>
                    <a href="{{ route('tickets.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">My Tickets</a>
                @else
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Home</a>
                    <a href="{{ route('officers.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Officers</a>
                    <a href="{{ route('tickets.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Tickets</a>
                @endif
                <div class="border-t border-brand-600 mt-2 pt-2">
                    <p class="px-3 text-xs text-brand-300">{{ auth()->user()->name }}</p>
                    @if(!auth()->user()->isAdmin())
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-sm text-white hover:bg-brand-700">Profile</a>
                    @endif
                    <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <button type="button"
                        @click="$dispatch('confirm-action', {
                            title: 'Log Out',
                            message: 'Are you sure you want to log out of your account?',
                            type: 'warning',
                            action: () => document.getElementById('logout-form-mobile').submit()
                        })"
                        class="w-full text-left px-3 py-2 rounded-md text-sm text-white hover:bg-brand-700">Log Out</button>
                </div>
            @else
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Home</a>
                <a href="{{ route('officers.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Officers</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-brand-700">Register</a>
            @endauth
        </div>
    </div>
</nav>
