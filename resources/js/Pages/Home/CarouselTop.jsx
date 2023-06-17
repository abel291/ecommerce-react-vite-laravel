

import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import { Link } from "@inertiajs/react";
import CarouselBanner from "@/Components/Carousel/CarouselBanner";
import Carousel, { CarouselItem } from "@/Components/Carousel/Carousel";
const CarouselHome = ({ images }) => {

	return (
		<Carousel>
			{images.map((item) => (
				<CarouselItem key={item.link} >
					<Link key={item.link}
						href={item.link}
					>
						<div className="flex justify-center items-center">
							<img
								className=" max-w-full w-full max-h-[550px] object-cover object-center rounded md:rounded-xl"
								src={item.img}
								alt={item.alt}
								title={item.title}
							/>
						</div>
					</Link>
				</CarouselItem>
			))}

		</Carousel>
	)
}

export default CarouselHome
{/* <Swiper
				modules={[Navigation, Autoplay]}
				slidesPerView={1}
				spaceBetween={10}
				loop={true}
				navigation={{
					nextEl: "." + pagination_button_next,
					prevEl: "." + pagination_button_prev,
				}}
				autoplay={{
					delay: 5000,
				}}
				breakpoints={{
					640: {
						slidesPerView: 2,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 4,
						spaceBetween: 30,
					},
					1024: {
						slidesPerView: 5,
						spaceBetween: 40,
					},
				}}
			>
				{items.map((item) => (
					<SwiperSlide key={item.slug}>
						<Link
							href={route('search')} data={{ [searchType]: [item.slug] }}
						>
							<div className="flex flex-col items-center">
								<div className="w-full h-44 p-6 rounded-lg bg-gray-50 flex items-center justify-center">
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
					className={pagination_button_next + " absolute button-next-marcas -mt-2 md:-mt-2 w-10 h-10  lg:w-9 lg:h-9 xl:w-10 xl:h-10 3xl:w-12 3xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full text-gray-0 bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none start-0 transform shadow-md  -translate-x-1/4 lg:-translate-x-1/2 "}
				>
					<ChevronLeftIcon className="h-6 w-6 lg:h-4 lg:w-4" />
				</button>
				<button
					aria-label="next-button"
					className={pagination_button_prev + " absolute right-0 button-prev-marcas -mt-2 md:-mt-2 w-10 h-10 lg:w-9 lg:h-9 xl:w-10 xl:h-10 3xl:w-12 3xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none end-0 transform shadow-md translate-x-1/4 lg:translate-x-1/2 "}
				>
					<ChevronRightIcon className="h-6 w-6 lg:h-4 lg:w-4" />
				</button>
			</div> */}