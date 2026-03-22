<x-layouts.layout>
    
    @if (session('success'))
        <x-notification :message="session('success')" type="success" />
    @endif
    
    <section class="space-y-7 p-3 rounded-xl" x-data="{ addGuest: false }">

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 ">Guests</h1>
                <p class="text-gray-600">6 total guests</p>
            </div>
            <button @click="addGuest = true" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryDark transition-colors text-sm font-medium">
            + Add Guest
            </button>
        </div>
        

        <!-- Current asset list -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            
            <form action="/guests" method="GET" class="flex justify-between items-center w-full">
              
                <div class="flex items-center gap-3">
                    <x-input icon="magnifying-glass" onchange="this.form.submit()" type="text" value="{{ request('search') }}" id="search" name="search" placeholder="Search room number..." class="w-full lg:w-[450px]"/>
                    {{-- <select onchange="this.form.submit()" name="room_type_id" id="room_type_id" class="text-sm border border-gray-300 rounded-md px-3 w-36 py-2 shadow-sm">
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
                    </select> --}}
                    
                </div>
                <button class="bg-primary text-white px-3 py-2 shadow-sm rounded text-sm">Search</button>
            </form>
          </div>

          <div id="print-area" class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base ">
              <table id="qr-print-area" class="w-full text-sm text-left rtl:text-right text-body">
                  <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                    <div class="text-end px-5 py-2  print-date">{{ now()->format('M d, Y') }}</div>
                      <tr class=" text-gray-600 text-left">
                          <th scope="col" class="px-6 py-1 font-semibold">GUEST</th>
                          <th scope="col" class="px-6 py-1 font-semibold">CONTACT</th>
                          <th scope="col" class="px-6 py-1 font-semibold">NATIONALITY</th>
                          <th scope="col" class="px-6 py-1 font-semibold">IDENTIFICATION</th>
                          <th scope="col" class="px-6 py-1 font-semibold">NOTES</th>
                          <th scope="col" class="px-6 py-1 font-semibold no-print">ACTION</th>
                      </tr>
                  </thead>
                  <tbody>
                        
                    @forelse ($guests as $guest)
                 
                      <tr class="bg-neutral-primary border-b border-default hover:bg-gray-50" x-data="{ open: false, dl: false }">
                        <td class="px-6 py-3">
                            <h1 class=" font-medium">{{ $guest->first_name . ' ' . $guest->last_name}}</h1>
                            <p class="text-gray-500 text-sm">{{ Str::limit($guest->address, 50) }}</p>
                        </td>
                        <td class="px-6 py-3">
                            <h1 class="text-gray-700">{{ $guest->email }}</h1>
                            <p class="text-gray-500 text-sm">{{ $guest->phone }}</p>
                        </td>
                        <td class="px-6 py-3">{{ $guest->nationality }}</td>
                        
                        <td class="px-6 py-3">
                            <p class="text-gray-500">{{ $guest->id_type }}</p>
                            <h1 class="text-gray-500 text-sms">{{ $guest->id_number }}</h1>
                        </td>
                        <td class="px-6 py-3 text-gray-500">{{ $guest->notes ?? 'None' }}</td>
                        <td class="px-6 py-3 relative no-print">
                          <button @click="open = !open" class="px-3 py-1 rounded-md hover:bg-gray-100">
                              ⋮
                          </button>

                          <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-14 top-3 py-2 px-3 flex justify-center items-center gap-2 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                              <button @click="dl = true" class="text-red-500 hover:bg-gray-200 hover:rounded-lg px-2">Delete</button>
                              <a href="/asset/update/3" class=" hover:bg-gray-200 hover:rounded-lg px-2">Edit</a>
                              <a href="/inventory/result/3" class="text-green-500 hover:rounded-lg hover:bg-gray-200 px-2">View</a>
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
                          
                        </td>
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
        <div x-show="addGuest" x-cloak class="px-2 md:px-0 transition-all duration-300 flex h-screen w-full bg-black/20 fixed -top-7 left-0 z-50  justify-center items-center">
            <livewire:guest.create/>
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