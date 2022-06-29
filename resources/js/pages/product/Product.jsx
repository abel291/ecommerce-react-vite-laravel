import apiClient from "../../auth/apiClient"
import CarouselProduct from "./CarouselProduct"
import LoadingPage from "../../components/LoadingPage"

import { useQuery } from "react-query"

import ImagesProduct from "./ImagesProduct"
import Description from "./Description"
import { useParams } from "react-router"
import Feacture from "./Feacture"
import { Link } from "react-router-dom"
import PageError from "../../components/PageError"

const fetchProduct = async (id, slug) => {
    const response = await apiClient.get("/product/" + id + "/" + slug).then((res) => {
        return {
            product: res.data.product,
            relatedProducts: res.data.related_products,
        }
    })
    return response
}

const Product = () => {
    const { id, slug } = useParams()
    const {
        error,
        data: { product, relatedProducts },
    } = useQuery(["product", id], () => fetchProduct(id, slug), {
        staleTime: Infinity,
        placeholderData: {
            product: null,
            relatedProducts: [],
        },
    })

    if (!product) return <LoadingPage />

    if (error) return <PageError />

    return (
        <div className="container py-content">
            <div className="hidden md:block text-sm text-gray-400">
                <span>
                    <Link

                        to="/search"
                        state={{ categories: product.category.slug }}
                    >
                        {product.category.name}
                    </Link>
                </span>
                <span> / </span>
                <span>{product.name}</span>
            </div>
            <div className="flex flex-col-reverse md:flex-row ">
                <div className="py-content w-full md:w-7/12">
                    <ImagesProduct product={product} />
                </div>
                <div className="py-content w-full md:w-5/12 md:pl-10 py-content">
                    <Feacture product={product} />
                </div>
            </div>
            <div className="w-full md:w-7/12">
                <Description product={product} />
            </div>
            <div className="py-content">
                <CarouselProduct products={relatedProducts} />
            </div>
        </div>
    )
}

export default Product
