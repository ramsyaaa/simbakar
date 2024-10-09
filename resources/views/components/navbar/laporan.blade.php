@if (Auth::user()->hasPermissionTo('laporan-executive-summary') || Auth::user()->hasPermissionTo('laporan-kontrak') || Auth::user()->hasPermissionTo('laporan-penerimaan') || Auth::user()->hasPermissionTo('laporan-persediaan') || Auth::user()->hasPermissionTo('laporan-kualitas-batu-bara') || Auth::user()->hasPermissionTo('laporan-pembongkaran')|| Auth::user()->hasPermissionTo('laporan-alat-besar') || Auth::user()->hasPermissionTo('laporan-denda') || Auth::user()->hasPermissionTo('laporan-berita-acara') || Auth::user()->hasPermissionTo('laporan-performance') || Auth::user()->hasPermissionTo('laporan-bw') || Auth::user()->hasPermissionTo('laporan-pemantauan-kapal'))
    @php
       $isOpen = false;

       if(
            request()->routeIs('reports.executive-summary.index') ||
            request()->routeIs('reports.contracts.index') ||
            request()->routeIs('reports.supplies.index') ||
            request()->routeIs('reports.receipt.index') ||
            request()->routeIs('reports.coal-quality.index') ||
            request()->routeIs('reports.unloading.index') ||
            request()->routeIs('reports.heavy-equipment.index') ||
            request()->routeIs('reports.berita-acara.index')
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
                            <path d="M6 3H18C18.5523 3 19 3.44772 19 4V20C19 20.5523 18.5523 21 18 21H6C5.44772 21 5 20.5523 5 20V4C5 3.44772 5.44772 3 6 3Z" stroke="#ffffff" stroke-width="2"/>
                            <path d="M8 8H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <path d="M8 12H12" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                            <path d="M8 16H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                        </svg>

                    </div>
                    <div class="font-normal">
                        Laporan
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z" fill="#ffffff"/>
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open" x-transition:enter="transition-transform transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-10%]" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#ffffff]">
                @if (Auth::user()->hasPermissionTo('laporan-executive-summary'))
                    <div>
                        <a href="{{ route('reports.executive-summary.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.executive-summary.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Executive Summary
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('laporan-kontrak'))
                    <div>
                        <a href="{{ route('reports.contracts.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.contracts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Kontrak
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('laporan-persediaan'))
                    <div>
                        <a href="{{ route('reports.supplies.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.supplies.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Persediaan
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('laporan-penerimaan'))
                    <div>
                        <a href="{{ route('reports.receipt.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.receipt.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Penerimaan
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('laporan-kualitas-batu-bara'))
                    <div>
                        <a href="{{ route('reports.coal-quality.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.coal-quality.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Kualitas Batubara
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('laporan-pembongkaran'))
                    <div>
                        <a href="{{ route('reports.unloading.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.unloading.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Pembongkaran
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('laporan-alat-besar'))

                    <div>
                        <a href="{{ route('reports.heavy-equipment.index', ['type' => 'albes', 'type_bbm' => 'HSD']) }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.heavy-equipment.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
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
                {{-- @if (Auth::user()->hasPermissionTo('laporan-denda'))

                    <div>
                        <a href="{{ route('reports.berita-acara.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.biomassa_receipts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Denda
                                </div>
                            </div>
                        </a>
                    </div>
                @endif --}}
                @if (Auth::user()->hasPermissionTo('laporan-berita-acara'))

                    <div>
                        <a href="{{ route('reports.berita-acara.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('reports.berita-acara.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Berita Acara
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                {{-- @if (Auth::user()->hasPermissionTo('laporan-performance'))
                    <div>
                        <a href="{{ route('reports.performance.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.biomassa_receipts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Perfomance
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if (Auth::user()->hasPermissionTo('laporan-bw'))
                    <div>
                        <a href="{{ route('reports.bw.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.biomassa_receipts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    BW
                                </div>
                            </div>
                        </a>
                    </div>
                @endif --}}
                {{-- @if (Auth::user()->hasPermissionTo('laporan-pemantauan-kapal'))
                    <div>
                        <a href="{{ route('reports.ship-monitoring.index') }}">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('inputs.biomassa_receipts.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
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
                @endif --}}
            </div>
        </div>
    </div>
@endif
