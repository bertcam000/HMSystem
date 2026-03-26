<x-layouts.layout>
    
    @if (session('success'))
        <x-notification :message="session('success')" type="success" />
    @endif
    
    <section class="space-y-7 p-3 rounded-xl" x-data="{ addBooking: false }">

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 ">Bookings</h1>
                <p class="text-gray-600">6 total bookings</p>
            </div>
            <a @click="addBooking = true" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryDark transition-colors text-sm font-medium">
            + Add Booking
            </a>
        </div>
        
        {{--  --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div class="shadow-md flex justify-between gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div>
                    <div class="text-gray-500 text-sm">Total Bookings</div>
                    <p class="text-2xl font-bold">1,524</p>
                    <p class="text-gray-400 text-xs text-green-500">+12% from last month</p>
                </div>
                <div class="bg-blue-500 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="calendar" class="w-5 h-5 text-white" outline />
                </div>
            </div>
            <div class="shadow-md flex justify-between gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div>
                    <div class="text-gray-500 text-sm">Pending Bookings</div>
                    <p class="text-2xl font-bold">1,524</p>
                    <p class="text-gray-400 text-xs text-orange-500">Need confirmation</p>
                </div>
                <div class="bg-amber-500 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="clock" class="w-5 h-5 text-white" outline />
                </div>
            </div>
            <div class="shadow-md flex justify-between gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div>
                    <div class="text-gray-500 text-sm">Checked-In Guest</div>
                    <p class="text-2xl font-bold">23</p>
                    <p class="text-gray-400 text-xs text-green-500">Active stays today</p>
                </div>
                <div class="bg-green-500 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="calendar" class="w-5 h-5 text-white" outline />
                </div>
            </div>
            <div class="shadow-md flex justify-between gap-5 bg-white p-4 border border-gray-300/60 rounded-xl">
                <div>
                    <div class="text-gray-500 text-sm">Checked-Out Today</div>
                    <p class="text-2xl font-bold">15</p>
                    <p class="text-gray-400 text-xs text-red-400">Completed stays</p>
                </div>
                <div class="bg-red-400 p-2 rounded-md h-10 w-10 flex items-center justify-center">
                    <x-icon name="check" class="w-5 h-5 text-white" outline />
                </div>
            </div>
            
        </div>

        <!-- Current asset list -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <div>
              <button onclick="window.print()" class="bg-primary text-white px-3 py-2 shadow-sm rounded text-sm">Print</button>
            </div>
            <form action="/bookings" method="GET" class="flex justify-between items-center w-full">
              <select onchange="this.form.submit()" name="pages" id="rowsPerPage" class="text-sm border border-gray-300 rounded px-3 w-36 py-2 shadow-sm mx-3 lg:w-[60px]">
                <option value="10" {{ request('pages') == '10' ? 'selected' : '' }} selected>10</option>
                <option value="25" {{ request('pages') == '25' ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('pages') == '50' ? 'selected' : '' }}>50</option>
              </select>
                <div class="flex items-center gap-3">
                    <x-input icon="magnifying-glass" onchange="this.form.submit()" type="text" value="{{ request('booking_code') }}" id="booking_code" name="booking_code" placeholder="Search room number..." class=""/>
                    <select onchange="this.form.submit()" name="room_type_id" id="room_type_id" class="text-sm border border-gray-300 rounded-md px-3 w-36 py-2 shadow-sm">
                        <option value="" {{ request('room_type_id') ? '' : 'selected' }}>All Types</option>
                        <option value=""></option>
                    </select>
                    <select onchange="this.form.submit()" name="status" id="status" wire:model.live="status" class="text-sm border border-gray-300 rounded px-3 w-36 py-2 shadow-sm">
                        <option value="" {{ request('status') ? '' : 'selected' }}>All Statuses</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Occupied" {{ request('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="Reserved" {{ request('status') == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                        <option value="Cleaning" {{ request('status') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                        <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    <button class="bg-primary text-white px-3 py-2 shadow-sm rounded text-sm">Search</button>
                    
                </div>
            </form>
          </div>

          <div id="print-area" class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base ">
              <table id="qr-print-area" class="w-full text-sm text-left rtl:text-right text-body">
                  <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <div class="text-end px-5 py-2  print-date">{{ now()->format('M d, Y') }}</div>
                      <tr class=" text-gray-600 text-left">
                          <th scope="col" class="px-6 py-1 font-semibold">BOOKING #</th>
                          <th scope="col" class="px-6 py-1 font-semibold">GUEST</th>
                          <th scope="col" class="px-6 py-1 font-semibold">ROOM</th>
                          <th scope="col" class="px-6 py-1 font-semibold">CHECK-IN</th>
                          <th scope="col" class="px-6 py-1 font-semibold">CHECK-OUT</th>
                          <th scope="col" class="px-6 py-1 font-semibold">TOTAL AMOUNT</th>
                          <th scope="col" class="px-6 py-1 font-semibold">BALANCE</th>
                          <th scope="col" class="px-6 py-1 font-semibold">STATUS</th>
                          <th scope="col" class="px-6 py-1 font-semibold no-print">ACTION</th>
                      </tr>
                  </thead>
                  <tbody>
                        
                    @forelse ($bookings as $booking)
                      <tr class="bg-neutral-primary border-b border-default hover:bg-gray-50" x-data="{ open: false, dl: false }">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">{{ $booking->booking_code }}</th>
                        <td class="px-6 py-4">
                            <h1 class=" font-medium">{{ $booking->guest->first_name . ' ' . $booking->guest->last_name }}</h1>
                            <p class="text-gray-500 text-sm">{{ $booking->guest->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            Room
                            @foreach ($booking->rooms as $room)
                                {{ $room->room_number }} 
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $booking->check_in_date->format('F d, Y') }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $booking->check_out_date->format('F d, Y') }}</td>
                        {{-- <td class="px-6 py-4 font-bold">₱ {{ $booking->total_price }}</td>
                        <td class="px-6 py-4 font-bold">₱ {{ $booking->balance }}</td> --}}

                        {{--  --}}
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-500">
                                ₱ {{ number_format($booking->total_price, 2) }}
                            </p>
                        </td>

                        @php
                            $total = (float) $booking->total_price;
                            $balance = (float) $booking->balance;

                            if ($balance <= 0) {
                                $classes = 'bg-emerald-50 text-emerald-700 ring-emerald-200';
                                $dot = 'bg-emerald-500';
                                $label = 'Paid';
                            } elseif ($balance < $total) {
                                $classes = 'bg-amber-50 text-amber-700 ring-amber-200';
                                $dot = 'bg-amber-500';
                                $label = 'Partial';
                            } else {
                                $classes = 'bg-rose-50 text-rose-700 ring-rose-200';
                                $dot = 'bg-rose-500';
                                $label = 'Unpaid';
                            }
                        @endphp

                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-gray-500">
                                    ₱ {{ number_format($booking->balance, 2) }}
                                </span>

                                <span class="mt-1 inline-flex w-fit items-center gap-2 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $classes }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>
                                    {{ $label }}
                                </span>
                            </div>
                        </td>
                        
                        {{-- <td class="px-6 py-4">{{ $booking->status }}</td> --}}

                        @php
                            $status = strtolower(trim($booking->status));

                            $statusClasses = match($status) {
                                'checked_in' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                'checked_out' => 'bg-slate-100 text-slate-700 ring-slate-200',
                                'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                'confirmed' => 'bg-sky-50 text-sky-700 ring-sky-200',
                                'cancelled' => 'bg-rose-50 text-rose-700 ring-rose-200',
                                default => 'bg-slate-100 text-slate-700 ring-slate-200',
                            };

                            $dotClasses = match($status) {
                                'checked_in' => 'bg-emerald-500',
                                'checked_out' => 'bg-slate-500',
                                'pending' => 'bg-amber-500',
                                'confirmed' => 'bg-sky-500',
                                'cancelled' => 'bg-rose-500',
                                default => 'bg-slate-500',
                            };

                            $label = ucwords(str_replace('_', ' ', $status));
                        @endphp

                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClasses }}">
                                <span class="h-2 w-2 rounded-full {{ $dotClasses }}"></span>
                                {{ $label }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 ">
                            {{-- <a href="/booking/result/{{ $booking->id }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                                <x-icon name="eye" class="w-4"/>
                                View
                            </a> --}}
                            <div class="flex gap-2">
                                <a href="/guest/edit/2">
                                    <x-icon name="pencil-square" class="text-blue-700 hover:text-blue-500" />
                                </a>
                                <button @click="dl = true">
                                    <x-icon name="x-circle" class="text-red-700 hover:text-red-500" />
                                </button>
                                <a href="/booking/result/{{ $booking->id }}">
                                    <x-icon name="eye" class="text-green-700"/>
                                </a>
                          </div>
                        </td>
                        {{-- <td class="px-6 py-4 relative no-print">
                          <button @click="open = !open" class="px-3 py-1 rounded-md hover:bg-gray-100">
                              ⋮
                          </button>

                          <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-14 top-3 py-2 px-3 flex justify-center items-center gap-2 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                              <a href="/booking/result/{{ $booking->id }}" class="text-green-500 hover:rounded-lg hover:bg-gray-200 px-2">View</a>
                          </div>

                          <div x-show="dl" x-cloak
                              class="fixed inset-0 flex items-center justify-center z-50">
                              
                              <div class="fixed inset-0 bg-black bg-opacity-50" @click="dl = false"></div>

                              <div class="bg-white rounded-lg shadow-lg w-96 p-6 z-50"
                                  x-transition:enter="transition ease-out duration-300"
                                  x-transition:enter-start="opacity-0 scale-90"
                                  x-transition:enter-end="opacity-100 scale-100"
                                  x-transition:leave="transition ease-in duration-200"
                                  x-transition:leave-start="opacity-100 scale-100"
                                  x-transition:leave-end="opacity-0 scale-90">

                                  <h2 class="text-lg font-semibold text-gray-800 mb-4">Delete Confirmation</h2>
                                  <p class="text-gray-600 mb-6">Are you sure? This asset will permanently deleted</p>

                                  <div class="flex justify-end gap-3">
                                      <button @click="dl = false" 
                                              class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">
                                          Cancel
                                      </button>

                                      <form method="POST" action="/asset/delete/3 }}">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" 
                                                  class="px-4 py-2 rounded bg-red-500 hover:bg-red-600 text-white">
                                              Delete
                                          </button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                          
                        </td> --}}
                      </tr>
                      @empty
                        <tr>
                          <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                              No Data Found
                          </td>
                      </tr>
                      @endforelse
                      
                  </tbody>
                </table>
                
                <div class="p-4 no-print">
                  {{-- {{ $assets->links() }} --}}
                </div>
            </div>
            {{--  --}}
          
        </div>

        {{-- MODAl --}}
        <div x-show="addBooking" x-cloak class="px-2 md:px-0 transition-all duration-300 flex h-screen w-full bg-black/20 fixed -top-7 left-0 z-50  justify-center items-center">
            <livewire:booking.create/>
        </div>
    </section>

<style>
  .print-date {
      display: none;
  }
  @media print {

      body * {
          visibility: hidden;
          font-size: 10px !important;
      }

      .print-date {
          display: block;
          font-size: 12px;
      }

      #print-area,
      #print-area * {
          visibility: visible;
      }

      #print-area {
          position: absolute;
          left: 0;
          top: 0;
          width: 100%;
      }

      .no-print {
          display: none !important;
      }

      table {
          border-collapse: collapse;
      }

      th, td {
          
          border: 1px solid #000;
          padding: 3px 4px !important;   
          line-height: 1.1 !important;   
          vertical-align: top !important;
      }

      tr {
          height: auto !important;
      }

      td br {
          line-height: 1 !important;
      }

      th {
          background: #f3f3f3 !important;
          color: #000 !important;
      }
  }
</style>
</x-layouts.layout>