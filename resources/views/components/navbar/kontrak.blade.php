@if (Auth::user()->hasPermissionTo('kontrak-batu-bara') || Auth::user()->hasPermissionTo('kontrak-pemesanan-bbm') || Auth::user()->hasPermissionTo('kontrak-transfer-bbm'))
    @php
       $isOpen = false;

       if(
            request()->routeIs('contracts.coal-contracts.index') ||
            request()->routeIs('contracts.bbm-book-contracts.index') ||
            request()->routeIs('contracts.bbm-transfers.index') ||
            request()->routeIs('contracts.biomassa-contracts.index')
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
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke="#ffffff" stroke-width="2" opacity="0.8"/>
                            <path d="M7 7H17" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <path d="M7 11H17" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <path d="M7 15H13" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <path d="M15 18L18 21L21 18" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    </div>
                    <div class="font-normal">
                        Kontrak
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z" fill="#ffffff"/>
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open" x-transition:enter="transition-transform transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-10%]" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#ffffff]">
                @if (Auth::user()->hasPermissionTo('kontrak-batu-bara'))
                    <div>
                        <a href="{{route('contracts.coal-contracts.index')}}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('contracts.coal-contracts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Batu Bara
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('kontrak-pemesanan-bbm'))
                    <div>
                        <a href="{{route('contracts.bbm-book-contracts.index')}}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('contracts.bbm-book-contracts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pemesanan BBM
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (Auth::user()->hasPermissionTo('kontrak-transfer-bbm'))
                    <div>
                        <a href="{{route('contracts.bbm-transfers.index')}}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('contracts.bbm-transfers.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Transfer BBM
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                {{-- @if (Auth::user()->hasPermissionTo('kontrak-batu-bara')) --}}
                    <div>
                        <a href="{{route('contracts.biomassa-contracts.index')}}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('contracts.biomassa-contracts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Biomassa
                                </div>
                            </div>
                        </a>
                    </div>
                {{-- @endif --}}

            </div>
        </div>
    </div>
@endif
