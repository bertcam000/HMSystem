<x-layouts.layout>
    <div class="min-h-screen">
        <div class="">

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header -->
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Administration • User Management
                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                        Users
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 sm:text-base">
                        Manage system accounts, roles, and access status.
                    </p>
                </div>

                <div>
                    <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                        Create Account
                    </a>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Total Users</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $totalUsers }}</h3>
                    <p class="mt-3 text-xs text-slate-400">All accounts in the system</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Active</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">{{ $activeUsers }}</h3>
                    <p class="mt-3 text-xs text-slate-400">Accounts allowed to log in</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Inactive</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-amber-600">{{ $inactiveUsers }}</h3>
                    <p class="mt-3 text-xs text-slate-400">Accounts currently disabled</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Admins</p>
                    <h3 class="mt-2 text-3xl font-bold tracking-tight text-blue-600">{{ $adminUsers }}</h3>
                    <p class="mt-3 text-xs text-slate-400">High-access system users</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-6 rounded-[30px] border border-slate-200 bg-white p-5 shadow-sm">
                <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                    <div class="xl:col-span-6">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Search</label>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by name, username, or email..."
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                    </div>

                    <div class="xl:col-span-3">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Role</label>
                        <select
                            name="role"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="">All Roles</option>
                            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                            <option value="frontdesk" @selected(request('role') === 'frontdesk')>Front Desk</option>
                            <option value="housekeeping" @selected(request('role') === 'housekeeping')>Housekeeping</option>
                            <option value="hr" @selected(request('role') === 'hr')>HR</option>
                            <option value="staff" @selected(request('role') === 'staff')>Staff</option>
                        </select>
                    </div>

                    <div class="xl:col-span-3">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Status</label>
                        <select
                            name="status"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        >
                            <option value="">All Statuses</option>
                            <option value="active" @selected(request('status') === 'active')>Active</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>

                    <div class="xl:col-span-12 flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Reset
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-hidden rounded-[30px] border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Username</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Created</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($users as $user)
                                @php
                                    $initials = strtoupper(substr($user->name, 0, 1));
                                    $status = strtolower($user->status);
                                    $role = strtolower($user->role);
                                @endphp

                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $user->email ?: 'No email provided' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                        {{ $user->username }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                            {{ ucfirst($role) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($status === 'active')
                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                @if($status === 'active')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-600">
                                                        Deactivate
                                                    </button>
                                                @else
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                                        Activate
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="mx-auto max-w-sm">
                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12m-12 4.5h12m-12 4.5h12m-16.5-9h.008v.008H3.75V6.75Zm0 4.5h.008v.008H3.75v-.008Zm0 4.5h.008v.008H3.75v-.008Z" />
                                                </svg>
                                            </div>
                                            <h3 class="mt-4 text-sm font-semibold text-slate-900">No users found</h3>
                                            <p class="mt-1 text-sm text-slate-500">
                                                Try adjusting your search or filters.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.layout>