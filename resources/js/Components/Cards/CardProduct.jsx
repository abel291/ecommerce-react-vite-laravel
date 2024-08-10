import { formatCurrency } from "@/Helpers/helpers";
import { Link } from "@inertiajs/react";
import Badge from "../Badge";

const CardProduct = ({ product, badge = "" }) => {
    return (
        <Link
            key={product.id}
            href={route("product", product.slug)}
            className="relative block max-w-md mx-auto rounded-md overflow-hidden transition duration-200 ease-in-out transform hover:-translate-y-1 md:hover:-translate-y-1.5 hover:shadow "
        >
            <div className="h-full flex flex-col">
                <div className="h-56 px-2 flex items-center justify-center relative  ">
                    <img
                        src={product.thumb}
                        alt={product.slug}
                        className="  max-w-full max-h-full"
                    />
                </div>
                <div className="grow flex flex-col px-4 py-6">
                    <h2
                        className="text-heading text-sm md:text-sm "
                        alt={product.name}
                        title={product.name}
                    >
                        {product.name}
                    </h2>

                    {/* <p className="mt-3  text-sm leading-normal xl:leading-relaxed line-clamp-2 text-gray-600">
						{product.description_min}
					</p> */}

                    <div className="pt-2 grow flex items-end justify-between ">
                        <div>
                            {product.offer > 0 ? (
                                <>
                                    <div className="text-xs text-gray-400 line-through">
                                        {formatCurrency(product.old_price)}
                                    </div>
                                    <div className="flex items-center">
                                        <div className="text-lg inline-block mr-2 font-semibold">
                                            {formatCurrency(product.price)}
                                        </div>
                                        <div className="inline-block text-green-500 text-xs font-semibold">
                                            {product.offer}%
                                        </div>
                                    </div>
                                </>
                            ) : (
                                <div className="mr-2 text-lg font-semibold">
                                    {formatCurrency(product.price)}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </Link>
    );
};

export default CardProduct;
