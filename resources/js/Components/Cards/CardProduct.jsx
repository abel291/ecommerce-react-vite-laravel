import { formatCurrency } from "@/Helpers/helpers";
import { Link } from "@inertiajs/react";
import Badge from "../Badge";
import ProductPriceOffer from "../ProductPriceOffer";

const CardProduct = ({ product, }) => {

    return (
        <Link
            key={product.id}
            href={route("product", product.slug)}
            className="relative block max-w-md mx-auto group h-full overflow-hidden rounded-lg transition duration-200 ease-in-out transform hover:-translate-y-1 md:hover:-translate-y-1.5 hover:shadow "
        >
            <div className="h-full flex flex-col">
                <div >
                    <div className="aspect-square flex justify-center">
                        <img
                            src={product.sku.thumb}
                            alt={product.slug}
                            className="object-scale-down rounded-md group-hover:rounded-none "
                        />
                    </div>
                </div>
                <div className="grow flex flex-col px-4 pt-6 pb-4 space-y-3">
                    <h2
                        className="text-heading text-sm md:text-sm line-clamp-2 "
                        alt={product.name}
                        title={product.name}
                    >
                        {product.name}
                    </h2>

                    <div className="flex gap-x-2 items-center flex-wrap ">
                        {product.skus.map((sku) => (
                            <div className="size-6 p-[3px] ring-1 ring-black/20 rounded-full flex items-center">
                                <span style={{ backgroundImage: "url(" + sku.color.img + ")" }} aria-hidden="true" className="w-full h-full rounded-full  inline-block "></span>
                            </div>
                        ))}
                    </div>

                    <div className=" grow flex items-end justify-between ">
                        <ProductPriceOffer price={product.price} old_price={product.old_price} offer={product.offer} />
                    </div>
                </div>
            </div>
        </Link>
    );
};

export default CardProduct;
