import { formatCurrency } from "@/Helpers/helpers";
import { Link } from "@inertiajs/react";
import Badge from "../Badge";
import ProductPriceOffer from "../ProductPriceOffer";

const CardProduct = ({ product, productNew = false }) => {


    // console.log(product)
    return (
        <Link

            href={route("product", { slug: product.slug, ref: product.ref })}
            className="w-full relative block max-w-md mx-auto group h-full overflow-hidden rounded-md transition duration-200 ease-in-out transform hover:-translate-y-1 md:hover:-translate-y-1.5 hover:shadow "
        >
            <div className="h-full flex flex-col">
                <div >
                    <div className="flex justify-center">
                        <img
                            src={product.thumb}
                            alt={product.slug}
                            className="w-full object-cover object-top rounded-md group-hover:rounded-none "
                        />
                    </div>
                </div>
                <div className="grow flex flex-col px-4 pt-4 pb-3 space-y-3">
                    <h2
                        className="text-heading text-sm md:text-sm line-clamp-1"
                        alt={product.name}
                        title={product.name}
                    >
                        {product.name}
                    </h2>

                    <div className="flex gap-x-2 items-center flex-wrap ">
                        {product.colors.map((color) => (
                            <div
                                key={color.id}
                                title={color.name}
                                className={"size-6 p-[2px] border rounded-full flex items-center " +
                                    (product.color_id == color.id ? 'border-gray-700' : 'border-gray-300')}
                            >
                                <span style={{ backgroundImage: "url(" + color.img + ")" }} aria-hidden="true" className="w-full h-full rounded-full  inline-block "></span>
                            </div>
                        ))}
                    </div>

                    <div className=" grow flex items-end justify-between ">
                        <ProductPriceOffer
                            price={product.price}
                            old_price={product.old_price}
                            offer={product.offer}

                        />
                    </div>
                </div>
            </div>
        </Link>
    );
};

export default CardProduct;
