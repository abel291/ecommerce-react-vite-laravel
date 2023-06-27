import Carousel, { CarouselItem } from '@/Components/Carousel/Carousel'
import { Link } from '@inertiajs/react'
import React from 'react'

const CarouselSection = ({ items, searchType }) => {
	return (
		<Carousel breakpoints={{
			380: {
				slidesPerView: 1,
				spaceBetween: 20,
			},
			640: {
				slidesPerView: 2,
				spaceBetween: 20,
			},
			768: {
				slidesPerView: 3,
				spaceBetween: 30,

			},
			1024: {
				slidesPerView: 4,
				spaceBetween: 40,
			},
			1536: {
				slidesPerView: 6,
				spaceBetween: 40,
			},
		}}>
			{items.map((item, index) => (
				<CarouselItem key={index} >
					<Link
						href={route('search')} data={{ [searchType]: [item.slug] }}
					>
						<div className="flex flex-col items-center">
							<div className="w-48 max-w-full h-48 p-6 rounded-lg bg-gray-50 flex items-center justify-center">

								<img src={item.img} className="max-w-full max-h-28" alt={item.name} />

							</div>

							<span className="font-semibold mt-4 text-sm md:text-base ">{item.name}</span>
						</div>
					</Link>
				</CarouselItem>
			))}

		</Carousel>
	)
}

export default CarouselSection