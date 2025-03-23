<div id="content">
    <header id="header" class="transition-all group">
        <nav class="fixed z-20 w-full overflow-hidden border-b border-gray-100 dark:border-gray-900 backdrop-blur-2xl">
            <div class="max-w-6xl px-6 m-auto ">
                <div class="flex flex-wrap items-center justify-between py-2 sm:py-4">
                    <div class="flex items-center justify-between w-full lg:w-auto">
                        @include('banner')
                        <div class="flex lg:hidden">
                            <button id="menu-btn" aria-label="open menu" class="btn variant-ghost sz-md icon-only relative z-20 -mr-2.5 block cursor-pointer lg:hidden">
                                <svg class="text-gray-950 dark:text-gray-50 m-auto size-6 transition-[transform,opacity] duration-300 group-data-[state=active]:rotate-180 group-data-[state=active]:scale-0 group-data-[state=active]:opacity-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"></path>
                                </svg>
                                <svg class="text-gray-950 dark:text-gray-50 absolute inset-0 m-auto size-6 -rotate-180 scale-0 opacity-0 transition-[transform,opacity] duration-300 group-data-[state=active]:rotate-0 group-data-[state=active]:scale-100 group-data-[state=active]:opacity-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="w-full group-data-[state=active]:h-fit h-0 lg:w-fit flex-wrap justify-end items-center space-y-8 lg:space-y-0 lg:flex lg:h-fit md:flex-nowrap">
                        <div class="mt-6 dark:text-gray-200 md:-ml-4 lg:pr-4 lg:mt-0">
                            @include('theme-switcher')
                        </div>
                        <div class="flex flex-col items-center w-full gap-2 pt-6 pb-4 space-y-2 border-t lg:pb-0 lg:flex-row lg:space-y-0 lg:w-fit lg:border-l lg:border-t-0 lg:pt-0 lg:pl-2 dark:border-gray-800">
                            @guest
                                <x-filament::button tag="a" href="{{ route('filament.auth.auth.login') }}" class="lg:ml-2" outlined>
                                    Login
                                </x-filament::button>

                                <x-filament::button tag="a" href="{{ route('filament.auth.auth.register') }}" >
                                    Sign up
                                </x-filament::button>
                            @else
                                <x-filament::button tag="a" href="{{ route('filament.auth.auth.register') }}" >
                                    Continue
                                </x-filament::button>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div id="home" class="transition-all duration-500 -translate-y-10 opacity-0">
        <main class="overflow-hidden">
            <section class="relative">
                <div class="relative pt-24 lg:pt-28">
                    <div class="px-6 mx-auto max-w-7xl md:px-12">
                        <div class="text-center sm:mx-auto sm:w-10/12 lg:mr-auto lg:mt-0 lg:w-4/5">
                            <h1 class="mt-8 text-wrap text-4xl md:text-5xl font-semibold xl:text-5xl xl:[line-height:1.125] text-gray-950 dark:text-gray-50">
                                Launch Your Helpdesk System <br class="hidden sm:block">  to New Heights
                            </h1>
                            <p class="hidden max-w-2xl mx-auto mt-8 text-lg text-gray-700 text-wrap sm:block dark:text-gray-200">
                                Try our new helpdesk system that helps you manage your organization's support requests with ease.
                            </p>
                            <p class="max-w-2xl mx-auto mt-6 text-gray-700 text-wrap sm:hidden dark:text-gray-200">
                                Try our new helpdesk system that helps you manage your organization's support requests with ease.
                            </p>
                            <div class="flex flex-col items-center justify-center gap-4 mt-8">
                                <div class="">
                                    <x-filament::button tag="a" outlined icon="gmdi-rocket-launch-o" size="xl" href="{{ route('filament.auth.auth.register') }}">
                                        Get started
                                    </x-filament::button>
                                </div>

                                <button class="hidden btn variant-ghost sz-lg">
                                    <span class="text-sm">Learn more</span>
                                    <svg class="-mr-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m19 12l12 12l-12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="pt-36">
                    <div class="max-w-6xl px-6 mx-auto">
                        <div class="relative">
                            <div class="relative z-10 grid grid-cols-6 gap-3">
                                <div class="relative flex p-6 overflow-hidden border rounded-3xl dark:border-gray-800 col-span-full lg:col-span-2">
                                    <div class="relative m-auto size-fit">
                                        <div class="relative flex items-center w-56 h-24">
                                            <svg class="absolute inset-0 size-full text-caption" viewBox="0 0 254 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M112.891 97.7022C140.366 97.0802 171.004 94.6715 201.087 87.5116C210.43 85.2881 219.615 82.6412 228.284 78.2473C232.198 76.3179 235.905 73.9942 239.348 71.3124C241.85 69.2557 243.954 66.7571 245.555 63.9408C249.34 57.3235 248.281 50.5341 242.498 45.6109C239.033 42.7237 235.228 40.2703 231.169 38.3054C219.443 32.7209 207.141 28.4382 194.482 25.534C184.013 23.1927 173.358 21.7755 162.64 21.2989C161.376 21.3512 160.113 21.181 158.908 20.796C158.034 20.399 156.857 19.1682 156.962 18.4535C157.115 17.8927 157.381 17.3689 157.743 16.9139C158.104 16.4588 158.555 16.0821 159.067 15.8066C160.14 15.4683 161.274 15.3733 162.389 15.5286C179.805 15.3566 196.626 18.8373 212.998 24.462C220.978 27.2494 228.798 30.4747 236.423 34.1232C240.476 36.1159 244.202 38.7131 247.474 41.8258C254.342 48.2578 255.745 56.9397 251.841 65.4892C249.793 69.8582 246.736 73.6777 242.921 76.6327C236.224 82.0192 228.522 85.4602 220.502 88.2924C205.017 93.7847 188.964 96.9081 172.738 99.2109C153.442 101.949 133.993 103.478 114.506 103.79C91.1468 104.161 67.9334 102.97 45.1169 97.5831C36.0094 95.5616 27.2626 92.1655 19.1771 87.5116C13.839 84.5746 9.1557 80.5802 5.41318 75.7725C-0.54238 67.7259 -1.13794 59.1763 3.25594 50.2827C5.82447 45.3918 9.29572 41.0315 13.4863 37.4319C24.2989 27.5721 37.0438 20.9681 50.5431 15.7272C68.1451 8.8849 86.4883 5.1395 105.175 2.83669C129.045 0.0992292 153.151 0.134761 177.013 2.94256C197.672 5.23215 218.04 9.01724 237.588 16.3889C240.089 17.3418 242.498 18.5197 244.933 19.6446C246.627 20.4387 247.725 21.6695 246.997 23.615C246.455 25.1105 244.814 25.5605 242.63 24.5811C230.322 18.9961 217.233 16.1904 204.117 13.4376C188.761 10.3438 173.2 8.36665 157.558 7.52174C129.914 5.70776 102.154 8.06792 75.2124 14.5228C60.6177 17.8788 46.5758 23.2977 33.5102 30.6161C26.6595 34.3329 20.4123 39.0673 14.9818 44.658C12.9433 46.8071 11.1336 49.1622 9.58207 51.6855C4.87056 59.5336 5.61172 67.2494 11.9246 73.7608C15.2064 77.0494 18.8775 79.925 22.8564 82.3236C31.6176 87.7101 41.3848 90.5291 51.3902 92.5804C70.6068 96.5773 90.0219 97.7419 112.891 97.7022Z" fill="currentColor"/>
                                            </svg>
                                            <span class="block mx-auto text-5xl font-semibold text-transparent w-fit bg-clip-text bg-gradient-to-br from-amber-300 to-amber-700 dark:from-amber-400 dark:to-amber-700">
                                                100%
                                            </span>
                                        </div>
                                        <h2 class="mt-6 text-3xl font-semibold text-center text-gray-800 transition dark:text-gray-50 group-hover:text-secondary-950">
                                            Transparent
                                        </h2>
                                    </div>
                                </div>
                                <div class="relative p-6 overflow-hidden border rounded-3xl dark:border-gray-800 col-span-full sm:col-span-3 lg:col-span-2 ">
                                    <div>
                                        <div class="relative flex mx-auto border rounded-full aspect-square size-32 dark:bg-white/5 dark:border-white/10 before:absolute before:-inset-2 before:border dark:before:border-white/5 dark:before:bg-white/5 before:rounded-full">
                                            <svg class="w-24 m-auto h-fit" viewBox="0 0 212 143" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path class="text-gray-400 dark:text-gray-600" d="M44.0209 55.3542C43.1945 54.7639 42.6916 54.0272 42.5121 53.1442C42.3327 52.2611 42.5995 51.345 43.3125 50.3958C50.632 40.3611 59.812 32.5694 70.8525 27.0208C81.8931 21.4722 93.668 18.6979 106.177 18.6979C118.691 18.6979 130.497 21.3849 141.594 26.7587C152.691 32.1326 161.958 39.8936 169.396 50.0417C170.222 51.1042 170.489 52.0486 170.196 52.875C169.904 53.7014 169.401 54.4097 168.688 55C167.979 55.5903 167.153 55.8571 166.208 55.8004C165.264 55.7437 164.438 55.2408 163.729 54.2917C157.236 45.0833 148.885 38.0307 138.675 33.1337C128.466 28.2368 117.633 25.786 106.177 25.7812C94.7257 25.7812 83.9827 28.2321 73.948 33.1337C63.9132 38.0354 55.5903 45.0881 48.9792 54.2917C48.2709 55.3542 47.4445 55.9444 46.5 56.0625C45.5556 56.1806 44.7292 55.9444 44.0209 55.3542ZM126.188 142.656C113.91 139.587 103.875 133.476 96.0834 124.325C88.2917 115.173 84.3959 103.988 84.3959 90.7708C84.3959 84.8681 86.5209 79.9097 90.7709 75.8958C95.0209 71.8819 100.156 69.875 106.177 69.875C112.198 69.875 117.333 71.8819 121.583 75.8958C125.833 79.9097 127.958 84.8681 127.958 90.7708C127.958 94.6667 129.434 97.9439 132.385 100.602C135.337 103.261 138.819 104.588 142.833 104.583C146.847 104.583 150.271 103.256 153.104 100.602C155.938 97.9486 157.354 94.6714 157.354 90.7708C157.354 77.0764 152.337 65.566 142.302 56.2396C132.267 46.9132 120.285 42.25 106.354 42.25C92.4237 42.25 80.441 46.9132 70.4063 56.2396C60.3716 65.566 55.3542 77.0174 55.3542 90.5937C55.3542 93.4271 55.621 96.9687 56.1546 101.219C56.6882 105.469 57.9562 110.427 59.9584 116.094C60.3125 117.156 60.2842 118.101 59.8734 118.927C59.4625 119.753 58.7825 120.344 57.8334 120.698C56.8889 121.052 55.9752 121.024 55.0921 120.613C54.2091 120.202 53.5881 119.522 53.2292 118.573C51.4584 113.969 50.1905 109.395 49.4255 104.853C48.6605 100.31 48.2756 95.6158 48.2709 90.7708C48.2709 75.0694 53.9682 61.9062 65.363 51.2812C76.7577 40.6562 90.3624 35.3437 106.177 35.3437C122.115 35.3437 135.809 40.6562 147.26 51.2812C158.712 61.9062 164.438 75.0694 164.438 90.7708C164.438 96.6736 162.343 101.601 158.155 105.554C153.966 109.506 148.859 111.485 142.833 111.49C136.813 111.49 131.649 109.513 127.342 105.561C123.035 101.608 120.88 96.6783 120.875 90.7708C120.875 86.875 119.43 83.5978 116.54 80.9392C113.65 78.2805 110.196 76.9536 106.177 76.9583C102.163 76.9583 98.7089 78.2876 95.8142 80.9462C92.9195 83.6049 91.4745 86.8797 91.4792 90.7708C91.4792 102.222 94.8745 111.785 101.665 119.458C108.456 127.132 117.22 132.503 127.958 135.573C129.021 135.927 129.729 136.517 130.083 137.344C130.438 138.17 130.497 139.056 130.26 140C130.024 140.826 129.552 141.535 128.844 142.125C128.135 142.715 127.25 142.892 126.188 142.656ZM67.0417 18.3437C66.0973 18.934 65.1528 19.0828 64.2084 18.79C63.2639 18.4972 62.5556 17.8762 62.0834 16.9271C61.6112 15.9826 61.4931 15.1279 61.7292 14.3629C61.9653 13.5979 62.5556 12.9179 63.5 12.3229C70.1112 8.78125 77.0174 6.06597 84.2188 4.17708C91.4202 2.28819 98.7396 1.34375 106.177 1.34375C113.733 1.34375 121.111 2.25986 128.313 4.09208C135.514 5.92431 142.479 8.54986 149.208 11.9687C150.271 12.559 150.892 13.2674 151.071 14.0937C151.251 14.9201 151.161 15.7465 150.802 16.5729C150.448 17.3993 149.858 18.0486 149.031 18.5208C148.205 18.9931 147.201 18.934 146.021 18.3437C139.764 15.1563 133.299 12.7078 126.627 10.9983C119.954 9.28889 113.138 8.43181 106.177 8.42708C99.3299 8.42708 92.6007 9.22514 85.9896 10.8212C79.3785 12.4174 73.0625 14.9249 67.0417 18.3437ZM87.9375 140.177C80.9723 132.858 75.6314 125.392 71.915 117.78C68.1987 110.167 66.3381 101.164 66.3334 90.7708C66.3334 80.0278 70.2292 70.9658 78.0209 63.585C85.8125 56.2042 95.198 52.5161 106.177 52.5208C117.156 52.5208 126.601 56.2112 134.51 63.5921C142.42 70.9729 146.375 80.0325 146.375 90.7708C146.375 91.8333 146.052 92.6904 145.405 93.3421C144.758 93.9937 143.901 94.3172 142.833 94.3125C141.889 94.3125 141.063 93.989 140.354 93.3421C139.646 92.6951 139.292 91.8381 139.292 90.7708C139.292 81.9167 136.014 74.5099 129.46 68.5504C122.906 62.591 115.145 59.6089 106.177 59.6042C97.2049 59.6042 89.503 62.5862 83.0713 68.5504C76.6396 74.5146 73.4214 81.9214 73.4167 90.7708C73.4167 100.333 75.0695 108.451 78.375 115.123C81.6806 121.796 86.5209 128.494 92.8959 135.219C93.6042 135.927 93.9584 136.753 93.9584 137.698C93.9584 138.642 93.6042 139.469 92.8959 140.177C92.1875 140.885 91.3612 141.24 90.4167 141.24C89.4723 141.24 88.6459 140.885 87.9375 140.177ZM141.417 128.135C130.91 128.135 121.789 124.594 114.054 117.51C106.319 110.427 102.454 101.514 102.458 90.7708C102.458 89.8264 102.784 89 103.436 88.2917C104.088 87.5833 104.942 87.2292 106 87.2292C107.063 87.2292 107.92 87.5833 108.571 88.2917C109.223 89 109.546 89.8264 109.542 90.7708C109.542 99.625 112.729 106.885 119.104 112.552C125.479 118.219 132.917 121.052 141.417 121.052C142.125 121.052 143.129 120.993 144.427 120.875C145.726 120.757 147.083 120.58 148.5 120.344C149.563 120.108 150.479 120.256 151.248 120.79C152.018 121.324 152.519 122.119 152.75 123.177C152.986 124.122 152.809 124.948 152.219 125.656C151.629 126.365 150.861 126.837 149.917 127.073C147.792 127.663 145.934 127.989 144.342 128.05C142.751 128.112 141.776 128.14 141.417 128.135Z" fill="currentColor"/>
                                                <g clip-path="url(#clip0_0_1)">
                                                    <path d="M44.0209 55.3542C43.1945 54.7639 42.6916 54.0272 42.5121 53.1442C42.3327 52.2611 42.5995 51.345 43.3125 50.3958C50.632 40.3611 59.812 32.5694 70.8525 27.0208C81.8931 21.4722 93.668 18.6979 106.177 18.6979C118.691 18.6979 130.497 21.3849 141.594 26.7587C152.691 32.1326 161.958 39.8936 169.396 50.0417C170.222 51.1042 170.489 52.0486 170.196 52.875C169.904 53.7014 169.401 54.4097 168.688 55C167.979 55.5903 167.153 55.8571 166.208 55.8004C165.264 55.7437 164.438 55.2408 163.729 54.2917C157.236 45.0833 148.885 38.0307 138.675 33.1337C128.466 28.2368 117.633 25.786 106.177 25.7812C94.7257 25.7812 83.9827 28.2321 73.948 33.1337C63.9132 38.0354 55.5903 45.0881 48.9792 54.2917C48.2709 55.3542 47.4445 55.9444 46.5 56.0625C45.5556 56.1806 44.7292 55.9444 44.0209 55.3542ZM126.188 142.656C113.91 139.587 103.875 133.476 96.0834 124.325C88.2917 115.173 84.3959 103.988 84.3959 90.7708C84.3959 84.8681 86.5209 79.9097 90.7709 75.8958C95.0209 71.8819 100.156 69.875 106.177 69.875C112.198 69.875 117.333 71.8819 121.583 75.8958C125.833 79.9097 127.958 84.8681 127.958 90.7708C127.958 94.6667 129.434 97.9439 132.385 100.602C135.337 103.261 138.819 104.588 142.833 104.583C146.847 104.583 150.271 103.256 153.104 100.602C155.938 97.9486 157.354 94.6714 157.354 90.7708C157.354 77.0764 152.337 65.566 142.302 56.2396C132.267 46.9132 120.285 42.25 106.354 42.25C92.4237 42.25 80.441 46.9132 70.4063 56.2396C60.3716 65.566 55.3542 77.0174 55.3542 90.5937C55.3542 93.4271 55.621 96.9687 56.1546 101.219C56.6882 105.469 57.9562 110.427 59.9584 116.094C60.3125 117.156 60.2842 118.101 59.8734 118.927C59.4625 119.753 58.7825 120.344 57.8334 120.698C56.8889 121.052 55.9752 121.024 55.0921 120.613C54.2091 120.202 53.5881 119.522 53.2292 118.573C51.4584 113.969 50.1905 109.395 49.4255 104.853C48.6605 100.31 48.2756 95.6158 48.2709 90.7708C48.2709 75.0694 53.9682 61.9062 65.363 51.2812C76.7577 40.6562 90.3624 35.3437 106.177 35.3437C122.115 35.3437 135.809 40.6562 147.26 51.2812C158.712 61.9062 164.438 75.0694 164.438 90.7708C164.438 96.6736 162.343 101.601 158.155 105.554C153.966 109.506 148.859 111.485 142.833 111.49C136.813 111.49 131.649 109.513 127.342 105.561C123.035 101.608 120.88 96.6783 120.875 90.7708C120.875 86.875 119.43 83.5978 116.54 80.9392C113.65 78.2805 110.196 76.9536 106.177 76.9583C102.163 76.9583 98.7089 78.2876 95.8142 80.9462C92.9195 83.6049 91.4745 86.8797 91.4792 90.7708C91.4792 102.222 94.8745 111.785 101.665 119.458C108.456 127.132 117.22 132.503 127.958 135.573C129.021 135.927 129.729 136.517 130.083 137.344C130.438 138.17 130.497 139.056 130.26 140C130.024 140.826 129.552 141.535 128.844 142.125C128.135 142.715 127.25 142.892 126.188 142.656ZM67.0417 18.3437C66.0973 18.934 65.1528 19.0828 64.2084 18.79C63.2639 18.4972 62.5556 17.8762 62.0834 16.9271C61.6112 15.9826 61.4931 15.1279 61.7292 14.3629C61.9653 13.5979 62.5556 12.9179 63.5 12.3229C70.1112 8.78125 77.0174 6.06597 84.2188 4.17708C91.4202 2.28819 98.7396 1.34375 106.177 1.34375C113.733 1.34375 121.111 2.25986 128.313 4.09208C135.514 5.92431 142.479 8.54986 149.208 11.9687C150.271 12.559 150.892 13.2674 151.071 14.0937C151.251 14.9201 151.161 15.7465 150.802 16.5729C150.448 17.3993 149.858 18.0486 149.031 18.5208C148.205 18.9931 147.201 18.934 146.021 18.3437C139.764 15.1563 133.299 12.7078 126.627 10.9983C119.954 9.28889 113.138 8.43181 106.177 8.42708C99.3299 8.42708 92.6007 9.22514 85.9896 10.8212C79.3785 12.4174 73.0625 14.9249 67.0417 18.3437ZM87.9375 140.177C80.9723 132.858 75.6314 125.392 71.915 117.78C68.1987 110.167 66.3381 101.164 66.3334 90.7708C66.3334 80.0278 70.2292 70.9658 78.0209 63.585C85.8125 56.2042 95.198 52.5161 106.177 52.5208C117.156 52.5208 126.601 56.2112 134.51 63.5921C142.42 70.9729 146.375 80.0325 146.375 90.7708C146.375 91.8333 146.052 92.6904 145.405 93.3421C144.758 93.9937 143.901 94.3172 142.833 94.3125C141.889 94.3125 141.063 93.989 140.354 93.3421C139.646 92.6951 139.292 91.8381 139.292 90.7708C139.292 81.9167 136.014 74.5099 129.46 68.5504C122.906 62.591 115.145 59.6089 106.177 59.6042C97.2049 59.6042 89.503 62.5862 83.0713 68.5504C76.6396 74.5146 73.4214 81.9214 73.4167 90.7708C73.4167 100.333 75.0695 108.451 78.375 115.123C81.6806 121.796 86.5209 128.494 92.8959 135.219C93.6042 135.927 93.9584 136.753 93.9584 137.698C93.9584 138.642 93.6042 139.469 92.8959 140.177C92.1875 140.885 91.3612 141.24 90.4167 141.24C89.4723 141.24 88.6459 140.885 87.9375 140.177ZM141.417 128.135C130.91 128.135 121.789 124.594 114.054 117.51C106.319 110.427 102.454 101.514 102.458 90.7708C102.458 89.8264 102.784 89 103.436 88.2917C104.088 87.5833 104.942 87.2292 106 87.2292C107.063 87.2292 107.92 87.5833 108.571 88.2917C109.223 89 109.546 89.8264 109.542 90.7708C109.542 99.625 112.729 106.885 119.104 112.552C125.479 118.219 132.917 121.052 141.417 121.052C142.125 121.052 143.129 120.993 144.427 120.875C145.726 120.757 147.083 120.58 148.5 120.344C149.563 120.108 150.479 120.256 151.248 120.79C152.018 121.324 152.519 122.119 152.75 123.177C152.986 124.122 152.809 124.948 152.219 125.656C151.629 126.365 150.861 126.837 149.917 127.073C147.792 127.663 145.934 127.989 144.342 128.05C142.751 128.112 141.776 128.14 141.417 128.135Z" fill="url(#paint0_linear_0_1)"/>
                                                </g>
                                                <path class="text-amber-600 dark:text-amber-500" d="M3 72H209" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
                                                <defs>
                                                <linearGradient id="paint0_linear_0_1" x1="106.385" y1="1.34375" x2="106" y2="72" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="white" stop-opacity="0" style="stop-color:none;stop-opacity:0;"/>
                                                <stop class="text-amber-600 dark:text-amber-500" offset="1" stop-color="currentColor"/>
                                                </linearGradient>
                                                <clipPath id="clip0_0_1">
                                                <rect width="129" height="72" fill="white" style="fill:white;fill-opacity:1;" transform="translate(41)"/>
                                                </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="relative z-10 mt-6 space-y-2 text-center">
                                            <h2 class="text-lg font-medium transition group-hover:text-secondary-950 dark:text-white">Secure by default</h2>
                                            <p class="text-gray-700 transition dark:text-gray-300">
                                                The security of your data is our top priority. Helpdesk is designed to be secure by default, with built-in security features that protect your data and keep it safe.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative p-6 overflow-hidden border rounded-3xl dark:border-gray-800 col-span-full sm:col-span-3 lg:col-span-2 ">
                                    <div>
                                        <div class="justify-center pt-6 text-center align-middle lg:px-6">
                                            <x-filament::icon icon="gmdi-auto-fix-high-o" class="mx-auto size-24 text-caption" />

                                            <p class="block mx-auto text-2xl font-semibold text-transparent w-fit bg-clip-text bg-gradient-to-br from-amber-300 to-amber-700 dark:from-amber-400 dark:to-amber-700">
                                                Seamless Support <br> Effortless Management
                                            </p>
                                        </div>
                                        <div class="relative z-10 mt-6 space-y-2 text-center">
                                            <h2 class="text-lg font-medium transition group-hover:text-secondary-950"></h2>
                                            <p class="text-gray-700 transition dark:text-gray-300">
                                                Stay organized and in control — our system streamlines every request, so nothing falls through the cracks.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative p-6 overflow-hidden border rounded-3xl dark:border-gray-800 col-span-full lg:col-span-3 ">
                                    <div class="grid sm:grid-cols-2">
                                        <div class="relative z-10 flex flex-col justify-between space-y-12 lg:space-y-6">
                                            <div class="relative flex border rounded-full aspect-square size-12 dark:bg-white/5 dark:border-white/10 before:absolute before:-inset-2 before:border dark:before:border-white/5 dark:before:bg-white/5 before:rounded-full">
                                                <svg class="m-auto size-6" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linejoin="round" d="M5.5 7c2 0 6.5-3 6.5-3s4.5 3 6.5 3v4.5C18.5 18 12 20 12 20s-6.5-2-6.5-8.5z"/>
                                                </svg>
                                             </div>
                                            <div class="space-y-2">
                                                <h2 class="text-lg font-medium text-gray-800 transition group-hover:text-secondary-950 dark:text-white">Unbreakable Workflow</h2>
                                                <p class="text-gray-700 transition dark:text-gray-300">
                                                    No bottlenecks, no disruptions.
                                                    A system designed to keep your requests moving forward.
                                                </p>
                                            </div>
                                        </div>
                                        <div data-rounded="large" class="relative mt-6 sm:mt-auto h-fit -mb-[calc(var(--card-padding)+1px)] -mr-[calc(var(--card-padding)+1px)] sm:ml-6 py-6 p-6  ">
                                            <div class="absolute flex gap-1 top-2 left-3">
                                                <span class="block border rounded-full size-2 dark:border-white/10 dark:bg-white/10"></span>
                                                <span class="block border rounded-full size-2 dark:border-white/10 dark:bg-white/10"></span>
                                                <span class="block border rounded-full size-2 dark:border-white/10 dark:bg-white/10"></span>
                                            </div>
                                            <svg class="w-full sm:w-[150%]" viewBox="0 0 366 231" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.148438 231V179.394L1.92188 180.322L2.94482 177.73L4.05663 183.933L6.77197 178.991L7.42505 184.284L9.42944 187.985L11.1128 191.306V155.455L13.6438 153.03V145.122L14.2197 142.829V150.454V154.842L15.5923 160.829L17.0793 172.215H19.2031V158.182L20.7441 153.03L22.426 148.111V142.407L24.7471 146.86V128.414L26.7725 129.918V120.916L28.1492 118.521L28.4653 127.438L29.1801 123.822L31.0426 120.525V130.26L32.3559 134.71L34.406 145.122V137.548L35.8982 130.26L37.1871 126.049L38.6578 134.71L40.659 138.977V130.26V126.049L43.7557 130.26V123.822L45.972 112.407L47.3391 103.407V92.4726L49.2133 98.4651V106.053L52.5797 89.7556L54.4559 82.7747L56.1181 87.9656L58.9383 89.7556V98.4651L60.7617 103.407L62.0545 123.822L63.8789 118.066L65.631 122.082L68.5479 114.229L70.299 109.729L71.8899 118.066L73.5785 123.822V130.26L74.9446 134.861L76.9243 127.87L78.352 134.71V138.977L80.0787 142.407V152.613L83.0415 142.407V130.26L86.791 123.822L89.0121 116.645V122.082L90.6059 127.87L92.3541 131.77L93.7104 123.822L95.4635 118.066L96.7553 122.082V137.548L99.7094 140.988V131.77L101.711 120.525L103.036 116.645V133.348L104.893 136.218L106.951 140.988L108.933 134.71L110.797 130.26L112.856 140.988V148.111L115.711 152.613L117.941 145.122L119.999 140.988V148.111L123.4 152.613L125.401 158.182L130.547 150.454V156.566L131.578 155.455L134.143 158.182L135.594 168.136L138.329 158.182L140.612 160.829L144.681 169.5L147.011 155.455L148.478 151.787L151.02 152.613L154.886 145.122L158 143.412L159.406 140.637L159.496 133.348L162.295 127.87V122.082L163.855 116.645V109.729L164.83 104.407L166.894 109.729L176.249 98.4651L178.254 106.169L180.77 98.4651V81.045L182.906 69.1641L184.8 56.8669L186.477 62.8428L187.848 79.7483L188.849 106.169L191.351 79.7483L193.485 75.645V98.4651L196.622 94.4523L198.623 87.4228V79.7483L200.717 75.645L202.276 81.045V89.3966L203.638 113.023L205.334 99.8037L207.164 94.4523L208.982 98.4651V102.176L211.267 107.64L212.788 81.045L214.437 66.0083L216.19 62.8428L217.941 56.8669V73.676V79.7483L220.28 75.645L222.516 66.0083V73.676H226.174V84.8662L228.566 98.4651L230.316 75.645L233.61 94.4523V104.25L236.882 102.176L239.543 113.023L241.057 98.4651L243.604 94.4523L244.975 106.169L245.975 87.4228L247.272 89.3966L250.732 84.8662L251.733 96.7549L254.644 94.4523L257.452 99.8037L259.853 91.3111L261.193 84.8662L264.162 75.645L265.808 87.4228L267.247 58.4895L269.757 66.0083L276.625 13.5146L273.33 58.4895L276.25 67.6563L282.377 20.1968L281.37 58.4895V66.0083L283.579 75.645L286.033 56.8669L287.436 73.676L290.628 77.6636L292.414 84.8662L294.214 61.3904L296.215 18.9623L300.826 0.947876L297.531 56.8669L299.973 62.8428L305.548 22.0598L299.755 114.956L301.907 105.378L304.192 112.688V94.9932L308.009 80.0829L310.003 94.9932L311.004 102.127L312.386 105.378L315.007 112.688L316.853 98.004L318.895 105.378L321.257 94.9932L324.349 100.81L325.032 80.0829L327.604 61.5733L329.308 82.3223L333.525 52.7986L334.097 52.145L334.735 55.6812L337.369 59.8108V73.676L340.743 87.9656L343.843 96.3728L348.594 82.7747L349.607 81.045L351 89.7556L352.611 96.3728L355.149 94.9932L356.688 102.176L359.396 108.784L360.684 111.757L365 95.7607V231H148.478H0.148438Z" fill="url(#paint0_linear_0_705)"/>
                                                <path class="text-amber-600 dark:text-amber-500" d="M1 179.796L4.05663 172.195V183.933L7.20122 174.398L8.45592 183.933L10.0546 186.948V155.455L12.6353 152.613V145.122L15.3021 134.71V149.804V155.455L16.6916 160.829L18.1222 172.195V158.182L19.8001 152.613L21.4105 148.111V137.548L23.6863 142.407V126.049L25.7658 127.87V120.525L27.2755 118.066L29.1801 112.407V123.822L31.0426 120.525V130.26L32.3559 134.71L34.406 145.122V137.548L35.8982 130.26L37.1871 126.049L38.6578 134.71L40.659 138.977V130.26V126.049L43.7557 130.26V123.822L45.972 112.407L47.3391 103.407V92.4726L49.2133 98.4651V106.053L52.5797 89.7556L54.4559 82.7747L56.1181 87.9656L58.9383 89.7556V98.4651L60.7617 103.407L62.0545 123.822L63.8789 118.066L65.631 122.082L68.5479 114.229L70.299 109.729L71.8899 118.066L73.5785 123.822V130.26L74.9446 134.861L76.9243 127.87L78.352 134.71V138.977L80.0787 142.407V152.613L83.0415 142.407V130.26L86.791 123.822L89.0121 116.645V122.082L90.6059 127.87L92.3541 131.77L93.7104 123.822L95.4635 118.066L96.7553 122.082V137.548L99.7094 140.988V131.77L101.711 120.525L103.036 116.645V133.348L104.893 136.218L106.951 140.988L108.933 134.71L110.797 130.26L112.856 140.988V148.111L115.711 152.613L117.941 145.122L119.999 140.988L121.501 148.111L123.4 152.613L125.401 158.182L127.992 152.613L131.578 146.76V155.455L134.143 158.182L135.818 164.629L138.329 158.182L140.612 160.829L144.117 166.757L146.118 155.455L147.823 149.804L151.02 152.613L154.886 145.122L158.496 140.988V133.348L161.295 127.87V122.082L162.855 116.645V109.729L164.83 103.407L166.894 109.729L176.249 98.4651L178.254 106.169L180.77 98.4651V81.045L182.906 69.1641L184.8 56.8669L186.477 62.8428L187.848 79.7483L188.849 106.169L191.351 79.7483L193.485 75.645V98.4651L196.622 94.4523L198.623 87.4228V79.7483L200.717 75.645L202.276 81.045V89.3966L203.638 113.023L205.334 99.8037L207.164 94.4523L208.982 98.4651V102.176L211.267 107.64L212.788 81.045L214.437 66.0083L216.19 62.8428L217.941 56.8669V73.676V79.7483L220.28 75.645L222.516 66.0083V73.676H226.174V84.8662L228.566 98.4651L230.316 75.645L233.61 94.4523V104.25L236.882 102.176L239.543 113.023L241.057 98.4651L243.604 94.4523L244.975 106.169L245.975 87.4228L247.272 89.3966L250.732 84.8662L251.733 96.7549L254.644 94.4523L257.452 99.8037L259.853 91.3111L261.193 84.8662L264.162 75.645L265.808 87.4228L267.247 58.4895L269.757 66.0083L276.625 13.5146L273.33 58.4895L276.25 67.6563L282.377 20.1968L281.37 58.4895V66.0083L283.579 75.645L286.033 56.8669L287.436 73.676L290.628 77.6636L292.414 84.8662L294.214 61.3904L296.215 18.9623L300.826 0.947876L297.531 56.8669L299.973 62.8428L305.548 22.0598L299.755 114.956L301.907 105.378L304.192 112.688V94.9932L308.009 80.0829L310.003 94.9932L311.004 102.127L312.386 105.378L315.007 112.688L316.853 98.004L318.895 105.378L321.257 94.9932L324.349 100.81L325.032 80.0829L327.604 61.5733L329.357 74.9864L332.611 52.6565L334.352 48.5552L335.785 55.2637L338.377 59.5888V73.426L341.699 87.5181L343.843 93.4347L347.714 82.1171L350.229 78.6821L351.974 89.7556L353.323 94.9932L355.821 93.4347L357.799 102.127L360.684 108.794L363.219 98.004L365 89.7556" stroke="currentColor" stroke-width="2"/>
                                                <defs>
                                                <linearGradient id="paint0_linear_0_705" x1="0.85108" y1="0.947876" x2="0.85108" y2="230.114" gradientUnits="userSpaceOnUse">
                                                <stop class="text-amber-500/20 dark:text-amber-500/50" stop-color="currentColor"/>
                                                <stop class="text-transparent" offset="1" stop-color="currentColor" stop-opacity="0.01"/>
                                                </linearGradient>
                                                </defs>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative p-6 overflow-hidden border rounded-3xl dark:border-gray-800 col-span-full lg:col-span-3 ">
                                    <div class="grid h-full sm:grid-cols-2">
                                        <div class="relative z-10 flex flex-col justify-between space-y-12 lg:space-y-6">
                                             <div class="relative flex border rounded-full aspect-square size-12 dark:bg-white/5 dark:border-white/10 before:absolute before:-inset-2 before:border dark:before:border-white/5 dark:before:bg-white/5 before:rounded-full">
                                                <svg class="m-auto size-6" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                                    <g fill="none">
                                                        <path stroke="currentColor" d="M9 6a3 3 0 1 0 6 0a3 3 0 0 0-6 0zm-4.562 7.902a3 3 0 1 0 3 5.195a3 3 0 0 0-3-5.196zm15.124 0a2.999 2.999 0 1 1-2.998 5.194a2.999 2.999 0 0 1 2.998-5.194z"/>
                                                        <path fill="currentColor" fill-rule="evenodd" d="M9.003 6.125a2.993 2.993 0 0 1 .175-1.143a8.507 8.507 0 0 0-5.031 4.766a8.5 8.5 0 0 0-.502 4.817a3 3 0 0 1 .902-.723a7.498 7.498 0 0 1 4.456-7.717m5.994 0a7.499 7.499 0 0 1 4.456 7.717a2.998 2.998 0 0 1 .902.723a8.5 8.5 0 0 0-5.533-9.583a3 3 0 0 1 .175 1.143m2.536 13.328a3.002 3.002 0 0 1-1.078-.42a7.501 7.501 0 0 1-8.91 0l-.107.065a3 3 0 0 1-.971.355a8.5 8.5 0 0 0 11.066 0" clip-rule="evenodd"/>
                                                    </g>
                                                </svg>
                                             </div>
                                            <div class="space-y-2">
                                                <h2 class="text-lg font-medium transition">Monitor request updates</h2>
                                                <p class="">
                                                    Keep track of your requests and get notified of its progress.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-6 relative sm:-mr-[--card-padding] sm:-my-[--card-padding] before:absolute before:w-px before:inset-0 before:mx-auto before:bg-gray-500">
                                            <div class="relative flex flex-col justify-center h-full py-6 space-y-5">
                                                <div class="flex items-center justify-end gap-2 w-[calc(50%+0.875rem)] relative">
                                                    <span class="block px-2 py-1 text-xs text-gray-200 bg-gray-600 rounded-lg shadow-sm h-fit dark:bg-gray-300 dark:text-gray-700 ">
                                                        Submitted
                                                    </span>
                                                    <div class="p-1 rounded-full size-7 ring-4 ring-gray-50 dark:ring-gray-950 bg-gray-50 dark:bg-gray-950">
                                                        <x-filament::icon
                                                            :icon="App\Enums\ActionStatus::SUBMITTED->getIcon()"
                                                            class="text-amber-500"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 ml-[calc(50%-1rem)] relative">
                                                    <div class="rounded-full size-8 ring-4 ring-gray-50 dark:ring-gray-950 p-1.5 bg-gray-50 dark:bg-gray-950">
                                                        <x-filament::icon
                                                            :icon="App\Enums\ActionStatus::QUEUED->getIcon()"
                                                            class="text-amber-500"
                                                        />
                                                    </div>
                                                    <span class="block px-2 py-1 text-xs text-gray-200 bg-gray-600 rounded-lg shadow-sm h-fit dark:bg-gray-300 dark:text-gray-700 ">
                                                        Queued
                                                    </span>
                                                </div>
                                                <div class="flex items-center justify-end gap-2 w-[calc(50%+0.875rem)] relative">
                                                    <span class="block px-2 py-1 text-xs text-gray-200 bg-gray-600 rounded-lg shadow-sm h-fit dark:bg-gray-300 dark:text-gray-700 ">
                                                        Assigned
                                                    </span>
                                                    <div class="p-1 rounded-full size-7 ring-4 ring-gray-50 dark:ring-gray-950 bg-gray-50 dark:bg-gray-950">
                                                        <x-filament::icon
                                                            :icon="App\Enums\ActionStatus::ASSIGNED->getIcon()"
                                                            class="text-amber-500"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 ml-[calc(50%-1rem)] relative">
                                                    <div class="rounded-full size-8 ring-4 ring-gray-50 dark:ring-gray-950 p-1.5 bg-gray-50 dark:bg-gray-950">
                                                        <x-filament::icon
                                                            :icon="App\Enums\ActionStatus::STARTED->getIcon()"
                                                            class="text-amber-500"
                                                        />
                                                    </div>
                                                    <span class="block px-2 py-1 text-xs text-gray-200 bg-gray-600 rounded-lg shadow-sm h-fit dark:bg-gray-300 dark:text-gray-700 ">
                                                        Started
                                                    </span>
                                                </div>
                                                <div class="flex items-center justify-end gap-2 w-[calc(50%+0.875rem)] relative">
                                                    <span class="block px-2 py-1 text-xs text-gray-200 bg-gray-600 rounded-lg shadow-sm h-fit dark:bg-gray-300 dark:text-gray-700 ">
                                                        Resolved
                                                    </span>
                                                    <div class="p-1 rounded-full size-7 ring-4 ring-gray-50 dark:ring-gray-950 bg-gray-50 dark:bg-gray-950">
                                                        <x-filament::icon
                                                            :icon="App\Enums\ActionResolution::RESOLVED->getIcon()"
                                                            class="text-amber-500"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="pt-36">
                    <div class="max-w-6xl px-6 mx-auto">
                        <div class="grid items-center gap-12 md:gap-0 md:grid-cols-2 lg:gap-12">
                            <div class="lg:pr-24">
                                <div class="md:pr-6 lg:pr-0">
                                    <h2 class="text-3xl font-semibold text-gray-950 dark:text-gray-50">
                                        Do you want helpdesk setup for your organization?
                                    </h2>
                                    <p class="mt-6 text-gray-700 dark:text-gray-200">
                                        Sign up now and tell us everything about your organization. We will help you to setup helpdesk for your needs.
                                    </p>
                                </div>
                                <ul class="mt-8 *:py-3 *:flex *:items-center *:gap-3">
                                    <li class="border-t border-gray-200 dark:border-gray-900">
                                        <x-filament::icon class="size-5 text-amber-500" icon="gmdi-email-o" />
                                        Get verified
                                    </li>
                                    <li class="border-t border-gray-200 dark:border-gray-900">
                                        <x-filament::icon class="size-5 text-amber-500" icon="gmdi-verified-o" />
                                        Wait for approval
                                    </li>
                                    <li class="border-t border-gray-200 dark:border-gray-900">
                                        <x-filament::icon class="size-5 text-amber-500" icon="gmdi-settings-suggest-o" />
                                        Setup your organization
                                    </li>
                                    <li class="border-gray-200 border-y dark:border-gray-900">
                                        <x-filament::icon class="size-5 text-amber-500" icon="gmdi-done-all-o" />
                                        Get started
                                    </li>
                                </ul>
                            </div>
                            <div class="p-3 overflow-hidden border rounded-3xl dark:border-gray-800">
                                <div class="flex gap-2 py-6 *:size-2.5 *:rounded-full px-6">
                                    <div class="bg-[#f87171]"></div>
                                    <div class="bg-[#fbbf24]"></div>
                                    <div class="bg-[#a3e635]"></div>
                                </div>
                                <div class="flex gap-3 px-6 *:aspect-square *:p-4">
                                    <div class="border rounded-2xl dark:border-gray-800">
                                        <x-filament::icon class="size-7 text-amber-500" icon="heroicon-o-question-mark-circle" />
                                    </div>
                                    <div class="border rounded-2xl dark:border-gray-800">
                                        <x-filament::icon class="size-7 text-amber-500" icon="heroicon-o-ticket" />
                                    </div>
                                    <div class="bg-gray-200 dark:bg-gray-900 rounded-2xl">
                                        <x-filament::icon class="size-7 text-amber-500" icon="heroicon-o-light-bulb" />
                                    </div>
                                    <div class="border rounded-2xl dark:border-gray-800">
                                        <x-filament::icon class="size-7 text-amber-500" icon="heroicon-o-lifebuoy" />
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <pre class="px-6 whitespace-pre-line">
                                            <code class="font-mono text-sm">
                                                Got a fresh idea? 🚀

                                                We’re always looking for ways to improve!

                                                Send us a suggestion, big or small,
                                                And we’ll make sure to check it out!
                                            </code>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="pt-36">
                    <div class="max-w-6xl px-6 mx-auto">
                        <div class="text-center">
                            <h2 class="text-3xl font-semibold text-gray-950 dark:text-gray-50">
                                Meet the <span class="uppercase">developers</span>
                            </h2>
                            <p class="mt-6 text-gray-700 dark:text-gray-200">
                                We are a team of developers who are passionate about creating functional web applications.
                            </p>
                        </div>
                        <div class="flex flex-wrap justify-center max-w-xs gap-3 mx-auto mt-12">
                            <a href="https://github.com/edwinrojo" target="_blank" title="Edwin" class="avatar sz-xxxl">
                                <img alt="Edwin" src="{{ asset('assets/developers/edwin.jpg') }}" class="rounded-full" loading="lazy" width="120" height="120">
                            </a>
                            <a href="https://github.com/eeneg" target="_blank" title="Gene" class="avatar sz-xxxl">
                                <img alt="Gene" src="{{ asset('assets/developers/gene.jpg') }}" class="rounded-full" loading="lazy" width="120" height="120">
                            </a>
                            <a href="https://github.com/joowdx" target="_blank" title="Jude" class="avatar sz-xxxl">
                                <img alt="Jude" src="{{ asset('assets/developers/jude.jpg') }}" class="rounded-full" loading="lazy" width="120" height="120">
                            </a>
                            <a href="https://github.com/zailmer30" target="_blank" title="Elmer" class="avatar sz-xxxl">
                                <img alt="Elmer" src="{{ asset('assets/developers/elmer.jpg') }}" class="rounded-full" loading="lazy" width="120" height="120">
                            </a>
                            <a href="https://github.com/arnelbandoja" target="_blank" title="Arnel" class="avatar sz-xxxl">
                                <img alt="arnel" src="{{ asset('assets/developers/arnel.jpg') }}" class="rounded-full" loading="lazy" width="120" height="120">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="py-36">
                    <div class="max-w-6xl px-6 mx-auto">
                        <div class="text-center">
                            <h2 class="text-3xl font-semibold text-gray-950 dark:text-white">
                                The tech <span class="uppercase">stack</span>
                            </h2>
                            <p class="mt-6 text-gray-700 dark:text-gray-300">
                                The technologies we use to build this application. We use the latest technologies to build this application.
                            </p>
                        </div>
                        <div class="relative px-6 mt-12 -mx-6 overflow-x-auto w-fit h-fit sm:mx-auto sm:px-0">
                            <div class="flex gap-3 mx-auto mb-3 w-fit">
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-10 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-php" class="fill-amber-500" />
                                </div>
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-7 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-laravel" class="fill-amber-500" />
                                </div>
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-7 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-livewire" class="fill-amber-500" />
                                </div>
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-16 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-filament" class="fill-amber-500" />
                                </div>
                            </div>
                            <div class="flex gap-3 mx-auto mb-3 w-fit">
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-9 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-tailwindcss" class="fill-amber-500" />
                                </div>
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-7 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-nginx" class="fill-amber-500" />
                                </div>
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-7 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-docker" class="fill-amber-500" />
                                </div>
                            </div>
                            <div class="flex gap-3 mx-auto mb-3 w-fit">
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-10 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-mysql" class="fill-amber-500" />
                                </div>
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-7 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-sqlite" class="fill-amber-500" />
                                </div>
                            </div>
                            <div class="flex gap-3 mx-auto mb-3 w-fit">
                                <div class="border dark:border-gray-800 rounded-3xl flex relative *:relative *:size-8 *:m-auto size-20 mx-auto ">
                                    <x-filament::icon icon="si-github" class="fill-amber-500" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        const currentPath = window.location.pathname;

        if (currentPath === "/") {
            if (!document.getElementById("tailus-css")) {
                let cssLink = document.createElement("link");
                cssLink.id = "tailus-css";
                cssLink.rel = "stylesheet";
                cssLink.href = "{{ asset('css/tailus.css') }}";
                document.head.appendChild(cssLink);
            }

            if (!document.getElementById("tailus-js")) {
                let jsScript = document.createElement("script");
                jsScript.id = "tailus-js";
                jsScript.type = "module";
                jsScript.src = "{{ asset('js/tailus.js') }}";
                document.body.appendChild(jsScript);
            }

            home = document.getElementById('home');

            home.classList.remove('opacity-0');
            home.classList.remove('-translate-y-10');
        } else {
            let cssLink = document.getElementById("tailus-css");
            if (cssLink) cssLink.remove();

            let jsScript = document.getElementById("tailus-js");
            if (jsScript) jsScript.remove();
        }
    });
</script>
@endpush
