import React, { useEffect, useState, useRef } from 'react'
import { createRoot } from 'react-dom/client'
import CreateReactScript from './Utils/CreateReactScript'
import FilterContainer from './components/Filter/FilterContainer'
import ProductContainer from './components/Product/ProductContainer'
import { Fetch } from 'sode-extend-react'
import FilterPagination from './components/Filter/FilterPagination'
import arrayJoin from './Utils/ArrayJoin'
import ProductCard from './components/Product/ProductCard'
import { set } from 'sode-extend-react/sources/cookies'
import axios from 'axios'





const Catalogo = ({ minPrice, maxPrice, categories, tags, attribute_values, id_cat: selected_category, tag_id, subCatId, textoshome }) => {
  const take = 12
  const [items, setItems] = useState([]);
  const [filter, setFilter] = useState({});
  const [totalCount, setTotalCount] = useState(0);
  const [currentPage, setCurrentPage] = useState(1);
  const [showModal, setShowModal] = useState(false);
  const is_proveedor = useRef(false);
  const cancelTokenSource = useRef(null);
  

  useEffect(() => {
    const script = document.createElement('script');
    script.src = "js/notify.extend.min.js";
    script.async = true;
    document.body.appendChild(script);

    return () => {
      document.body.removeChild(script);
    };
  }, []);

  useEffect(() => {
    // Leer el parámetro 'tag' de la URL
    const params = new URLSearchParams(window.location.search);
    const tag = params.get('tag');

    // Actualizar el filtro con el 'tag_id' si existe
    if (tag) {
      setFilter(prevFilter => ({
        ...prevFilter,
        'txp.tag_id': [tag]
      }));
    }

    // Si hay una categoría seleccionada, agregarla al filtro
    if (selected_category) {
      setFilter(prevFilter => ({
        ...prevFilter,
        category_id: [selected_category]
      }));
    }
  }, [selected_category]);

  useEffect(() => {
    setCurrentPage(1);
    getItems();
  }, [filter]);

  useEffect(() => {
    getItems();
  }, [currentPage]);

  useEffect(() => {
    if (subCatId !== null) {
      setFilter({ ...filter, subcategory_id: [subCatId] });
    }
  }, []);

  const getItems = async () => {
    // Cancelar la solicitud anterior si existe
    if (cancelTokenSource.current) {
      cancelTokenSource.current.cancel('Operation canceled due to new request.');
    }

    // Crear un nuevo token de cancelación
    cancelTokenSource.current = axios.CancelToken.source();

    const filterBody = [];

    if (filter.maxPrice || filter.minPrice) {
      if (filter.maxPrice && filter.minPrice) {
        filterBody.push([
          [
            ['precio', '>=', filter.minPrice],
            'or',
            [
              ['descuento', '>=', filter.minPrice],
              'and',
              ['descuento', '<>', 0]
            ]
          ],
          'and',
          [
            ['precio', '<=', filter.maxPrice],
            'or',
            [
              ['descuento', '<=', filter.maxPrice],
              'and',
              ['descuento', '<>', 0]
            ]
          ]
        ]);
      } else if (filter.minPrice) {
        filterBody.push([
          ['precio', '>=', filter.minPrice],
          'or',
          [
            ['descuento', '>=', filter.minPrice],
            'and',
            ['descuento', '<>', 0]
          ]
        ]);
      } else if (filter.maxPrice) {
        filterBody.push([
          ['precio', '<=', filter.maxPrice],
          'or',
          [
            ['descuento', '<=', filter.maxPrice],
            'and',
            ['descuento', '<>', 0]
          ]
        ]);
      }
    }

    if (filter['txp.tag_id'] && filter['txp.tag_id'].length > 0) {
      const tagsFilter = [];
      filter['txp.tag_id'].forEach((x, i) => {
        if (i === 0) {
          tagsFilter.push(['txp.tag_id', '=', x]);
        } else {
          tagsFilter.push('or', ['txp.tag_id', '=', x]);
        }
      });
      filterBody.push(tagsFilter);
    }

    for (const key in filter) {
      if (!key.startsWith('attribute-')) continue;
      if (filter[key].length === 0) continue;
      const [, attribute_id] = key.split('-');
      const attributeFilter = [];
      filter[key].forEach((x, i) => {
        if (i === 0) {
          attributeFilter.push(['apv.attribute_value_id', '=', x]);
        } else {
          attributeFilter.push('or', ['apv.attribute_value_id', '=', x]);
        }
      });
      filterBody.push([
        ['a.id', '=', attribute_id],
        'and',
        attributeFilter
      ]);
    }

    if (filter['category_id'] && filter['category_id'].length > 0) {
      const categoryFilter = [];
      filter['category_id'].forEach((x, i) => {
        if (i === 0) {
          categoryFilter.push(['categoria_id', '=', x]);
        } else {
          categoryFilter.push('or', ['categoria_id', '=', x]);
        }
      });
      filterBody.push(categoryFilter);
    }

    if (filter['subcategory_id'] && filter['subcategory_id'].length > 0) {
      const subcategoryFilter = [];
      filter['subcategory_id'].forEach((x, i) => {
        if (i === 0) {
          subcategoryFilter.push(['subcategory_id', '=', x]);
        } else {
          subcategoryFilter.push('or', ['subcategory_id', '=', x]);
        }
      });
      filterBody.push(subcategoryFilter);
    }

    try {
      const { status, data: result } = await axios.post('/api/products/paginate', {
        requireTotalCount: true,
        filter: arrayJoin([...filterBody, ['products.visible', '=', true]], 'and'),
        take,
        skip: take * (currentPage - 1)
      }, {
        headers: {
          'Content-Type': 'application/json'
        },
        cancelToken: cancelTokenSource.current.token
      });

      is_proveedor.current = result?.is_proveedor ?? false;

      setItems(result?.data ?? []);
      setTotalCount(result?.totalCount ?? 0);
    } catch (error) {
      if (axios.isCancel(error)) {
        console.log('Request canceled', error.message);
      } else {
        // Manejar otros errores
        console.error(error);
      }
    }
  };

  const attributes = attribute_values.reduce((acc, item) => {
    // If the attribute_id does not exist in the accumulator, create a new array for it
    if (!acc[item.attribute_id]) {
      acc[item.attribute_id] = [];
    }
    // Add the current item to the array corresponding to its attribute_id
    acc[item.attribute_id].push(item);
    return acc;
  }, {});

  const categoryDetails = categories.find(category => category.id === Number(selected_category));
  const imgcatalogo = 'images/img/portadacatalogo.png';
  console.log(categoryDetails);

  return (<>
   <div>

   <section className="flex flex-col lg:flex-row gap-3 lg:gap-10 justify-center items-center px-[5%] lg:pl-[5%] lg:pr-0 bg-[#5BE3A4]">
      
        <div className="w-full lg:w-[55%] text-[#151515] flex flex-col justify-center items-center gap-2 md:gap-10">
            <div className="w-full flex flex-col gap-5 px-0 lg:px-[5%] pt-8 lg:pt-0 xl:max-w-4xl">
              <h1 className="text-[#F8FCFF] font-Homie_Bold text-5xl lg:text-6xl">
                {textoshome?.title1section || 'Propiedades que inspiran, experiencias que marcan la diferencia.'}
              </h1>

            </div>
          {/*

            <div className="w-full flex flex-col gap-5 px-0 lg:px-[5%] pt-8 md:pt-0">
             
              <div className="px-0 w-full z-10">
                
               
                <div className="bg-white rounded-t-lg inline-block w-auto md:max-w-[388px]">
                  <div className="flex justify-between items-center">
                    <button
                      className="px-10 py-3 text-[#009A84] font-FixelText_Semibold border-b-[2.5px] border-[#009A84] focus:outline-none tab-button flex-1"
                      onclick="showTab('tab1')">
                      Elige unas Fechas
                    </button>
                  </div>
                </div>
                
              
                <div id="tab1" className="flex flex-col md:flex-row py-4 px-4 tab-content bg-white justify-between items-center gap-5 rounded-b-lg md:rounded-tr-lg w-full">
                  
                  <div className="w-full">
                    <div className="relative w-full text-left">
                      <div className="group">
                        <div>
                          <select name="departamento_id" id="departamento_id2"
                            className="w-full py-3 px-5 text-text18 text-[#000929] border-0">
                            <option value="">Ubicacion</option>

                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div className="w-[0.5px] h-[50px] bg-[#E0DEF7] hidden md:block">
                  </div>

                  <div className="w-full">
                    <div className="relative w-full text-left">
                      <div className="group">
                        <div>
                          <select name="categoria_id" id="categoria_id2"
                            className="w-full py-3 px-5 text-text18 text-[#000929] border-0">
                            <option value="">Categorias</option>

                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
    
                  <div className="w-[0.5px] h-[50px] bg-[#E0DEF7] hidden md:block">
                  </div>
    
                  <div className="flex justify-center items-center md:w-full">
                    <div className="flex flex-row-reverse 2md:flex-row justify-center items-center gap-5">
                      <div className="flex justify-start items-center w-full">
                        <button id="linkExplirarAlquileres"
                          className="bg-[#009A84] rounded-2xl font-FixelText_Semibold text-base text-white px-10 py-3 text-center">
                          <span className="flex w-full">Buscar</span>
                        </button>
                      </div>
                    </div>
                  </div>

                </div>
                
              </div>
              <p className="font-FixelText_Regular underline text-sm text-white ">
                Propietario, anuncia tu propiedad gratis
              </p>

            </div>

          */}
        </div>

       
        <div className="w-full lg:w-[45%] ">
          <div className="w-full h-full flex flex-row items-center justify-center">
              <img src={imgcatalogo} className="h-[200px] lg:min-h-[400px] object-contain xl:h-full object-bottom" />
          </div>
        </div>

    </section>  
      
    <form className="flex flex-col lg:flex-row gap-6 w-full px-[5%] lg:px-[8%]">
      {/* sticky */}
      {/* <section className="hidden lg:flex md:flex-col gap-4 md:basis-3/12 bg-white p-6 rounded-lg h-max top-2">
        <FilterContainer setFilter={setFilter} filter={filter} minPrice={minPrice ?? 0} maxPrice={maxPrice ?? 0} categories={categories} tags={tags} attribute_values={Object.values(attributes)} selected_category={selected_category} tag_id={tag_id} />
      </section> */}
      <section className="flex flex-col gap-6 md:basis-full py-6">
        
        <div className="w-full bg-white rounded-lg font-medium flex flex-row justify-between items-center px-2 py-3">
          <div className='flex flex-col xl:flex-row  justify-start xl:justify-between items-start gap-2 '>
            <span className="font-normal text-[17px] text-[#666666] xl:ml-3">
              Mostrando {((currentPage - 1) * take) + 1} - {currentPage * take > totalCount ? totalCount : currentPage * take} de {totalCount} resultados
            </span>
            <button type="button" className='lg:hidden text-[#006BF6]' onClick={() => setShowModal(true)}> Mostrar Filtros</button>
          </div>
        </div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 lg:gap-8">
          {items.map((item, i) => <ProductCard key={`product-${item.id}`} item={item} bgcolor={'bg-white'} is_reseller={is_proveedor.current} />)}
        </div>

        <div className="w-full font-medium flex flex-row justify-center items-center">
          <FilterPagination current={currentPage} setCurrent={setCurrentPage} pages={Math.ceil(totalCount / take)} />
        </div>

      </section>
      {/* modal */}

      {showModal && (<div className="fixed z-40 top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center max-h-[80vh] p-5" id="modal">
        {/* btn para cerrar modal */}
        <div className="z-50 flex items-center content-center justify-center absolute  p-4 bg-black rounded-full h-6 w-6" style={{ top: '20px', right: '20px' }}>
          <button type='button' onClick={() => setShowModal(false)} className="text-white text-md ">X</button>

        </div>

        <div className='flex flex-col gap-4 w-full bg-white p-6 rounded-lg top-2 overflow-y-auto mt-10' style={{ maxHeight: '90vh', maxWidth: "85vh" }}>
          <FilterContainer setFilter={setFilter} filter={filter} minPrice={minPrice ?? 0} maxPrice={maxPrice ?? 0} categories={categories} tags={tags} attribute_values={Object.values(attributes)} selected_category={selected_category} tag_id={tag_id} />
        </div>

      </div>)}


    </form>

    <section className="flex flex-col justify-center items-center px-[5%] xl:px-[8%] py-14 w-full bg-[#73F7AD] mt-8 lg:mt-16">
          <div className="flex flex-col max-w-xl">
            
            <div className="flex flex-col w-full text-center gap-5 text-[#006258]">
              <h2 className="text-4xl font-Homie_Bold">{textoshome?.title5section || 'Ingrese un texto'}</h2>
              <p className="text-base font-FixelText_Regular text-[#000929]">{textoshome?.description5section || 'Ingrese un texto'}</p>
            </div>

            <div className="flex flex-col mt-8 w-full gap-4">
              <div className="flex flex-col w-full rounded-lg">
                <form id="subsEmail" className="flex flex-row gap-5 justify-end px-5 py-3.5 w-full bg-white rounded-2xl">
                  <input type="hidden" name="tipo" value="Catalogo" />  
                  <input placeholder="Introduce tu correo electrónico" type="email" id="email" name="email" class="w-full px-4 py-2 text-sm font-FixelText_Regular focus:border-0 focus:ring-0 text-[#006258] placeholder:text-[#00625852] border border-transparent rounded-xl" aria-label="Introduce tu correo electrónico" required />
                  <button type="submit" className="self-end px-10 py-3 text-base font-FixelText_Semibold text-center text-[#73F7AD] bg-[#009A84] rounded-lg">Enviar</button>
                </form>
              </div>
              <p class="text-base text-center font-FixelText_Regular text-[#000929]">
                {textoshome?.footer5section || 'Ingrese un texto'}
              </p>
            </div>

          </div>
      </section> 

    </div>
  </>)
}

CreateReactScript((el, properties) => {
  createRoot(el).render(<Catalogo {...properties} />);
})