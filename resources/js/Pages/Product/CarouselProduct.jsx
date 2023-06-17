import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import CardProduct from "@/Components/Cards/CardProduct";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import SectionTitle from "@/Components/Sections/SectionTitle";
import Carousel, { CarouselItem } from "@/Components/Carousel/Carousel";


const CarouselProduct = ({ products }) => {
	return (
		<div>
			<SectionTitle title="Productos relacionados" />
			<div className="mt-5 ">
				<Carousel

					centeredSlides={false}
					breakpoints={{
						380: {
							slidesPerView: 1,
							spaceBetween: 20,
						},
						640: {
							slidesPerView: 2,
							spaceBetween: 20,
						},
						768: {
							slidesPerView: 2,
							spaceBetween: 10,
						},
						1024: {
							slidesPerView: 3,
							spaceBetween: 10,
						},
						1280: {
							slidesPerView: 4,
							spaceBetween: 10,
						},

					}}
				>
					{products.map((product) => (
						<CarouselItem className="h-auto pb-5 " key={product.slug}>
							<CardProduct product={product} />
						</CarouselItem>
					))}
				</Carousel>

			</div>
		</div>
	)
}

export default CarouselProduct
