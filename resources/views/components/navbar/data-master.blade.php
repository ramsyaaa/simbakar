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
                    Data Master
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
                <a href="{{ route('master-data.ships.index') }}">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Kapal
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="{{ route('master-data.suppliers.index') }}">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Pemasok
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="{{ route('master-data.ship-agents.index') }}">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Agen Kapal
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Perusahaan Bongkar Muat
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Transportir
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Pelabuhan Muat
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Surveyor
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Person in Charge
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Dermaga Suralaya
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Alat Besar
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Bunker BBM
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="#">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Unit
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="{{ route('master-data.load-type.index') }}">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Jenis Muatan
                        </div>
                    </div>
                </a>
            </div>
            <div>
                <a href="{{ route('master-data.docks.index') }}">
                    <div class="flex items-center gap-4 py-2 cursor-pointer hover:scale-105 duration-300">
                        <div>
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12.0005" r="5" fill="#8A92A6"/>
                            </svg>
                        </div>
                        <div class="font-normal text-[16px]">
                            Dermaga
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
