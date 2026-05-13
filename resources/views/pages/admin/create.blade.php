<x-layouts.layout>
    <div class="min-h-screen">
        <div class="mx-auto max-w-4xl">

            <!-- Header -->
            <div class="mb-8">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-100">
                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                    Administration • User Management
                </div>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Create Account
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Create a new system user account and assign access permissions.
                </p>
            </div>

            <!-- Form Card -->
            <div class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Basic Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Basic Information
                        </h2>

                        <div class="mt-5 grid grid-cols-1 gap-6 md:grid-cols-2">

                            <!-- Name -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter full name"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >

                                @error('name')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username') }}"
                                    placeholder="Enter username"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >

                                @error('username')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter email address"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >

                                @error('email')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Role
                                </label>

                                <select
                                    name="role"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    {{-- <option value="frontdesk">Front Desk</option>
                                    <option value="housekeeping">Housekeeping</option>
                                    <option value="hr">HR</option> --}}
                                    <option value="staff">Staff</option>
                                </select>

                                @error('role')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Security & Access
                        </h2>

                        <div class="mt-5 grid grid-cols-1 gap-6 md:grid-cols-2">

                            <!-- Password -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Enter password"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >

                                @error('password')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Confirm Password
                                </label>

                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Confirm password"
                                    class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="mb-2 block text-sm font-medium text-slate-700">
                                    Account Status
                                </label>

                                <select
                                    name="status"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                >
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>

                                @error('status')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                        <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                            Create Account
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-layouts.layout>