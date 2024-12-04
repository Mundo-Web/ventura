const checkbox = document.getElementById("check");
const bag = document.querySelector(".bag");
const bodyModalCarrito = document.querySelector(".body");
let isMenuOpen = false; // Variable para controlar el estado del menú
const card = document.querySelector(".cartContainer");
// checkbox.addEventListener("click", checkboxOnClick);

// Agregar event listener al checkbox para controlar el estado del menú
// function checkboxOnClick() {
//   // Cambiar el top del carrito
//   const scrollTopPosition = window.scrollY;
//   card.style.top = scrollTopPosition + "px";

//   isMenuOpen = checkbox.checked;
//   if (isMenuOpen) {
//     bodyModalCarrito.classList.add("dark");
//     bodyModalCarrito.classList.add("overflow-hidden");
//     // Agregar el event listener al documento cuando se abre el menú
//     document.addEventListener("click", handleDocumentClick);
//   } else {
//     bodyModalCarrito.classList.remove("dark");
//     bodyModalCarrito.classList.remove("overflow-hidden");
//     // Quitar el event listener del documento cuando se cierra el menú
//     document.removeEventListener("click", handleDocumentClick);
//   }
// }

// // Función para manejar el clic en el documento
// function handleDocumentClick(event) {
//   // Verificar si el menú está abierto y si el clic no ocurrió dentro del nav ni en el checkbox
//   if (isMenuOpen && !bag.contains(event.target) && event.target !== checkbox) {
//     bag.classList.add("hidden"); // Ocultar el nav
//     checkbox.checked = false; // Desmarcar el checkbox
//     bodyModalCarrito.classList.remove("dark");
//     bodyModalCarrito.classList.remove("overflow-hidden");
//     isMenuOpen = false; // Actualizar el estado del menú
//     // Quitar el event listener del documento después de cerrar el menú
//     document.removeEventListener("click", handleDocumentClick);
//   }
// }

// Detener la propagación de clics dentro del nav para evitar cerrarlo al hacer clic dentro
if (bag){
  bag.addEventListener("click", function (event) {
    event.stopPropagation(); // Evitar que el clic se propague al documento
  });
}





function show() {
  document.querySelector(".hamburger").classList.toggle("open");
  document.querySelector(".navigation").classList.toggle("active");
}


/* --------------------------- CARROUSEL ---------------------------- */
var carrouselTestimonios = new Swiper(".myTestimonios", {
  slidesPerView: 4, //3
  spaceBetween: 25,
  loop: true,
  grabCursor: true,
  centeredSlides: true,
  initialSlide: 0,
  pagination: {
    el: ".swiper-pagination-testimonios",
    clickable: true,
    /* dynamicBullets: true, */
  },
  autoplay: {
    delay: 1500,
    disableOnInteraction: false,
  },

  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 4,
    },
  },
});

/* ------------------------------------------------------------------ */

var carrouselBeneficios = new Swiper(".myBeneficios", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  grab: false,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-beneficios",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});

/* ------------------------------------------- */

var carrouselCategorias = new Swiper(".categorias", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: false,
  grab: false,
  centeredSlides: true,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-categorias",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});

/* --------------------------------------------- */

var carrosuelDestacados = new Swiper('.productos-home', {
  slidesPerView: 2,
  spaceBetween: 20,
  loop: true,
  grab: false,

  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  // pagination: {
  //   el: '.swiper-pagination-productos-home',
  //   clickable: true,
  // },
  navigation: {
    nextEl: '.swiper-button-next-productos-home',
    prevEl: '.swiper-button-prev-productos-home',
  },
  scrollbar: {
    el: '.swiper-scrollbar-productos-home',
  },
  breakpoints: {
    512: {
      slidesPerView: 2
    },
    640: {
      slidesPerView: 3
    },
    768: {
      slidesPerView: 4
    },
    1024: {
      slidesPerView: 5
    },
    1280: {
      slidesPerView: 6
    },
  },
});

new Swiper('.categories-header', {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,
  grab: false,

  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  // pagination: {
  //   el: '.swiper-pagination-categories-header',
  //   clickable: true,
  // },
  navigation: {
    nextEl: '.swiper-button-next-categories-header',
    prevEl: '.swiper-button-prev-categories-header',
  },
  scrollbar: {
    el: '.swiper-scrollbar-categories-header',
  },
  breakpoints: {
    512: {
      slidesPerView: 1
    },
    768: {
      slidesPerView: 2
    },
    1024: {
      slidesPerView: 3
    },
    1280: {
      slidesPerView: 4
    },
  },
});

/* --------------------------------------------- */

var carrouselOferta = new Swiper(".productos-oferta", {
  slidesPerView: 4,
  spaceBetween: 10,
  loop: true,
  grab: false,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-productos-oferta",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 4,
    },
  },
});

/* --------------------------------------------- */

var carrosuelComplementario = new Swiper(".productos-complementarios", {
  slidesPerView: 4,
  spaceBetween: 10,
  loop: true,
  grab: false,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)

  pagination: {
    el: ".swiper-pagination-producto-complementario",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 4,
    },
  },
});

/* --------------------------------------------- */


/* ------------------------------------------ */

