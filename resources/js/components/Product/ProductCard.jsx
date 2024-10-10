import Tippy from '@tippyjs/react';
import React, { useState } from 'react';
import 'tippy.js/dist/tippy.css';

const ProductCard = ({ item, width, bgcolor, is_reseller }) => {
  const [showAmbiente, setShowAmbiente] = useState(false);
  const category = item.category;


  return (
    <div
      onMouseEnter={() => setShowAmbiente(true)}
      onMouseLeave={() => setShowAmbiente(false)}
      className={`flex flex-col relative w-full md:${width} ${bgcolor}`} data-aos="zoom-in-left"
    >
      <div className={`${bgcolor} product_container basis-4/5 flex flex-col justify-center relative border`}>
        <div className="absolute top-2 left-2 w-max">
          {item.tags?.map((tag) => (
            <div className="px-4 mb-1" key={tag.id}>
              <span
                className="block font-semibold text-[8px] md:text-[12px] bg-black py-2 px-3 flex-initial w-full text-center text-white rounded-[5px] relative top-[18px] z-10"
                style={{ backgroundColor: tag.color }}
              >
                {tag.name}
              </span>
            </div>
          ))}
          {
            item.descuento > 0 && <div className="px-4 mb-1">
              <span
                className="block font-semibold text-[8px] md:text-[12px] bg-black py-2 px-3 flex-initial w-full text-center text-white rounded-[5px] relative top-[18px] z-10"
                style={{ backgroundColor: '#10c469' }}
              >
                -{Math.round(100 - ((item.descuento * 100) / item.precio))}%
              </span>
            </div>
          }
        </div>
        <div>
          <div className="relative flex justify-center items-center h-max">
            <img
              style={{
                opacity: !item.imagen_ambiente || !showAmbiente ? '1' : '0',
                scale: !item.imagen_ambiente || !showAmbiente ? '1.05' : '1',
                backgroundColor: '#eeeeee'
              }}
              src={item.imagen ? `/${item.imagen}` : '/images/img/noimagen.jpg'}
              alt={item.name}
              onError={(e) => e.target.src = '/images/img/noimagen.jpg'}
              className={`transition ease-out duration-300 transform w-full aspect-square object-cover inset-0`}
            />

            {item.imagen_ambiente && (
              <img
                style={{
                  opacity: showAmbiente ? '1' : '0',
                  scale: showAmbiente ? '1.05' : '1'
                }}
                src={`/${item.imagen_ambiente}`}
                alt={item.name}
                onError={(e) => e.target.src = '/images/img/noimagen.jpg'}
                className="transition ease-out duration-300 transform w-full h-full aspect-square object-cover absolute inset-0"
              />
            )}
          </div>
          <div className="addProduct text-center flex justify-center h-0">
            <div className='flex flex-row gap-2 items-center'>
              <a
                href={`/producto/${item.id}`}
                className="font-FixelText_Medium text-base bg-[#006258] py-2 px-6 text-center text-white rounded-3xl h-10"
              >
                Ver producto
              </a>
            </div>

          </div>
        </div>
      </div>
      <a href={`/producto/${item.id}`} className='px-1 py-2 flex flex-col gap-3'>
        <Tippy content={item.producto}>
          <h2 className="block text-lg text-left overflow-hidden font-Homie_Bold text-[#002677]" style={{ display: '-webkit-box', WebkitLineClamp: 2, textOverflow: 'ellipsis', WebkitBoxOrient: 'vertical', height: '51px' }}>
            {item.producto}
          </h2>
        </Tippy>
          <p className="block text-[13px] lg:text-base text-left overflow-hidden font-FixelText_Light text-[#000929]" style={{ display: '-webkit-box', WebkitLineClamp: 2, textOverflow: 'ellipsis', WebkitBoxOrient: 'vertical', height: '42px' }}>
            {item.extract}
          </p> 
        {/* {
          is_reseller ?
            (<>
              <div className="flex content-between flex-row gap-4 items-center justify-start">
                <span className="text-[#15294C] opacity-60 text-[16.45px]  line-through">S/. {item.descuento > 0 ? item.descuento : item.precio}</span>
                {item.descuento > 0 && (
                  <span className="text-sm text-[#15294C] opacity-60 line-through">S/. {item.precio}</span>
                )}
              </div>
              <div className="flex content-between flex-row gap-4 items-center justify-start">
                Reseller <span className="text-[#FD1F4A] text-[16.45px] font-bold">S/. {item.precio_reseller}</span>

              </div></>

            ) :
            (<div className="w-full flex content-between flex-row gap-4 items-center justify-start text-left">
              <span className="text-[#FD1F4A] font-Helvetica_Medium font-bold">{item.descuento > 0 ? 
                
              <div className='flex flex-col justify-start items-center'>
                <span className='text-lg'>S/. {item.descuento}</span>
              </div> : 

              <div className='flex flex-col justify-start items-center text-lg '>
                <span className='font-bold text-lg'>S/. {item.precio}</span>
              </div>

              }
              </span>
              {item.descuento > 0 && (
                <>
                  <div className='flex flex-col items-start'>
                    
                    <span className=" text-[#15294C] opacity-80 line-through font-bold text-[12px] md:text-base"> S/. {item.precio}</span>
                  </div>
                </>
              )}
            </div>)
        } */}

      </a>


    </div>
  );
};

export default ProductCard;