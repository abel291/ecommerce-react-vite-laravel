import { Link } from "react-router-dom"
import BannerSection from "../../components/BannerSection"

import ListCardProducts from "../../components/ListCardProducts"
import LoadingPage from "../../components/LoadingPage"
import PageError from "../../components/PageError"
import TitlePage from "../../components/TitlePage"
import usePage from "../../hooks/usePage"

const Combos = () => {
    const { isLoading, error, data: combos } = usePage("assemblies")

    if (isLoading) return <LoadingPage />

    if (error) return <PageError />
    return (
        <div className="container">
            <div className="py-content ">
                <BannerSection img="/img/combos/banner-1.jpg" />
            </div>
            <div className="py-content">
                <TitlePage
                    title="Combos"
                    subTitle="¡Todos nuestros ensambles disponibles, personalizados con marcas reconocidas y fiables del mercado gamer.!"
                />
            </div>

            <div className="py-content">
                <div className="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6">
                    {combos.products.map((product) => (
                        <ListCardProducts key={product.id} product={product} />
                    ))}
                </div>
            </div>
            <div className="py-content text-center">
                <Link
                    
                    to="/search"
                        state={{ categories: "combos"}}
                    className="text-lg font-semibold border border-gray-300 rounded-md py-3 px-6"
                >
                    Ver mas
                </Link>
            </div>
        </div>
    )
}

export default Combos