var carrosuelProductoSlider = new Swiper(".producto-slider", {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,
  grab: true,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-productos",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});

/* ------------------------------------------ */

var CarrosuelCatalogo = new Swiper(".producto-catalogo", {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,
  grab: true,
  centeredSlides: false,
  initialSlide: 0, // Empieza en el cuarto slide (índice 3)
  pagination: {
    el: ".swiper-pagination-producto-catalogo",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
});



var input = document.querySelector(".input-box");

(input ?? {}).onclick = function () {
  this.classList.toggle("open");
  let list = this.nextElementSibling;
  if (list.style.maxHeight) {
    list.style.maxHeight = null;
    list.style.boxShadow = null;
  } else {
    list.style.maxHeight = list.scrollHeight + "px";
    list.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var rad = document.querySelectorAll(".radio");
rad.forEach((item) => {
  item.addEventListener("change", () => {
    input.innerHTML = item.nextElementSibling.innerHTML;
    input.click();
  });
});




var inputDistrito = document.querySelector(".input-box-distrito");
(inputDistrito ?? {}).onclick = function () {
  this.classList.toggle("open-distrito");
  let listDistrito = this.nextElementSibling;
  if (listDistrito.style.maxHeight) {
    listDistrito.style.maxHeight = null;
    listDistrito.style.boxShadow = null;
  } else {
    listDistrito.style.maxHeight = listDistrito.scrollHeight + "px";
    listDistrito.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var radDistrito = document.querySelectorAll(".radio-distrito");
radDistrito.forEach((item) => {
  item.addEventListener("change", () => {
    inputDistrito.innerHTML = item.nextElementSibling.innerHTML;
    inputDistrito.click();
  });
});




var inputProvincia = document.querySelector(".input-box-provincia");
(inputProvincia ?? {}).onclick = function () {
  this.classList.toggle("open-provincia");
  let listProvincia = this.nextElementSibling;
  if (listProvincia.style.maxHeight) {
    listProvincia.style.maxHeight = null;
    listProvincia.style.boxShadow = null;
  } else {
    listProvincia.style.maxHeight = listProvincia.scrollHeight + "px";
    listProvincia.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var radProvincia = document.querySelectorAll(".radio-provincia");
radProvincia.forEach((item) => {
  item.addEventListener("change", () => {
    inputProvincia.innerHTML = item.nextElementSibling.innerHTML;
    inputProvincia.click();
  });
});






var input = document.querySelector(".input-box");

(input ?? {}).onclick = function () {
  
  this.classList.toggle("open");
  let list = this.nextElementSibling;
  if (list.style.maxHeight) {
    list.style.maxHeight = null;
    list.style.boxShadow = null;
  } else {
    list.style.maxHeight = list.scrollHeight + "px";
    list.style.boxShadow =
      "0 1px 2px 0 rgba(0, 0, 0, 0.15),0 1px 3px 1px rgba(0, 0, 0, 0.1)";
  }
};

var rad = document.querySelectorAll(".radio");
rad.forEach((item) => {
  item.addEventListener("change", () => {
    
    input.innerHTML = item.nextElementSibling.innerHTML;
    input.click();
  });
});



const cuentas = document.querySelectorAll(".cuentas");
const depositoCuenta = document.querySelector(".deposito__cuenta");
const radioInputTarjeta = document.querySelector(".inputVoucher");
cuentas.forEach((cuenta) => {
  cuenta.addEventListener("click", (e) => {
    if (e.target.classList.contains("inputVoucher")) {
      depositoCuenta.classList.remove("hidden");
    } else {
      depositoCuenta.classList.add("hidden");
    }
  });
});







function formatDate(dateString) {
  const [year, month, day] = dateString.split('-');
  return `${day}/${month}/${year}`;
}


function PintarCarrito() {
  

  let itemsCarrito = $('#itemsCarrito')
  let itemsCarritoCheck = $('#itemsCarritoCheck')

  articulosCarrito.forEach(element => {

    const formattedCheckin = formatDate(element.checkin);
    const formattedCheckout = formatDate(element.checkout);
    let nombresServicios = '';
    
    if (element.nombresServicios && element.nombresServicios.length > 0) {
        nombresServicios = element.nombresServicios.join(', '); 
    }

    let plantilla = `<tr class=" font-FixelText_Regular border-b">
          <td class="p-2 w-24">
            <img src="${appUrl}/${element.imagen}" class="block bg-[#F3F5F7] rounded-md p-0 w-24 object-contain" alt="producto" onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';"  style="width: 100px; height: 75px; object-fit: contain; object-position: center;" />
          </td>
          <td class="p-2">
            
            <p class="limited-text font-semibold text-[14px] text-[#151515] mb-1">
              ${element.producto}
            </p>
            <p class="font-semibold text-[12px] text-[#151515]">
                Ingreso: ${formattedCheckin} - Salida: ${formattedCheckout}
            </p>
            
            ${nombresServicios ? `<p class="font-semibold text-[12px] text-[#151515]">Extras: ${nombresServicios}</p>` : ''}
            
          </td>
          <td class="p-2 text-end lg:flex lg:flex-row h-24 items-center gap-2">
            <p class="font-semibold text-base text-[#151515] w-max">
              $ ${Number(element.costototal)}
            </p>
            <button type="button" onClick="(deleteItem(${element.id} , ${element.isCombo}))" class=" w-5 h-5 flex justify-center items-center mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#272727" class="w-5 h-5">
                <path stroke="#272727" stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>
            </button>

          </td>
        </tr>`

    itemsCarrito.append(plantilla)
    itemsCarritoCheck.append(plantilla)

  });

  mostrarTotalItems()
  calcularTotal()
  
}


function calcularTotal() {
  
  let articulos = Local.get('carrito') || [];
  
  let total = articulos.map(item => {
    let monto
    if (Number(item.costototal) !== 0) {
      monto =  item.cantidad * (Number(item.costototal))
    } 
    return monto
  })
  
  const suma = total.reduce((total, elemento) => total + elemento, 0);
  
  $('#itemsTotal').text(`$ ${suma.toFixed(2)} `)
  console.log("tofixed  ", suma.toFixed(2))
 
}

