<x-app-layout>
    <x-slot name="title">User Management</x-slot>

    <div class="bg-brand-700 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1 text-brand-200 hover:text-white text-sm mb-2 transition">← Dashboard</a>
                <h1 class="text-3xl font-bold">Accounts</h1>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-brand-700 font-semibold rounded-xl hover:bg-brand-50 transition shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                New User
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..." class="border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm text-sm py-2 px-3 min-w-52">
            <select name="role" onchange="this.form.submit()" class="border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm text-sm py-2">
                <option value="">All Roles</option>
                <option value="student"  {{ request('role') === 'student'  ? 'selected' : '' }}>Student</option>
                <option value="officer"  {{ request('role') === 'officer'  ? 'selected' : '' }}>Officer</option>
                <option value="admin"    {{ request('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-brand-700 text-white text-sm font-semibold rounded-lg hover:bg-brand-800 transition">Search</button>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-sm rounded-lg hover:bg-slate-50 transition">Clear</a>
            @endif
        </form>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Name</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Email</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Role</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Joined</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" class="w-8 h-8 rounded-full object-cover ring-1 ring-brand-100 shrink-0" alt="">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 text-xs font-bold shrink-0">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                @endif
                                <span class="font-medium text-slate-800">{{ $user->name }}</span>
                                @if($user->is_protected)
                                    <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20" title="Protected"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd"/></svg>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-3 text-slate-500">{{ $user->email }}</td>
                        <td class="px-5 py-3">
                            @if($user->is_protected)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">{{ ucfirst($user->role) }}</span>
                            @else
                            <form method="POST" action="{{ route('admin.users.role', $user) }}" class="inline-flex">
                                @csrf @method('PATCH')
                                <select name="role" onchange="this.form.submit()" class="text-xs border-slate-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg py-1
                                    {{ $user->role === 'admin' ? 'bg-red-50 text-red-700' : ($user->role === 'officer' ? 'bg-brand-50 text-brand-700' : 'bg-slate-50 text-slate-600') }}">
                                    <option value="student"  {{ $user->role === 'student'  ? 'selected' : '' }}>Student</option>
                                    <option value="officer"  {{ $user->role === 'officer'  ? 'selected' : '' }}>Officer</option>
                                    <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if($user->is_protected)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Active</span>
                            @else
                            <button type="button" x-data
                                @click="$dispatch('confirm-action', {
                                    title: '{{ $user->is_active ? 'Deactivate' : 'Activate' }} Account',
                                    message: 'Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} {{ addslashes($user->name) }}\'s account?',
                                    type: '{{ $user->is_active ? 'warning' : 'info' }}',
                                    action: () => $refs.toggleForm{{ $user->id }}.submit()
                                })"
                                class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-600 hover:bg-red-200' }} transition">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </button>
                            <form x-ref="toggleForm{{ $user->id }}" method="POST" action="{{ route('admin.users.toggle', $user) }}" class="hidden">
                                @csrf @method('PATCH')
                            </form>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-400 whitespace-nowrap">{{ $user->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-3 space-x-3 whitespace-nowrap">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-brand-700 hover:text-brand-800 text-xs font-medium">Edit</a>
                            @if(!$user->is_protected && $user->id !== auth()->id())
                            <button type="button" x-data
                                @click="$dispatch('confirm-action', {
                                    title: 'Disable Account',
                                    message: 'Disable {{ addslashes($user->name) }}\'s account? They will no longer be able to log in.',
                                    type: 'danger',
                                    action: () => $refs.disableForm{{ $user->id }}.submit()
                                })"
                                class="text-red-500 hover:text-red-700 text-xs font-medium">
                                {{ $user->is_active ? 'Disable' : 'Disabled' }}
                            </button>
                            <form x-ref="disableForm{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy', $user) }}" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->appends(request()->query())->links() }}
    </div>
</x-app-layout>
