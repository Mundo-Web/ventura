import React, { useRef, useState } from 'react'
import FilterItem from './FilterItem'
import FilterItemSelect2 from './FilterItemSelect2'
import DateRangePicker from '@wojtekmaj/react-daterange-picker';
import '@wojtekmaj/react-daterange-picker/dist/DateRangePicker.css';

const FilterContainer = ({ minPrice, setFilter, filter, maxPrice, categories = [], tags = [], brands = [], sizes = [], colors = [], attribute_values, tag_id, selected_category, lugar, cantidad, llegada, salida, distritosfiltro = [], limite = 1  }) => {
  const categoryRef = useRef()
  
  const [openCategories, setOpenCategories] = useState({});

  const formatDateToMMDDYYYY = (dateString) => {
    const date = new Date(dateString);
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mes (0 indexado)
    const day = String(date.getDate()).padStart(1, '0'); // Día
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
  };

  const formattedLlegada = llegada ? formatDateToMMDDYYYY(llegada) : formatDateToMMDDYYYY(new Date());
  const formattedSalida = salida ? formatDateToMMDDYYYY(salida) : formatDateToMMDDYYYY(new Date());

  const [value, onChange] = useState([formattedLlegada,formattedSalida]); 
 
  console.log(formattedLlegada);
  console.log(formattedSalida);
  console.log(value);

  const toggleAccordion = (id) => {
    setOpenCategories(prevState => ({
      ...prevState,
      [id]: !prevState[id]
    }));
  };

  const setMinPrice = (e) => {
    const newFilter = structuredClone(filter)
    newFilter.minPrice = Number(e.target.value) || 0
    setFilter(newFilter)
  }
  const setMaxPrice = (e) => {
    const newFilter = structuredClone(filter)
    newFilter.maxPrice = Number(e.target.value) || 0
    setFilter(newFilter)
  }

  const onClick = (key, value, checked) => {
    let newFilter = structuredClone(filter)
    if (!newFilter[key]) newFilter[key] = []
    if (checked) newFilter[key].push(value)
    else newFilter[key] = newFilter[key].filter(x => x != value)
    setFilter(newFilter)
  }

  const onCategoryChange = () => {
    const newFilter = structuredClone(filter)
    newFilter['category_id'] = $(categoryRef.current).val()
    setFilter(newFilter)
  }




  return (<>

      
      <div className="px-0 w-full z-10">
        {/* Tab Buttons */}
        <div className="bg-white rounded-t-lg inline-block w-auto md:max-w-[400px]">
          <div className="flex justify-between items-center">
            <button
              className={`px-10 py-3 text-[#009A84] font-FixelText_Semibold border-b-[2.5px] border-[#009A84] focus:outline-none tab-button flex-1`}
            >
              Elige unas Fechas
            </button>
          </div>
        </div>

       
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-8 py-4 px-4 tab-content bg-white justify-between items-center gap-3 rounded-b-lg md:rounded-tr-lg w-full">
            
            <div className="w-full md:col-span-2">
              <div className="relative w-full text-left">
                <div className="group">
                  <select
                    name="lugar"
                    id="lugar"
                    className="w-full min-w-36 py-3 text-sm border-0 font-FixelText_Medium self-stretch my-auto basis-0 bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] text-[#006258] placeholder:text-opacity-30"
                    value={lugar}
                    onChange={(e) => {
                      console.log(e.target.value); 
                    }}
                  >
                    <option className="line-clamp-1" value="">
                      Ubicación
                    </option>
                    {distritosfiltro.map((ubicaciones, index) =>
                      ubicaciones.distrito_id ? (
                        <option
                          className="line-clamp-1"
                          key={index}
                          value={ubicaciones.distrito_id}
                        >
                          {ubicaciones.distrito.description}
                        </option>
                      ) : null
                    )}
                  </select>
                </div>
              </div>
            </div>

            <div className="w-full md:col-span-3">
              <div className="relative w-full text-left md:text-center">
                <div className="group">
                  <DateRangePicker onChange={onChange} value={value} format="dd/MM/y"/>
                </div>
              </div>
            </div>

            <div className="w-full md:col-span-2">
              <div className="relative w-full text-left">
                <div className="group">
                  
                    <select
                      name="cantidad_personas"
                      id="cantidad_personas"
                      className="w-full text-sm font-FixelText_Medium self-stretch my-auto basis-0 bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] text-[#006258] placeholder:text-opacity-30"
                      value={cantidad} // Asignamos el valor seleccionado desde la variable 'cantidad'
                      onChange={(e) => {
                        console.log(e.target.value); // Aquí puedes manejar el cambio si es necesario
                      }}
                    >
                      <option value=""># Personas</option>
                      {Array.from({ length: limite }, (_, i) => i + 1).map(
                        (value) => (
                          <option key={value} value={value}>
                            {value}
                          </option>
                        )
                      )}
                    </select>
                
                </div>
              </div>
            </div>

            <div className="flex justify-center items-center w-full md:col-span-1">
              <div className="flex justify-start items-center">
                <button
                  id="linkExplirarAlquileres"
                  className="bg-[#009A84] rounded-xl font-FixelText_Semibold text-base text-white px-3 py-3 text-center"
                >
                  <span className="hidden md:flex">
                    <i className="fa-solid fa-magnifying-glass"></i>
                  </span>
                  <span className="flex md:hidden px-7">Buscar</span>
                </button>
              </div>
            </div>
          </div>
        

       
        <p className="font-FixelText_Regular underline text-sm text-white mt-2">
          Propietario, anuncia tu propiedad gratis
        </p>
      </div>

    {/* <button className="w-full py-3 text-base bg-[#FD1F4A] tracking-wider text-white text-center font-Helvetica_Medium rounded-2xl" type="reset">
      Limpiar filtros
    </button> */}

    {/* <FilterItem title="Rango de precio" className="flex flex-row gap-4 w-full mt-3">
      <input type="number" className="w-1/2 rounded-md ring-0 border focus:border-[#FD1F4A]" placeholder="Desde" min={minPrice} max={maxPrice} step={0.01} onChange={setMinPrice} />
      <input type="number" className="w-1/2 rounded-md ring-0 border focus:border-[#FD1F4A]" placeholder="Hasta" min={minPrice} max={maxPrice} step={0.01} onChange={setMaxPrice} />
    </FilterItem> */}
    
    {/* {
      categories.length > 0 && (

        <div className="w-full ">
          <h2 className="font-Helvetica_Light tracking-wide font-bold text-base mb-4">Categorias</h2>
          <div className='bg-black p-[1px] -mt-2 mb-5'></div>
          {categories.map((item) => {

            return item.subcategories.length > 0 && (<div key={item.id} className="w-full">
              <div className="border-b border-gray-200">
                <button
                  type="button"
                  className="w-full flex justify-between items-center py-2 px-4 text-left text-base text-[#111111]  bg-gray-100 hover:bg-gray-200 focus:outline-none"
                  onClick={() => toggleAccordion(item.id)}
                >
                  <span>{item.name}</span>
                  <svg
                    className={`w-5 h-5 transform transition-transform ${openCategories[item.id] ? 'rotate-180' : ''}`}
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>
              </div>
              {openCategories[item.id] && (
                <div className="p-4 border border-t-0 border-gray-200 space-y-4">
                  {
                    item.subcategories.map((subitem) => {

                      const isCheckedfilter = Array.isArray(filter?.subcategory_id) && filter.subcategory_id.includes(String(subitem.id));
                      return <>
                        <label key={subitem.id} htmlFor={`item-category-${subitem.id}`} className="text-custom-border flex flex-row gap-2  items-center cursor-pointer">
                          <input id={`item-category-${subitem.id}`} name='category' type="checkbox" className="text-[#FD1F4A] bg-[#FD1F4A] rounded-sm focus:ring-0 border-none" value={subitem.id} onClick={(e) => onClick(`subcategory_id`, e.target.value, e.target.checked)}
                            defaultChecked={isCheckedfilter}
                          />
                          {subitem.name}
                        </label>
                      </>

                    })
                  }

                </div>
              )}
            </div>
            )

          }
          )}
        </div>

      )
    } */}
    
    {/* {
      tags.length > 0 && <div className="flex flex-col gap-4 w-full">
        <h2 className="font-semibold">Etiquetas</h2>
        <div className='flex flex-row gap-4 w-full flex-wrap'>
          {tags.map(item => {
            const isChecked = item.id === Number(tag_id);

            return (<label key={`item-tag-${item.id}`} htmlFor={`item-tag-${item.id}`} className="text-custom-border flex flex-row gap-2  items-center cursor-pointer">
              <input id={`item-tag-${item.id}`} name='tag' type="checkbox" className="bg-[#DEE2E6] rounded-sm  border-none" value={item.id} onClick={(e) => onClick(`txp.tag_id`, e.target.value, e.target.checked)}
                defaultChecked={isChecked} />
              {item.name}
            </label>)
          })}
        </div>
      </div>
    } */}


    {/* {
      attribute_values.map((x, i) => (
        <FilterItem key={`attribute-${i}`} title={x[0].attribute.titulo} items={x} itemName='valor' itemImg='imagen' onClick={onClick} />
      ))
    } */}


    {/* <button className="text-white bg-[#0168EE] rounded-md font-bold h-10 w-24" type="submit">
      Filtrar
    </button> */}
  </>)
}

export default FilterContainer