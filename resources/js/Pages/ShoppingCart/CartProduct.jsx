

import InputError from "@/Components/Form/InputError";
import { formatCurrency } from "../../Helpers/helpers";
import { Link, router, useForm } from "@inertiajs/react";
import Spinner from "@/Components/Spinner";
import CartAttributes from "./CartAttributes";
import { useEffect, useRef } from "react";
import ProductPriceOffer from "@/Components/ProductPriceOffer";
const ProductsCart = ({ cardProduct }) => {


    const { data, setData, delete: destroy, post, processing, errors } = useForm({
        quantity: cardProduct.quantity,
        skuId: cardProduct.skuId,
    })


    const handleChangeQuantity = (e) => {
        let quantity = e.target.value
        setData('quantity', quantity);
    }

    const handleClickRemoveItem = () => {
        destroy(route('shopping-cart.destroy', cardProduct.skuId), {
            preserveScroll: true,
        })
    }

    const first = useRef(true);
    useEffect(() => {
        if (first.current) {
            first.current = false;
            return;
        }

        post(route('shopping-cart.store'), {
            preserveScroll: true,
        })

    }, [data])
    return (
        <div className="relative">
            <div className={" py-5 w-full relative "}>
                {processing && (
                    <div className="absolute inset-0 opacity-70 bg-white z-10 flex justify-center items-center">
                        <Spinner />
                    </div>
                )}

                <div className="grid grid-cols-12 gap-6 md:gap-4 items-stretch h-24">
                    <div className="col-span-5 md:col-span-1">
                        <Link href={route('product', { slug: cardProduct.slug, color: cardProduct.color.slug })}>
                            <div className=" flex items-center justify-center h-full">
                                <img className=" md:max-h-28 lg:max-h-28 max-w-full object-cover" src={cardProduct.thumb} alt={cardProduct.name} />
                            </div>
                        </Link>
                    </div>
                    <div className="col-span-7 md:col-span-6">
                        <div className="flex flex-col  h-full gap-y-2">
                            <div className="flex justify-between text-base font-medium text-gray-900">
                                <h3>{cardProduct.name}</h3>
                            </div>
                            <div className="divide-x flex items-center text-sm ">
                                <div className=" text-gray-500 pr-2">Color {cardProduct.color.name}</div>
                                <div className=" text-gray-500 pl-2">Talla {cardProduct.size.name}</div>
                            </div>

                        </div>
                    </div>
                    <div className=" col-span-6 md:col-span-2">
                        <div>
                            <select
                                className="select-form"
                                name="quantity"
                                disabled={processing}
                                onChange={handleChangeQuantity}
                                value={cardProduct.quantity}
                            >
                                {[...Array(cardProduct.max_quantity).keys()].map((i) => (
                                    <option key={i} value={i + 1}>
                                        {i + 1}
                                    </option>
                                ))}
                            </select>

                            <div className=" text-gray-400 text-xs mt-2 space-y-1">
                                <span className="block">{cardProduct.stock} disponibles</span>

                            </div>

                            <InputError className="mt-1.5" message={errors.quantity} />
                            <InputError className="mt-1.5" message={errors.product_id} />
                        </div>

                    </div>
                    <div className="col-span-6 md:col-span-3">
                        <div className="flex flex-col justify-between items-end h-full">
                            <div className="mr-2 ">
                                <span className="text-lg font-semibold">
                                    {formatCurrency(cardProduct.total)}
                                </span>
                                {cardProduct.quantity > 1 && (
                                    <div className="text-gray-400 text-xs text-right"> 1 x {formatCurrency(cardProduct.price)} </div>
                                )}
                            </div>

                            <button onClick={handleClickRemoveItem} className="text-sm text-red-500 text-right font-medium">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    )
}

export default ProductsCart
