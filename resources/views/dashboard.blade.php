<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{-- @for ($i = 0; $i < 4; $i++)
                        <iframe width="100%" height="500" src="https://www.youtube.com/embed/Sn0Vc8vclOU" allowfullscreen></iframe>
                        <x-primary-button>
                            Stream {{$i+1}}
                            <video id="my-video" class="video-js" controls preload="auto" data-setup="{}" muted>
                                <source src="http://alpharliv2.mmdlive.lldns.net/alpharliv2/fbe971f51d8d436895fe04c47261e742/manifest.m3u8?p=80&e=1669020274&h=4b402b991320250568d45be13c25d931" type="video/x-mpegURL" />
                            </video>
                        </x-primary-button>
                        @endfor --}}
                    </div>
                </div>
            </div>
        </div>
        <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    
    
    
</x-app-layout>
