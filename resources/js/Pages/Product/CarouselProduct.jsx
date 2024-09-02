import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import CardProduct from "@/Components/Cards/CardProduct";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import SectionTitle from "@/Components/Sections/SectionTitle";
import Carousel, { CarouselItem } from "@/Components/Carousel/Carousel";
import GridProduct from "@/Components/Grids/GridProduct";

const CarouselProduct = ({ productVariants }) => {
    console.log(productVariants)
    return productVariants.length > 5 ? (
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
                        slidesPerView: 4,
                        spaceBetween: 15,
                    },
                    1536: {
                        slidesPerView: 5,
                        spaceBetween: 20,
                    },


                }}
            >
                {productVariants.map((variant, index) => (
                    <CarouselItem className="h-auto pb-1 " key={index}>
                        {/* <CardProduct productVariant={variant} /> */}
                    </CarouselItem>
                ))}
            </Carousel>
        </div>
    ) : (
        <GridProduct>
            {productVariants.map((variant, index) => (
                {/* <CardProduct productVariant={variant} key={index} /> */ }
            ))}
        </GridProduct>
    );
};

export default CarouselProduct;
