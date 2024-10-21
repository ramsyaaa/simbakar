@if (Auth::user()->hasPermissionTo('inputan-analisa') || Auth::user()->hasPermissionTo('inputan-pembongkaran-batu-bara') || Auth::user()->hasPermissionTo('inputan-penerimaan-batu-bara') || Auth::user()->hasPermissionTo('inputan-pemakaian-batu-bara') || Auth::user()->hasPermissionTo('inputan-penerimaan-bbm') || Auth::user()->hasPermissionTo('inputan-stock-opname')|| Auth::user()->hasPermissionTo('inputan-tug') || Auth::user()->hasPermissionTo('inputan-jadwal-kapal') || Auth::user()->hasPermissionTo('inputan-pencatatan-counter') || Auth::user()->hasPermissionTo('inputan-pemantauan-kapal') || Auth::user()->hasPermissionTo('inputan-data-bongkar'))
   @php
       $isOpen = false;

       if(
            request()->routeIs('inputs.analysis.preloadings.index') ||
            request()->routeIs('inputs.analysis-bbm.befores.index') ||
            request()->routeIs('inputs.analysis-biomassa.index') ||
            request()->routeIs('inputs.stock-opnames.index') ||
		    request()->routeIs('inputs.tug-3.index')
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
                            <path d="M3 21L8.7 20.4L20.3 8.8C20.9 8.2 20.9 7.2 20.3 6.6L17.4 3.7C16.8 3.1 15.8 3.1 15.2 3.7L3.6 15.3L3 21Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 4L20 10" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="font-normal">
                        Inputan
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z" fill="#ffffff"/>
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open" x-transition:enter="transition-transform transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-10%]" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#ffffff]">
                @if (Auth::user()->hasPermissionTo('inputan-analisa'))
                    <div>
                        <a href="{{ route('inputs.analysis.preloadings.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.analysis.preloadings.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Analisa
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                {{-- @if (Auth::user()->hasPermissionTo('inputan-analisa')) --}}
                    <div>
                        <a href="{{ route('inputs.analysis-bbm.befores.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.analysis-bbm.befores.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Analisa BBM
                                </div>
                            </div>
                        </a>
                    </div>
                {{-- @endif --}}
                {{-- @if (Auth::user()->hasPermissionTo('inputan-analisa')) --}}
                    {{-- <div>
                        <a href="{{ route('inputs.analysis-biomassa.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.analysis-biomassa.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Analisa Biomassa
                                </div>
                            </div>
                        </a>
                    </div> --}}
                {{-- @endif --}}
                {{-- @if (Auth::user()->hasPermissionTo('inputan-pembongkaran-batu-bara'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pembongkaran Batubara
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inputan-penerimaan-batu-bara'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Penerimaan Batubara
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inputan-pemakaian-batu-bara'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pemakaian Batubara
                                </div>
                            </div>
                        </a>
                    </div>
                @endif --}}
                {{-- @if (Auth::user()->hasPermissionTo('inputan-penerimaan-bbm')) --}}
                    {{-- <div>
                        <a href="{{ route('inputs.bbm_receipts.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Penerimaan BBM
                                </div>
                            </div>
                        </a>
                    </div> --}}
                {{-- @endif --}}
                {{-- @if (Auth::user()->hasPermissionTo('inputan-penerimaan-bbm')) --}}
                    {{-- <div>
                        <a href="{{ route('inputs.bbm_usage.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pemakaian BBM
                                </div>
                            </div>
                        </a>
                    </div> --}}
                {{-- @endif --}}
                @if (Auth::user()->hasPermissionTo('inputan-stock-opname'))
                    <div>
                        <a href="{{route('inputs.stock-opnames.index')}}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.stock-opnames.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Stock Opname
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inputan-tug'))
                    <div>
                        <a href="{{route('inputs.tug-3.index')}}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.tug-3.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                TUG
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                {{-- @if (Auth::user()->hasPermissionTo('inputan-jadwal-kapal'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Jadwal Kapal
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inputan-pencatatan-counter'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pencatatan Counter
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (Auth::user()->hasPermissionTo('inputan-pemantauan-kapal'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pemantauan Kapal
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('inputan-data-bongkar'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('master-data.units.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Perbaiki Data Bongkar
                                </div>
                            </div>
                        </a>
                    </div>
                @endif   --}}
            </div>
        </div>
    </div>
@endif
