

import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import { Link } from "@inertiajs/react";
const CarouselHome = ({ items, searchType }) => {
	return (
		<div className=" py-2 relative">
			<Swiper
				modules={[Navigation, Autoplay]}
				spaceBetween={10}
				slidesPerView={1.4}
				centeredSlides={true}
				loop={true}
				navigation={{
					nextEl: ".button-next-marcas",
					prevEl: ".button-prev-marcas",
				}}
				autoplay={{
					delay: 5000,
				}}
				breakpoints={{
					640: {
						slidesPerView: 3,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 3,
						spaceBetween: 40,
					},
					1024: {
						slidesPerView: 5,
						spaceBetween: 50,
					},
				}}
			>
				{items.map((item) => (
					<SwiperSlide key={item.id}>
						<Link
							href={route('search')} data={{ [searchType]: [item.slug] }}
						>
							<div className="flex flex-col items-center">
								<div className="w-full h-44 p-6 rounded-lg bg-gray-100 flex items-center justify-center">
									<img src={item.img} className=" max-h-full" alt={item.name} />
								</div>

								<span className="font-semibold mt-4 text-sm mnd:text-base">{item.name}</span>
							</div>
						</Link>
					</SwiperSlide>
				))}
			</Swiper>
			<div className="flex items-center w-full absolute top-2/4 z-10 ">
				<button
					aria-label="prev-button"
					className=" absolute button-next-marcas -mt-2 md:-mt-2 w-10 h-10  lg:w-9 lg:h-9 xl:w-10 xl:h-10 3xl:w-12 3xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full text-gray-0 bg-white transition duration-250 hover:bg-indigo-600 hover:text-white focus:outline-none start-0 transform shadow-md  -translate-x-1/4 lg:-translate-x-1/2 "
				>
					<ChevronLeftIcon className="h-6 w-6 lg:h-4 lg:w-4" />
				</button>
				<button
					aria-label="next-button"
					className=" absolute right-0 button-prev-marcas -mt-2 md:-mt-2 w-10 h-10 lg:w-9 lg:h-9 xl:w-10 xl:h-10 3xl:w-12 3xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full bg-white transition duration-250 hover:bg-indigo-600 hover:text-white focus:outline-none end-0 transform shadow-md translate-x-1/4 lg:translate-x-1/2 "
				>
					<ChevronRightIcon className="h-6 w-6 lg:h-4 lg:w-4" />
				</button>
			</div>
		</div >
	)
}

export default CarouselHome
