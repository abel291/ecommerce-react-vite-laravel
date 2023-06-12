import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import CardProduct from "@/Components/Cards/Product";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import SectionTitle from "@/Components/Sections/SectionTitle";


const CarouselProduct = ({ products }) => {
	return (
		<div>
			<SectionTitle title="Productos relacionados" />

			<div className=" py-2 relative">
				<Swiper
					modules={[Navigation, Autoplay]}
					spaceBetween={10}
					slidesPerView={4}

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
							slidesPerView: 2,
							spaceBetween: 10,
						},
						768: {
							slidesPerView: 3,
							spaceBetween: 20,
						},
						1024: {
							slidesPerView: 4,
							spaceBetween: 30,
						},
					}}
				>
					{products.map((product) => (
						<SwiperSlide key={product.slug}>
							<CardProduct product={product} />
						</SwiperSlide>
					))}
				</Swiper>
				<div className="flex items-center w-full absolute top-2/4 z-10 ">
					<button
						aria-label="next-button"
						className=" absolute button-next-marcas -mt-2 md:-mt-2 w-10 h-10  lg:w-9 lg:h-9 xl:w-10 xl:h-10 3xl:w-12 3xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full text-red-6 bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none start-0 transform shadow-md  -translate-x-1/4 lg:-translate-x-1/2 "
					>
						<ChevronLeftIcon className="h-6 w-6 lg:h-4 lg:w-4" />
					</button>
					<button
						aria-label="prev-button"
						className=" absolute right-0 button-prev-marcas -mt-2 md:-mt-2 w-10 h-10 lg:w-9 lg:h-9 xl:w-10 xl:h-10 3xl:w-12 3xl:h-12 text-sm md:text-base lg:text-xl 3xl:text-2xl text-black flex items-center justify-center rounded-full bg-white transition duration-250 hover:bg-primary-600 hover:text-white focus:outline-none end-0 transform shadow-md translate-x-1/4 lg:translate-x-1/2 "
					>
						<ChevronRightIcon className="h-6 w-6 lg:h-4 lg:w-4" />
					</button>
				</div>
			</div>
		</div>
	)
}

export default CarouselProduct
