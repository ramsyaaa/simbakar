@if (Auth::user()->hasPermissionTo('data-kapal') || Auth::user()->hasPermissionTo('data-pemasok') || Auth::user()->hasPermissionTo('data-agen-kapal') || Auth::user()->hasPermissionTo('data-bongkar-muat') || Auth::user()->hasPermissionTo('data-transportir') || Auth::user()->hasPermissionTo('data-pelabuhan-muat')|| Auth::user()->hasPermissionTo('data-surveyor') || Auth::user()->hasPermissionTo('data-pic') || Auth::user()->hasPermissionTo('data-dermaga') || Auth::user()->hasPermissionTo('data-alat') || Auth::user()->hasPermissionTo('data-bunker-bbm') || Auth::user()->hasPermissionTo('data-unit') || Auth::user()->hasPermissionTo('data-muatan'))
    @php
       $isOpen = false;

       if(
            request()->routeIs('master-data.ships.index') ||
            request()->routeIs('master-data.suppliers.index') ||
            request()->routeIs('master-data.ship-agents.index') ||
            request()->routeIs('master-data.load-companies.index') ||
            request()->routeIs('master-data.transporters.index') ||
            request()->routeIs('master-data.harbors.index') ||
            request()->routeIs('master-data.surveyors.index') ||
            request()->routeIs('master-data.person-in-charges.index') ||
            request()->routeIs('master-data.docks.index') ||
            request()->routeIs('master-data.heavy-equipments.index') ||
            request()->routeIs('master-data.bunkers.index') ||
            request()->routeIs('master-data.units.index') ||
            request()->routeIs('master-data.load-type.index')
            ){
                $isOpen = true;
            }
   @endphp
    <div>
        <div x-data="{open:{{ $isOpen ? $isOpen : 'false' }}}">
            <div @click="open=!open" class="py-3 px-3 text-[16px] text-[#ffffff] flex justify-between items-center cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] rounded-lg">
                <div class="flex items-center gap-4 ">
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="4" y="4" width="16" height="16" rx="2" ry="2" stroke="#ffffff" stroke-width="2" opacity="0.8"/>
                            <path d="M8 8H16V10H8V8Z" fill="#ffffff"/>
                            <path d="M8 12H16V14H8V12Z" fill="#ffffff"/>
                            <path d="M8 16H13V18H8V16Z" fill="#ffffff"/>
                        </svg>

                    </div>
                    <div class="font-normal">
                        Data Master
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z" fill="#ffffff"/>
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open" x-transition:enter="transition-transform transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-10%]" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#ffffff]">
                @if (Auth::user()->hasPermissionTo('data-kapal'))
                    <div>
                        <a href="{{ route('master-data.ships.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.ships.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Kapal
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-pemasok'))
                    <div>
                        <a href="{{ route('master-data.suppliers.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.suppliers.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pemasok
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-agen-kapal'))
                    <div>
                        <a href="{{ route('master-data.ship-agents.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.ship-agents.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Agen Kapal
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-bongkar-muat'))
                    <div>
                        <a href="{{ route('master-data.load-companies.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.load-companies.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Perusahaan Bongkar Muat
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-transportir'))
                    <div>
                        <a href="{{ route('master-data.transporters.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.transporters.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Transportir
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-pelabuhan-muat'))
                    <div>
                        <a href="{{ route('master-data.harbors.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.harbors.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pelabuhan Muat
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-surveyor'))
                    <div>
                        <a href="{{ route('master-data.surveyors.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.surveyors.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Surveyor
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-pic'))
                    <div>
                        <a href="{{ route('master-data.person-in-charges.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.person-in-charges.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Person in Charge
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-dermaga'))
                    <div>
                        <a href="{{ route('master-data.docks.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.docks.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Dermaga Suralaya
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-alat'))
                    <div>
                        <a href="{{ route('master-data.heavy-equipments.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.heavy-equipments.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Alat Besar
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (Auth::user()->hasPermissionTo('data-bunker-bbm'))
                    <div>
                        <a href="{{ route('master-data.bunkers.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.bunkers.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Bunker BBM
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-unit'))
                    <div>
                        <a href="{{ route('master-data.units.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Unit
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('data-muatan'))
                    <div>
                        <a href="{{ route('master-data.load-type.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.load-type.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Jenis Muatan
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

