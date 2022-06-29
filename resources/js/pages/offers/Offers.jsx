import ListCardProducts from "../../components/ListCardProducts"
import { Link } from "react-router-dom"
import LoadingPage from "../../components/LoadingPage"

import usePage from "../../hooks/usePage"
import BannerSection from "../../components/BannerSection"
import TitlePage from "../../components/TitlePage"
import Button from "../../components/Button"
import PageError from "../../components/PageError"
const Offers = () => {
    const { isLoading, error, data: offers } = usePage("offers")
    
    if (isLoading) return <LoadingPage />

    if (error) return <PageError />

    return (
        <div className="container">
            <div className="py-content ">
                <BannerSection img="/img/offers/banner-1.jpg" />
            </div>
            <div className="py-content ">
                <TitlePage title="Ofertas" subTitle="¡Encuentra precios increíbles cada día!" />
            </div>
            <div className="py-content">
                <div className="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 md:gap-6">
                    {offers.products.map((product) => (
                        <ListCardProducts key={product.id} product={product} />
                    ))}
                </div>
            </div>
            <div className="py-content text-center">
                <Link
                    
                    to="/search"
                    state={{ offers: 10 }}
                    className=""
                >
                    <Button>Ver mas</Button>
                </Link>
            </div>
        </div>
    )
}

export default Offers
