// Import Swiper React components
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper";

// Import Swiper styles
import 'swiper/css';
import { Link } from "@inertiajs/react";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import Banner from "./Banner";

export default function CarouselBanner({ images, spaceBetween = 20, slidesPerView = 1, centeredSlides = true, ...props }) {
	const unique_id = Math.random().toString(16).slice(2, 8);
	const pagination_button_next = "button-next-" + unique_id
	const pagination_button_prev = "button-prev-" + unique_id
	return (
		<>
			{images.length > 1 && (
				<div className="relative">
					<Swiper
						modules={[Navigation, Autoplay]}
						spaceBetween={spaceBetween}
						slidesPerView={slidesPerView}
						centeredSlides={centeredSlides}
						autoplay={{
							delay: 5000,
						}}
						pagination={{
							clickable: true,
						}}
						loop={true}
						navigation={{
							nextEl: "." + pagination_button_next,
							prevEl: "." + pagination_button_prev,
						}}
						{...props}
					>
						{images.map((image, index) => (
							<SwiperSlide key={index}>
								<a href={image.link}>
									<div className="flex justify-center items-center">
										<img
											className=" max-w-full w-full max-h-[550px] object-cover object-center rounded md:rounded-xl"
											src={image.img}
											alt={image.alt}
										/>
									</div>
								</a>
							</SwiperSlide>
						))}
					</Swiper>
					<div className="flex items-center w-full absolute top-2/4 z-10 ">
						<button
							aria-label="prev-button"
							className={pagination_button_next + " absolute  h-10 w-8 md:h-20 md:w-14 text-black flex items-center justify-center rounded-md text-gray-0 bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none start-0 transform shadow-md -translate-x-1/4 lg:-translate-x-1/2"}
						>
							<ChevronLeftIcon className="h-4 w-4 md:h-7 md:w-7" />
						</button>
						<button
							aria-label="next-button"
							className={pagination_button_prev + " absolute right-0  h-10 w-8 md:h-20 md:w-14 text-black flex items-center justify-center rounded-md bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none end-0 transform shadow-md translate-x-1/4  lg:translate-x-1/2"}
						>
							<ChevronRightIcon className="h-4 w-4 md:h-7 md:w-7" />
						</button>
					</div>
				</div >
			)
			}
			{
				images.length == 1 && (
					<div>
						<Banner image={images[0]} />
					</div>
				)
			}
		</>
	)

};

