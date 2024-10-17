<a class="group" href="{{ $href }}">
  <div
    class="@if (in_array(Request::segment(2), [$id ?? ''])) {{ 'bg-[#00897b]' }} @endif text-white py-2 px-4 rounded-2xl cursor-pointer text-[16px] border-none w-64 flex justify-between items-center group-hover:bg-[#00897b]">
    <p
      class="font-medium text-[16px] text-[#00897b] group-hover:text-white @if (in_array(Request::segment(2), [$id ?? ''])) {{ '!text-white' }} @endif">
      {{ $slot }}
    </p>
    <span>
      <svg width="20" height="20" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M0.332031 6.50048C0.332031 2.93378 3.3187 0.0390626 6.9987 0.0390628C10.6787 0.039063 13.6654 2.93378 13.6654 6.50048C13.6654 10.0672 10.6787 12.9619 6.9987 12.9619C3.3187 12.9619 0.332031 10.0672 0.332031 6.50048ZM8.76536 6.27433L6.90536 4.47159C6.69203 4.26483 6.33203 4.40698 6.33203 4.69774L6.33203 8.30967C6.33203 8.60044 6.69203 8.74259 6.8987 8.53582L8.7587 6.73309C8.89203 6.60386 8.89203 6.39709 8.76536 6.27433Z"
          fill="#00897b" />
      </svg>
    </span>
  </div>
</a>
