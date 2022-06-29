
import { Link } from "react-router-dom"
import CarouselBanners from "../../components/CarouselBanners"
import ListCardProducts from "../../components/ListCardProducts"
import LoadingPage from "../../components/LoadingPage"
import PageError from "../../components/PageError"
import TitlePage from "../../components/TitlePage"
import usePage from "../../hooks/usePage"


const Assemblies = () => {
    const { isLoading, error, data: assemblies } = usePage("assemblies")

    if (isLoading) return <LoadingPage />

    if (error) return <PageError />

    return (
        <div className="container">
            <div className="py-content">
                <CarouselBanners images={assemblies.banners} path="/img/assemblies/" />
            </div>
            <TitlePage
                title="Ensambles"
                subTitle="¡Todos nuestros ensambles disponibles, personalizados con marcas reconocidas y fiables del mercado gamer.!"
            />

            <div className="py-content">
                <div className="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6">
                    {assemblies.products.map((product) => (
                        <ListCardProducts key={product.id} product={product} />
                    ))}
                </div>
            </div>
            <div className="py-content text-center">
                <Link                   
                    to="/search"
                    state={{ categories:"ensambles" }}
                    className="text-lg font-bold border border-gray-300 rounded py-2 px-4"
                >
                    Ver mas
                </Link>
            </div>
        </div>
    )
}

export default Assemblies
