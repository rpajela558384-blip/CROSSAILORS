<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <div class="bg-brand-700 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <p class="text-brand-200 mt-1">Account management overview</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Clickable role summary cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <a href="{{ route('admin.users.index') }}" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center hover:border-brand-300 hover:shadow-md transition group">
                <p class="text-4xl font-bold text-slate-700 group-hover:text-brand-700 transition">{{ $stats['total'] }}</p>
                <p class="text-slate-500 text-sm mt-1">All Accounts</p>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center hover:border-blue-300 hover:shadow-md transition group">
                <p class="text-4xl font-bold text-blue-600">{{ $stats['students'] }}</p>
                <p class="text-slate-500 text-sm mt-1">Students</p>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'officer']) }}" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center hover:border-brand-300 hover:shadow-md transition group">
                <p class="text-4xl font-bold text-brand-600">{{ $stats['officers'] }}</p>
                <p class="text-slate-500 text-sm mt-1">Officers</p>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center hover:border-red-300 hover:shadow-md transition group">
                <p class="text-4xl font-bold text-red-600">{{ $stats['admins'] }}</p>
                <p class="text-slate-500 text-sm mt-1">Admins</p>
            </a>
        </div>

        {{-- Recent Accounts --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Recent Accounts</h2>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-brand-700 hover:underline">View all →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="text-left px-5 py-3 text-slate-500 font-semibold">Name</th>
                            <th class="text-left px-5 py-3 text-slate-500 font-semibold">Email</th>
                            <th class="text-left px-5 py-3 text-slate-500 font-semibold">Role</th>
                            <th class="text-left px-5 py-3 text-slate-500 font-semibold">Status</th>
                            <th class="text-left px-5 py-3 text-slate-500 font-semibold">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentUsers as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    @if($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}" class="w-7 h-7 rounded-full object-cover ring-1 ring-brand-100" alt="">
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 text-xs font-bold shrink-0">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                    @endif
                                    <span class="font-medium text-slate-800">{{ $user->name }}</span>
                                    @if($user->is_protected)
                                        <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd"/></svg>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-500">{{ $user->email }}</td>
                            <td class="px-5 py-3">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : ($user->role === 'officer' ? 'bg-brand-100 text-brand-700' : 'bg-slate-100 text-slate-600') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-500' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-400 whitespace-nowrap">{{ $user->created_at->format('M j, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No accounts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recentUsers->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $recentUsers->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
