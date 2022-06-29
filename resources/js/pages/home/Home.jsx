import ListCardProducts from "../../components/ListCardProducts"
import CarouselBanners from "../../components/CarouselBanners"
import usePage from "../../hooks/usePage"
import CarouselHome from "./CarouselHome"
import LoadingPage from "../../components/LoadingPage"
import { useData } from "../../hooks/useData"
import PageError from "../../components/PageError"
import BannerSection from "../../components/BannerSection"
import SectionsHome from "./SectionsHome"

// import Payment from "./Payment"

const Home = () => {
    const { isLoading, error, data: home } = usePage("home")
    const { data } = useData()

    if (isLoading) return <LoadingPage />

    if (error) return <PageError />

    return (
        <>
            <div className="container">
                <div className="py-content grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-5 ">
                    <div className="col-span-1 md:col-span-2 ">
                        <CarouselBanners images={home.banners.carousel} />
                    </div>

                    <div>
                        <a href={home.banners.left.path} target="blank">
                            <img
                                className="h-full mx-auto object-cover w-full rounded-lg overflow-hidden"
                                src={home.banners.left.img}
                                alt={home.banners.left.alt}
                            />
                        </a>
                    </div>
                    <div>
                        <a href={home.banners.right.path} target="blank">
                            <img
                                className="h-full mx-auto object-cover w-full rounded-lg overflow-hidden"
                                src={home.banners.right.img}
                                alt={home.banners.right.alt}
                            />
                        </a>
                    </div>
                </div>


                <SectionsHome title={"Destacados"}>
                    <div className="">
                        <div className="grid grid-cols-2 gap-2 md:grid-cols-4 md:gap-6 ">
                            {home.featured.map((product) => (
                                <ListCardProducts key={product.id} product={product} />
                            ))}
                        </div>
                    </div>
                </SectionsHome>

                <div className="py-content ">
                    <BannerSection img="/img/home/banner-seccion-1.jpg" />
                </div>

                <SectionsHome title={"Categorias"}>
                    <CarouselHome items={data.categories} typeItem="categories" />
                </SectionsHome>

                <SectionsHome title={"Los recién llegados"}>
                    <div className=" py-2 relative">
                        <div className="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6 ">
                            {home.new.map((item) => (
                                <ListCardProducts key={item.id} product={item} productNew={true} />
                            ))}
                        </div>
                    </div>
                </SectionsHome>


                <div className="py-content ">
                    <BannerSection img="/img/home/banner-seccion-2.jpg" />
                </div>

                <SectionsHome title={"Top Marcas"}>
                    <CarouselHome items={data.brands} typeItem="brands" />
                </SectionsHome>

            </div>
        </>
    )
}



export default Home
