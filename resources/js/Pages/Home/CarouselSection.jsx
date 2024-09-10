import SimpleCard from '@/Components/Cards/SimpleCard'
import Carousel, { CarouselItem } from '@/Components/Carousel/Carousel'
import { Link } from '@inertiajs/react'
import React from 'react'

const CarouselSection = ({ items, searchType, parameters = {} }) => {

    return (
        <>
            {(items.length <= 6) ? (
                <div className='grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 md:gap-2 justify-around'>
                    {items.map((item, index) => (
                        <div key={item.id}>
                            <Link href={route('search', { [searchType]: item.slug, ...parameters })}>
                                <SimpleCard name={item.name} img={item.img} />
                            </Link>
                        </div>
                    ))}
                </div>
            ) : (
                <Carousel breakpoints={{
                    380: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10,

                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 10,
                    },
                    1536: {
                        slidesPerView: 6,
                        spaceBetween: 10,
                    },
                }
                }>
                    {
                        items.map((item, index) => (
                            <CarouselItem key={index} >
                                <Link href={route('search', { [searchType]: item.id, ...parameters })}>
                                    <SimpleCard name={item.name} img={item.img} />
                                </Link>
                            </CarouselItem>
                        ))
                    }

                </Carousel>
            )}
        </>
    )
}


export default CarouselSection
