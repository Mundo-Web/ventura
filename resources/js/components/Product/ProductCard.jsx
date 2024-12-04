import Tippy from '@tippyjs/react';
import React, { useState } from 'react';
import 'tippy.js/dist/tippy.css';

const ProductCard = ({ item, width, bgcolor, is_reseller }) => {
  const [showAmbiente, setShowAmbiente] = useState(false);
  const category = item.category;


  return (
    <div className={`flex flex-col relative w-full  bg-white`} data-aos="zoom-in-left">
      <div className={`bg-white product_container basis-4/5 flex flex-col justify-center relative border`}>
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
      </a>
    </div>
  );
};

export default ProductCard;