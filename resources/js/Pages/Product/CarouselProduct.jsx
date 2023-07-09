import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import CardProduct from "@/Components/Cards/CardProduct";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import SectionTitle from "@/Components/Sections/SectionTitle";
import Carousel, { CarouselItem } from "@/Components/Carousel/Carousel";
import GridProduct from "@/Components/Grids/GridProduct";


const CarouselProduct = ({ products }) => {
	return (
		products.length > 5 ? (
			<div>
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
							spaceBetween: 15,
						},
						1280: {
							slidesPerView: 5,
							spaceBetween: 24,
						},

					}}
				>
					{products.map((product) => (
						<CarouselItem className="h-auto pb-1 " key={product.slug}>
							<CardProduct product={product} />
						</CarouselItem>
					))}
				</Carousel>

			</div>
		) : (
			<GridProduct>
				{products.map((product) => (

					<CardProduct product={product} key={product.slug} />

				))}
			</GridProduct>
		)
	)
}

export default CarouselProduct
