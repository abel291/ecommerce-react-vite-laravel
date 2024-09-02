import { formatCurrency } from "@/Helpers/helpers";
import { Link } from "@inertiajs/react";
import Badge from "../Badge";
import ProductPriceOffer from "../ProductPriceOffer";

const CardProduct = ({ productVariant, productNew = false }) => {


    console.log(productVariant)
    return (
        <Link
            key={productVariant.id}
            href={route("product", { slug: productVariant.product.slug, color: productVariant.color.slug })}
            className="w-full relative block max-w-md mx-auto group h-full overflow-hidden rounded-md transition duration-200 ease-in-out transform hover:-translate-y-1 md:hover:-translate-y-1.5 hover:shadow "
        >
            <div className="h-full flex flex-col">
                <div >
                    <div className="flex justify-center">
                        <img
                            src={productVariant.thumb}
                            alt={productVariant.product.slug}
                            className="w-full object-cover object-top rounded-md group-hover:rounded-none "
                        />
                    </div>
                </div>
                <div className="grow flex flex-col px-4 pt-4 pb-3 space-y-3">
                    <h2
                        className="text-heading text-sm md:text-sm line-clamp-1 "
                        alt={productVariant.product.name}
                        title={productVariant.product.name}
                    >
                        {productVariant.product.name}
                    </h2>

                    <div className="flex gap-x-2 items-center flex-wrap ">
                        {productVariant.product.variants.map((variant) => (
                            <div
                                key={productVariant.id}
                                className={"size-6 p-[2px] border rounded-full flex items-center " +
                                    (productVariant.color.id == variant.color.id ? 'border-gray-700' : 'border-gray-300')}
                            >
                                <span style={{ backgroundImage: "url(" + variant.color.img + ")" }} aria-hidden="true" className="w-full h-full rounded-full  inline-block "></span>
                            </div>
                        ))}
                    </div>

                    <div className=" grow flex items-end justify-between ">
                        <ProductPriceOffer
                            price={productVariant.price}
                            old_price={productVariant.old_price}
                            offer={productVariant.offer}

                        />
                    </div>
                </div>
            </div>
        </Link>
    );
};

export default CardProduct;
