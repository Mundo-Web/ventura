@extends('components.public.matrix', ['pagina' => $post->title])
@section('titulo', 'Post')
@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('meta_keywords', $meta_keywords)
@section('css_importados')

@stop

@section('content')

    @php
        $breadcrumbs = [['title' => 'Inicio', 'url' => route('index')], ['title' => 'Blogs', 'url' => route('blog', 0)], ['title' => $post->title, 'url' => '']];
    @endphp

    @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endcomponent

    <main>
        <section class="w-full px-[5%] lg:px-[10%] flex flex-col gap-10 py-12 lg:py-16" data-aos="fade-up" data-aos-offset="150">
            <div class="flex flex-col gap-3">
               
                <h3 class="font-semibold font-FixelText_Bold text-base text-[#006258]">{{$post->categories->name}}</h3>
                  
               
                <h2 class="font-Homie_Bold font-bold text-3xl  text-[#333] leading-tight tracking-tight">
                    {{ $post->title }}
                </h2>
                <div class="flex justify-start items-center gap-2">

                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_44_1067)">
                            <path
                                d="M10.9375 1.75C11.3021 1.75 11.612 1.8776 11.8672 2.13281C12.1224 2.38802 12.25 2.69792 12.25 3.0625V12.6875C12.25 13.0521 12.1224 13.362 11.8672 13.6172C11.612 13.8724 11.3021 14 10.9375 14H1.3125C0.947917 14 0.638021 13.8724 0.382812 13.6172C0.127604 13.362 0 13.0521 0 12.6875V3.0625C0 2.69792 0.127604 2.38802 0.382812 2.13281C0.638021 1.8776 0.947917 1.75 1.3125 1.75H2.625V0.328125C2.625 0.109375 2.73438 0 2.95312 0H4.04688C4.26562 0 4.375 0.109375 4.375 0.328125V1.75H7.875V0.328125C7.875 0.109375 7.98438 0 8.20312 0H9.29688C9.51562 0 9.625 0.109375 9.625 0.328125V1.75H10.9375ZM10.7734 12.6875C10.8828 12.6875 10.9375 12.6328 10.9375 12.5234V4.375H1.3125V12.5234C1.3125 12.6328 1.36719 12.6875 1.47656 12.6875H10.7734Z"
                                fill="#444444" />
                        </g>
                        <defs>
                            <clipPath id="clip0_44_1067">
                                <rect width="12.25" height="14" fill="white" transform="matrix(1 0 0 -1 0 14)" />
                            </clipPath>
                        </defs>
                    </svg>
                    <p class="text-[#444444] font-FixelText_Regular font-normal text-sm mt-1">Publicado
                        {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                </div>


                @if ($post->url_video)
                    <div class="w-full mt-2" data-aos="fade-up" data-aos-offset="150">
                        <iframe width="100%" height="600px" src="https://www.youtube.com/embed/{{ $post->url_video }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                @endif



                <div class="flex flex-col gap-2 text-[#333] font-FixelText_Regular font-normal text-base py-4">
                    {!! $post->description !!}
                </div>

                @if ($post->url_image)
                    <div class="w-full" data-aos="fade-up" data-aos-offset="150">
                        <img src="{{ asset($post->url_image . $post->name_image) }}" alt="catedral"
                            class="w-full h-[563px] object-cover hidden md:block rounded-xl" />
                        <img src="{{ asset($post->url_image . $post->name_image) }}" alt="catedral"
                            class="w-full h-[563px] object-cover block md:hidden rounded-xl" />
                    </div>
                @endif
            </div>

            {{-- <div>
                <div class="mb-4 flex justify-between border-t-2 pt-5" aria-label="Pagination">
                    <a class="px-2 py-2 text-[#3F76BB] flex gap-2" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                            <g clip-path="url(#clip0_44_1660)">
                            <path d="M4.75 3.625C4.58333 3.4375 4.41667 3.4375 4.25 3.625L0.125 7.75C-0.0625 7.91667 -0.0625 8.08333 0.125 8.25L4.25 12.375C4.41667 12.5625 4.58333 12.5625 4.75 12.375L5.375 11.7812C5.5625 11.5938 5.5625 11.4167 5.375 11.25L2.84375 8.8125H13.625C13.875 8.8125 14 8.6875 14 8.4375V7.5625C14 7.3125 13.875 7.1875 13.625 7.1875H2.84375L5.375 4.75C5.5625 4.58333 5.5625 4.40625 5.375 4.21875L4.75 3.625Z" fill="#006BF6"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_44_1660">
                            <rect width="14" height="16" fill="white" transform="matrix(-1 0 0 -1 14 16)"/>
                            </clipPath>
                            </defs>
                        </svg>
                        <span class="font-bold font-roboto text-text14 text-[#FF5E14]">Publicación anterior</span>
                    </a>

                    <a class="px-2 py-2 text-[#3F76BB] flex gap-2" href="#">
                        <span class="font-bold font-roboto text-text14 text-[#FF5E14]">Publicación proximo</span>
                        <img src="{{ asset('images/svg/image_37.svg') }}" alt="next" />
                    </a>
                </div>
            </div> --}}
        </section>
    </main>


@section('scripts_importados')


@stop

@stop
