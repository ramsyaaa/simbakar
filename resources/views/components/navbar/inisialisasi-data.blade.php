@if (Auth::user()->hasPermissionTo('inisiasi-setting-pbb') || Auth::user()->hasPermissionTo('inisiasi-produksi-listrik') || Auth::user()->hasPermissionTo('inisiasi-data-awal-tahun') || Auth::user()->hasPermissionTo('inisiasi-penerimaan-batu-bara') || Auth::user()->hasPermissionTo('inisiasi-pemakaian') || Auth::user()->hasPermissionTo('inisiasi-pemakaian-bbm'))
    @php
       $isOpen = false;

       if(
            request()->routeIs('initial-data.settings-bpb.index') ||
            request()->routeIs('initial-data.electricity-production.index') ||
            request()->routeIs('initial-data.year-start.index') ||
            request()->routeIs('initial-data.coal-receipt-plan.index') ||
            request()->routeIs('initial-data.consuption-plan.index') ||
            request()->routeIs('initial-data.bbm-receipt-plan.index')
            ){
                $isOpen = true;
            }
   @endphp
    <div>
        <div x-data="{open:{{ $isOpen ? $isOpen : 'false' }}}" class="">
            <div @click="open=!open" class="py-3 px-3 text-[16px] text-[#ffffff] flex justify-between items-center cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] rounded-lg">
                <div class="flex items-center gap-4 ">
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#ffffff" stroke-width="2" opacity="0.8"/>
                            <path d="M8 12H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8V16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18 21L20.5 18.5L18 16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 3L3.5 5.5L6 8" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    </div>
                    <div class="font-normal">
                        Inisialisasi Data
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z" fill="#ffffff"/>
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open" x-transition:enter="transition-transform transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-10%]" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#ffffff]">
                @if (Auth::user()->hasPermissionTo('inisiasi-setting-pbb'))
                    <div>
                        <a href="{{ route('initial-data.settings-bpb.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('initial-data.settings-bpb.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Setting No BPB
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inisiasi-produksi-listrik'))
                    <div>
                        <a href="{{ route('initial-data.electricity-production.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('initial-data.electricity-production.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Produksi Listrik
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inisiasi-data-awal-tahun'))
                    <div>
                        <a href="{{ route('initial-data.year-start.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('initial-data.year-start.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Data Awal Tahun
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (Auth::user()->hasPermissionTo('inisiasi-penerimaan-batu-bara'))
                    <div>
                        <a href="{{ route('initial-data.coal-receipt-plan.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('initial-data.coal-receipt-plan.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Renc. Penerimaan Batu Bara
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inisiasi-pemakaian'))
                    <div>
                        <a href="{{ route('initial-data.consuption-plan.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('initial-data.consuption-plan.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Renc. Pemakaian
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (Auth::user()->hasPermissionTo('inisiasi-pemakaian-bbm'))
                    <div>
                        <a href="{{ route('initial-data.bbm-receipt-plan.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('initial-data.bbm-receipt-plan.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Renc. Penerimaan BBM
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endif
