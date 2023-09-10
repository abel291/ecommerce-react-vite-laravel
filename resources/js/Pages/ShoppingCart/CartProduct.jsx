

import InputError from "@/Components/Form/InputError";
import { formatCurrency } from "../../Helpers/helpers";
import { Link, router, useForm } from "@inertiajs/react";
import Spinner from "@/Components/Spinner";
import CartAttributes from "./CartAttributes";
import { useEffect, useRef } from "react";
const ProductsCart = ({ cardProduct }) => {
    const { data, setData, delete: destroy, put, processing, errors } = useForm({
        quantity: cardProduct.quantity,
        product_id: cardProduct.id,
    })

    const handleChangeQuantity = (e) => {
        let quantity = e.target.value
        setData('quantity', quantity);
    }

    const handleClickRemoveItem = () => {
        destroy(route('shopping-cart.destroy', cardProduct.rowId), {
            preserveScroll: true,
        })
    }

    const first = useRef(true);
    useEffect(() => {
        if (first.current) {
            first.current = false;
            return;
        }

        put(route('shopping-cart.update', cardProduct.rowId), {
            preserveScroll: true,
        })

    }, [data])
    return (
        <div className="relative">
            <div className={" py-6 w-full relative "}>
                {processing && (
                    <div className="absolute inset-0 opacity-70 bg-white z-10 flex justify-center items-center">
                        <Spinner />
                    </div>
                )}

                <div className="grid grid-cols-12 gap-6 md:gap-4 items-stretch">
                    <div className="col-span-5 md:col-span-2">
                        <Link href={route('product', { slug: cardProduct.slug })}>
                            <div className=" flex items-center justify-center h-full">
                                <img className=" md:max-h-28 lg:max-h-28 max-w-full" src={cardProduct.img} alt={cardProduct.name} />
                            </div>
                        </Link>
                    </div>
                    <div className="col-span-7 md:col-span-5">
                        <div className="flex flex-col  h-full gap-y-2">
                            <div className="flex justify-between text-base font-medium text-gray-900">
                                <h3>{cardProduct.name}</h3>
                            </div>
                            <div>
                                {cardProduct.attributes.map((attribute, index) => (
                                    <div className="flex gap-x-1.4 text-sm" key={index}>
                                        <div className=" font-medium pr-3 ">{attribute.name}</div>
                                        <div className=" text-gray-500">{attribute.value}</div>
                                    </div>
                                ))}
                            </div>


                        </div>
                    </div>
                    <div className=" col-span-6 md:col-span-2">
                        <div>
                            <select
                                className="rounded-md py-1 border-gray-200 focus:ring-none"
                                name="quantity"
                                disabled={processing}
                                onChange={handleChangeQuantity}
                                value={data.quantity}
                            >
                                {[...Array(cardProduct.maxQuantity).keys()].map((i) => (
                                    <option key={i} value={i + 1}>
                                        {i + 1}
                                    </option>
                                ))}
                            </select>

                            <div className=" text-gray-400 text-xs mt-2 space-y-1">
                                {/* <span className="block">{cardProduct.stock.remaining} disponibles</span> */}
                                {cardProduct.quantity > 1 && (
                                    <div className=""> 1 x {formatCurrency(cardProduct.priceOffer)} </div>
                                )}
                            </div>

                            <InputError className="mt-1.5" message={errors.quantity} />
                            <InputError className="mt-1.5" message={errors.product_id} />
                        </div>

                    </div>
                    <div className="col-span-6 md:col-span-3">
                        <div className="flex flex-col justify-between items-end h-full">
                            <div>
                                <div className=" font-semibold text-lg">
                                    {formatCurrency(cardProduct.total)}
                                </div>
                            </div>
                            <button onClick={handleClickRemoveItem} className="text-sm text-red-500 text-right font-medium">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div >

        </div >

    )
}

export default ProductsCart
