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
                        @for ($i = 1; $i < 3; $i++)
                        {{-- <iframe width="100%" height="500" src="https://www.youtube.com/embed/Sn0Vc8vclOU" allowfullscreen></iframe> --}}
                        <x-primary-button>
                            Stream {{$i}}
                            {{-- <video id="my-video" class="video-js" controls preload="auto" data-setup="{}" muted>
                                <source src="http://alpharlive.mmdlive.lldns.net/alpharlive/5ccaa49515e6408b875c8a904e2a4fd2/manifest.m3u8?p=36&h=cbda17b2e4c27eb81695794d62a3c3db" type="video/x-mpegURL" />
                            </video> --}}
                        </x-primary-button>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
    
    
    
</x-app-layout>
