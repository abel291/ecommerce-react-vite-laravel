
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper";
import "swiper/css";
import "swiper/css/navigation";

import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";

const Carousel = ({ children, spaceBetween = 20, ...props }) => {
	const unique_id = Math.random().toString(16).slice(2, 8);
	const pagination_button_next = "button-next-" + unique_id
	const pagination_button_prev = "button-prev-" + unique_id
	return (
		<div className="relative">
			<Swiper
				modules={[Navigation, Autoplay]}
				spaceBetween={spaceBetween}
				//slidesPerView={slidesPerView}
				autoplay={{
					delay: 5000,
				}}
				pagination={{
					clickable: true,
				}}
				loop={false}
				watchOverflow={true}
				navigation={{
					nextEl: "." + pagination_button_next,
					prevEl: "." + pagination_button_prev,
				}}
				{...props}
			>
				{children}
			</Swiper>
			<div className="flex items-center w-full absolute top-2/4 z-10 ">
				<button
					aria-label="prev-button"
					className={pagination_button_prev + " absolute -mt-2 md:-mt-2 w-10 h-10  lg:w-9 lg:h-9 xl:w-10 xl:h-10 2xl:w-12 2xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full text-gray-0 bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none start-0 transform shadow-md  -translate-x-1/4 lg:-translate-x-1/2 "}
				>
					<ChevronLeftIcon className="h-6 w-6 lg:h-6 lg:w-6" />
				</button>
				<button
					aria-label="next-button"
					className={pagination_button_next + " absolute right-0 -mt-2 md:-mt-2 w-10 h-10 lg:w-9 lg:h-9 xl:w-10 xl:h-10 2xl:w-12 2xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none end-0 transform shadow-md translate-x-1/4 lg:translate-x-1/2 "}
				>
					<ChevronRightIcon className="h-6 w-6 lg:h-6 lg:w-6" />
				</button>
			</div>
		</div >
	)
}

export default Carousel

export const CarouselItem = SwiperSlide;
