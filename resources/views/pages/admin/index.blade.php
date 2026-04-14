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
                        Create Account
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 sm:text-base">
                        Add a new system user account for hotel operations.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
                <!-- Main Form -->
                <div class="xl:col-span-8 rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-slate-900">Account Information</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Enter the details required to create a new admin-managed account.
                        </p>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-slate-700">Full Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    placeholder="Enter full name"
                                >
                                @error('name')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Username</label>
                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username') }}"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    placeholder="Enter username"
                                >
                                @error('username')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    placeholder="Enter email address"
                                >
                                @error('email')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Role</label>
                                <select
                                    name="role"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >
                                    <option value="">Select role</option>
                                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                                    <option value="frontdesk" @selected(old('role') === 'frontdesk')>Front Desk</option>
                                    <option value="housekeeping" @selected(old('role') === 'housekeeping')>Housekeeping</option>
                                    <option value="hr" @selected(old('role') === 'hr')>HR</option>
                                    <option value="staff" @selected(old('role') === 'staff')>Staff</option>
                                </select>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Account Status</label>
                                <select
                                    name="status"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >
                                    <option value="active" @selected(old('status') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    placeholder="Enter password"
                                >
                                @error('password')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">Confirm Password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    placeholder="Confirm password"
                                >
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3 pt-2">
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
                            >
                                Create Account
                            </button>

                            <button
                                type="reset"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            >
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Side Panel -->
                <div class="xl:col-span-4 space-y-6">
                    <div class="rounded-[30px] border border-slate-200 bg-slate-900 p-6 text-white shadow-sm">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-lg font-bold">Admin Notes</h3>
                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white">
                                Access
                            </span>
                        </div>

                        <div class="space-y-4 text-sm text-slate-300">
                            <p>• Use unique usernames to avoid login conflicts.</p>
                            <p>• Assign only the minimum role needed for the staff member.</p>
                            <p>• Keep high-level roles like Admin limited to trusted users only.</p>
                            <p>• Set inactive accounts for users who should not log in yet.</p>
                        </div>
                    </div>

                    <div class="rounded-[30px] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-slate-900">Role Guide</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Quick reference for assigning system access.
                            </p>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">Admin</p>
                                <p class="mt-1 text-slate-500">Full system management and configuration.</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">Front Desk</p>
                                <p class="mt-1 text-slate-500">Handles reservations, check-in, check-out, and guest support.</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">Housekeeping</p>
                                <p class="mt-1 text-slate-500">Manages room cleaning tasks and room readiness.</p>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">HR / Staff</p>
                                <p class="mt-1 text-slate-500">Limited operational or internal access as needed.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.layout>