<div>
    <div class="py-2 text-[16px] text-[#ADB5BD] font-semibold">
        Settings
    </div>
    @php
        $icon = '<svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.4" d="M21.25 13.4896C20.429 13.4896 19.761 12.8277 19.761 12.0142C19.761 11.1997 20.429 10.5378 21.25 10.5378C21.449 10.5378 21.64 10.4595 21.78 10.3208C21.921 10.1811 22 9.99183 22 9.79464L21.999 7.11733C21.999 4.85421 20.14 3.01318 17.856 3.01318H6.144C3.86 3.01318 2.001 4.85421 2.001 7.11733L2 9.88085C2 10.078 2.079 10.2673 2.22 10.407C2.36 10.5457 2.551 10.624 2.75 10.624C3.599 10.624 4.239 11.2215 4.239 12.0142C4.239 12.8277 3.571 13.4896 2.75 13.4896C2.336 13.4896 2 13.8225 2 14.2327V16.908C2 19.1712 3.858 21.0132 6.143 21.0132H17.857C20.142 21.0132 22 19.1712 22 16.908V14.2327C22 13.8225 21.664 13.4896 21.25 13.4896Z" fill="#8A92A6"/><path d="M15.4306 11.6019L14.2516 12.7499L14.5306 14.3729C14.5786 14.6539 14.4656 14.9309 14.2346 15.0969C14.0056 15.2649 13.7066 15.2859 13.4546 15.1519L11.9996 14.3869L10.5416 15.1529C10.4336 15.2099 10.3156 15.2399 10.1986 15.2399C10.0456 15.2399 9.89458 15.1919 9.76458 15.0979C9.53458 14.9309 9.42158 14.6539 9.46958 14.3729L9.74758 12.7499L8.56858 11.6019C8.36458 11.4039 8.29358 11.1129 8.38158 10.8419C8.47058 10.5719 8.70058 10.3799 8.98158 10.3399L10.6076 10.1029L11.3366 8.62587C11.4636 8.37187 11.7176 8.21387 11.9996 8.21387H12.0016C12.2846 8.21487 12.5386 8.37287 12.6636 8.62687L13.3926 10.1029L15.0216 10.3409C15.2996 10.3799 15.5296 10.5719 15.6176 10.8419C15.7066 11.1129 15.6356 11.4039 15.4306 11.6019Z" fill="#8A92A6"/></svg>';
    @endphp
    <div>
        <div x-data="{open:false}" class="py-3 px-3 border-b">
            <div @click="open=!open" class="text-[16px] text-[#8A92A6] flex justify-between items-center cursor-pointer hover:scale-105 duration-300">
                <div class="flex items-center gap-4 ">
                    <div>
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.4" d="M21.25 13.4896C20.429 13.4896 19.761 12.8277 19.761 12.0142C19.761 11.1997 20.429 10.5378 21.25 10.5378C21.449 10.5378 21.64 10.4595 21.78 10.3208C21.921 10.1811 22 9.99183 22 9.79464L21.999 7.11733C21.999 4.85421 20.14 3.01318 17.856 3.01318H6.144C3.86 3.01318 2.001 4.85421 2.001 7.11733L2 9.88085C2 10.078 2.079 10.2673 2.22 10.407C2.36 10.5457 2.551 10.624 2.75 10.624C3.599 10.624 4.239 11.2215 4.239 12.0142C4.239 12.8277 3.571 13.4896 2.75 13.4896C2.336 13.4896 2 13.8225 2 14.2327V16.908C2 19.1712 3.858 21.0132 6.143 21.0132H17.857C20.142 21.0132 22 19.1712 22 16.908V14.2327C22 13.8225 21.664 13.4896 21.25 13.4896Z" fill="#8A92A6"/><path d="M15.4306 11.6019L14.2516 12.7499L14.5306 14.3729C14.5786 14.6539 14.4656 14.9309 14.2346 15.0969C14.0056 15.2649 13.7066 15.2859 13.4546 15.1519L11.9996 14.3869L10.5416 15.1529C10.4336 15.2099 10.3156 15.2399 10.1986 15.2399C10.0456 15.2399 9.89458 15.1919 9.76458 15.0979C9.53458 14.9309 9.42158 14.6539 9.46958 14.3729L9.74758 12.7499L8.56858 11.6019C8.36458 11.4039 8.29358 11.1129 8.38158 10.8419C8.47058 10.5719 8.70058 10.3799 8.98158 10.3399L10.6076 10.1029L11.3366 8.62587C11.4636 8.37187 11.7176 8.21387 11.9996 8.21387H12.0016C12.2846 8.21487 12.5386 8.37287 12.6636 8.62687L13.3926 10.1029L15.0216 10.3409C15.2996 10.3799 15.5296 10.5719 15.6176 10.8419C15.7066 11.1129 15.6356 11.4039 15.4306 11.6019Z" fill="#8A92A6"/></svg>
                    </div>
                    <div class="font-normal">
                        Pengaturan
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z" fill="#8A92A6"/>
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open" x-transition:enter="transition-transform transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-10%]" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#8A92A6]">
                <div>
                    <a href="{{ route('settings.change-password') }}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Ubah Password
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div x-data="{open:false}" class="py-3 px-3 border-b">
            <div @click="open=!open" class="text-[16px] text-[#8A92A6] flex justify-between items-center cursor-pointer hover:scale-105 duration-300">
                <div class="flex items-center gap-4 ">
                    <div>
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4" d="M12.0865 22.0132C11.9627 22.0132 11.8388 21.9847 11.7271 21.9269L8.12599 20.0628C7.10415 19.5333 6.30481 18.939 5.68063 18.2467C4.31449 16.7327 3.5544 14.7892 3.54232 12.7731L3.50004 6.13745C3.495 5.37161 3.98931 4.68421 4.72826 4.42534L11.3405 2.11997C11.7331 1.97975 12.1711 1.97779 12.5707 2.11311L19.2081 4.34003C19.9511 4.58811 20.4535 5.2706 20.4575 6.03546L20.4998 12.676C20.5129 14.6892 19.779 16.6405 18.434 18.1712C17.8168 18.8733 17.0245 19.4764 16.0128 20.0157L12.4439 21.922C12.3331 21.9818 12.2103 22.0122 12.0865 22.0132Z" fill="#8A92A6"/>
                            <path d="M11.3191 14.3341C11.1258 14.3351 10.9325 14.2655 10.7835 14.1223L8.86671 12.2788C8.57073 11.9924 8.56771 11.5277 8.86067 11.2394C9.15363 10.9501 9.63183 10.9471 9.92882 11.2325L11.308 12.5582L14.6756 9.23798C14.9695 8.9487 15.4477 8.94576 15.7437 9.23111C16.0407 9.51744 16.0437 9.98322 15.7508 10.2705L11.8517 14.1154C11.7047 14.2606 11.5124 14.3331 11.3191 14.3341Z" fill="#8A92A6"/>
                        </svg>
                    </div>
                    <div class="font-normal">
                        Variabel
                    </div>
                </div>
                <div>
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.599L7.70711 9.30608C7.31658 8.91555 6.68342 8.91555 6.29289 9.30608C5.90237 9.6966 5.90237 10.3298 6.29289 10.7203L11.2929 15.7203C11.6834 16.1108 12.3166 16.1108 12.7071 15.7203L17.7071 10.7203C18.0976 10.3298 18.0976 9.6966 17.7071 9.30608C17.3166 8.91555 16.6834 8.91555 16.2929 9.30608L12 13.599Z" fill="#8A92A6"/>
                    </svg>
                </div>
            </div>

            <div x-cloak x-show="open" x-transition:enter="transition-transform transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-10%]" x-transition:enter-end="opacity-100 translate-y-0" class="px-5 py-3 text-[#8A92A6]">
                <div>
                    <a href="{{route('settings.bbm-prices.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Harga BBM
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="{{route('settings.harbor-service-prices.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Harga Jasa Dermaga
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="{{route('settings.bbm-transport-prices.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Harga Angkut BBM
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="{{route('settings.price-area-taxes.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Besar Pajak Daerah
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="{{route('settings.price-kso-taxes.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Besar Pajak KSO
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="{{route('settings.electric-prices.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Tarif Listrik
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="{{route('settings.electric-kwh-prices.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Tarif KWH Meter
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="{{route('settings.ship-unload-prices.index')}}">
                        <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                            <div>
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                                </svg>
                            </div>
                            <div class="font-normal text-[16px]">
                                Tarif Ship Unloader
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
