 @php
     $category = $post->categoria();
 @endphp
 <div class="flex flex-col gap-3 font">
     <div class="flex flex-col gap-4">
         <div class="relative flex justify-center items-center">
             <a href="{{ route('detalleBlog', $post->id) }}" class="w-full">
                 <img src="{{ asset($post->url_image . $post->name_image) }}"
                     class="w-full object-cover h-56 sm:h-64 md:h-64" alt="blog"></a>
             <div class="absolute top-0 left-0 pt-4 pl-4">
                 <h3
                     class="text-sm  font-FixelText_Bold bg-[#006258] text-white px-3 py-2 rounded-xl">
                     {{ $category->name }}</h3>
             </div>
         </div>

         <div class="flex flex-row justify-start items-center gap-2">

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
             <p class="text-[#444444] font-FixelText_Regular font-normal text-xs mt-1">Publicado
                 {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
         </div>

         <div class="flex flex-col justify-start items-start gap-1 -mt-2 md:-mt-3">
             <a href="{{ route('detalleBlog', $post->id) }}">
                 <h2 class="text-lg font-FixelText_Bold font-normal text-[#333333]">{{ $post->title }}
                 </h2>
             </a>

             <a  href="{{ route('detalleBlog', $post->id) }}" 
                 class="text-sm font-FixelText_Regular font-bold text-[#006258]  leading-tight flex flex-row gap-2 items-center">
                 Leer más
                 <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                     <g clip-path="url(#clip0_44_1092)">
                         <path
                             d="M9.25 3.625C9.41667 3.4375 9.58333 3.4375 9.75 3.625L13.875 7.75C14.0625 7.91667 14.0625 8.08333 13.875 8.25L9.75 12.375C9.58333 12.5625 9.41667 12.5625 9.25 12.375L8.625 11.7812C8.4375 11.5938 8.4375 11.4167 8.625 11.25L11.1562 8.8125H0.375C0.125 8.8125 0 8.6875 0 8.4375V7.5625C0 7.3125 0.125 7.1875 0.375 7.1875H11.1562L8.625 4.75C8.4375 4.58333 8.4375 4.40625 8.625 4.21875L9.25 3.625Z"
                             fill="#006258" />
                     </g>
                     <defs>
                         <clipPath id="clip0_44_1092">
                             <rect width="14" height="16" fill="white" transform="matrix(1 0 0 -1 0 16)" />
                         </clipPath>
                     </defs>
                 </svg>
             </a>
         </div>
     </div>
 </div>
