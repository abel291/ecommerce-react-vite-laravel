import { formatCurrency } from "@/Helpers/helpers"
import { Link } from "@inertiajs/react"
import Badge from "../Badge"


const CardProduct = ({ product, badge = "" }) => {
    return (
        <Link key={product.id} href={route('product', product.slug)}
            className="relative block max-w-md mx-auto rounded-md overflow-hidden transition duration-200 ease-in-out transform hover:-translate-y-1 md:hover:-translate-y-1.5 hover:shadow-lg " >
            {/*  */}
            <div className="h-full flex flex-col">
                <div className="flex items-center justify-center relative  overflow-hidden md:h-80">
                    {/* {product.offer > 0 && (
						<div className="absolute inset-0 z-10 top-3 left-4">
							<span className=" bg-green-600 border-transparent   text-white inline-flex items-center rounded-md  px-2 py-1 text-xs font-semibold  ring-1 ring-inset" >{product.offer}%</span>
						</div>
					)} */}
                    <img src={product.thumb} alt={product.slug} className="w-full h-full object-cover object-top rounded-b-md hover:rounded-none " />
                </div>

                <div className="grow flex flex-col px-4 py-6">
                    <h2 className="text-heading text-sm md:text-sm  ">{product.name}</h2>

                    {/* <p className="mt-3  text-sm leading-normal xl:leading-relaxed line-clamp-2 text-gray-600">
						{product.description_min}
					</p> */}

                    <div className="pt-2 grow flex items-end justify-between ">
                        <div>
                            {product.offer ? (
                                <>
                                    <div className="text-xs text-gray-400 line-through">{formatCurrency(product.price)}</div>
                                    <div className="flex items-center">
                                        <div className="text-lg inline-block mr-2 font-semibold">{formatCurrency(product.price_offer)}</div>
                                        <div className="inline-block text-green-500 text-xs font-semibold">{product.offer}%</div>
                                    </div>
                                </>
                            ) : (
                                <div className="mr-2 text-lg font-semibold">{formatCurrency(product.price_offer)}</div>
                            )}
                        </div>

                    </div>
                </div>
            </div>

        </Link >
    )
}

export default CardProduct
