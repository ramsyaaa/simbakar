@if (Auth::user()->hasPermissionTo('administration-user') ||
        Auth::user()->hasPermissionTo('administration-approval') ||
        Auth::user()->hasPermissionTo('administration-log') ||
        Auth::user()->hasPermissionTo('administration-role'))
    @php
        $isOpen = false;

        if (request()->routeIs('administration.users.index') || request()->routeIs('administration.roles.index')) {
            $isOpen = true;
        }
    @endphp
    <div>
        <div x-data="{ open: {{ $isOpen ? $isOpen : 'false' }} }" class="">
            <div @click="open=!open"
                class="py-3 px-3 text-[16px] text-[#ffffff] flex justify-between items-center cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] rounded-lg">
                <div class="flex items-center gap-4 ">
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" fill="#ffffff" opacity="0.8" />
                            <path d="M18 22C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22" stroke="#ffffff"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path opacity="0.4"
                                d="M21 22C21 17.5817 17.4183 14 13 14C12.4536 14 11.9274 14.0557 11.426 14.1604C12.3022 15.233 13 17.1418 13 19.25V22H21Z"
                                fill="#ffffff" />
                            <path
                                d="M16.5 6C16.5 6.82843 15.8284 7.5 15 7.5C14.1716 7.5 13.5 6.82843 13.5 6C13.5 5.17157 14.1716 4.5 15 4.5C15.8284 4.5 16.5 5.17157 16.5 6Z"
                                fill="#ffffff" />
                        </svg>

                    </div>
                    <div class="font-normal">
                        Administrasi
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z"
                            fill="#ffffff" />
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open"
                x-transition:enter="transition-transform transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-[-10%]"
                x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#ffffff]">
                @if (Auth::user()->hasPermissionTo('administration-user'))
                    <div>
                        <a href="{{ route('administration.users.index') }}">
                            <div
                                class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('administration.users.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff" />
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    User
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                {{-- @if (Auth::user()->hasPermissionTo('administration-approval'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Approval Data
                                </div>
                            </div>
                        </a>
                    </div>
                @endif --}}
                {{-- @if (Auth::user()->hasPermissionTo('administration-log'))
                    <div>
                        <a href="#">
                            <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff"/>
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Log Aktifitas User
                                </div>
                            </div>
                        </a>
                    </div>
                @endif --}}
                @if (Auth::user()->hasPermissionTo('administration-role'))
                    <div>
                        <a href="{{ route('administration.roles.index') }}">
                            <div
                                class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300 hover:bg-[#047A96] {{ request()->routeIs('administration.roles.index') ? 'bg-[#047A96]' : 'hover:bg-[#047A96]' }} rounded-lg">
                                <div>
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12.0005" r="5" fill="#ffffff" />
                                    </svg>
                                </div>
                                <div class="font-normal text-[16px]">
                                    Role
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
