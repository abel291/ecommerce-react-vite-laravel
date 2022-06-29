import { Link } from "react-router-dom"
import { formatCurrency } from "../Helpers/helpers";

const ListCardProducts = ({ product, img, productNew }) => {
    return (
        <Link key={product.id} to={"/product/" + product.id + "/" + product.slug}>
            <div className="">
                <div className="h-48 p-2 flex items-center justify-center">
                    <img src={"/img/categories/" + product.img} alt={product.slug} className="max-h-full" />
                </div>
                <div className="">
                    <div className="my-2 space-x-1"></div>
                    <h2 className="text-heading font-medium mb-1 text-sm md:text-base ">{product.name}</h2>
                    <p className="text-body text-xs lg:text-sm leading-normal xl:leading-relaxed line-clamp-2">{product.description_min}</p>
                    <div className="mt-2">
                        {product.offer !== null ? (
                            <div>
                                <div className="text-xs text-gray-400 line-through">{formatCurrency(product.price_default)}</div>
                                <div className="flex items-center">
                                    <div className="text-lg inline-block mr-2 font-bold">{formatCurrency(product.price)}</div>
                                    <div className="inline-block text-green-500 text-xs font-semibold">{product.offer}%</div>
                                </div>
                            </div>
                        ) : (
                            <div className="mr-2 text-lg font-bold">{formatCurrency(product.price)}</div>
                        )}
                    </div>

                    {/* <del className="sm:text-base font-normal text-gray-800">$15.00</del> */}
                </div>
            </div>
        </Link>
    )
}

export default ListCardProducts
