import TextInput from "@/Components/Form/TextInput";
import { formatCurrency } from "../../Helpers/helpers";
import PrimaryButton from "@/Components/PrimaryButton";
import { Link, useForm, usePage } from "@inertiajs/react";
import InputError from "@/Components/Form/InputError";
import Badge from "@/Components/Badge";
import { XMarkIcon } from "@heroicons/react/24/solid";
import InputLabel from "@/Components/Form/InputLabel";
import InputDiscount from "./InputDiscount";
import CardProductSummary from "./CardProductSummary";

const OrderSummary = ({ products, total }) => {

    const { discountForm } = useForm({
        discountCode: '',
    })

    const handleSubmitDiscount = (e) => {
        e.preventDefault()
        post(route('checkout.apply-discount'), {
            preserveScroll: true,
            onSuccess: () => reset('discountCode')
        })
    }

    return (
        <div>
            <div className="bg-gray-100 rounded-lg text-sm font-medium border divide-y shadow-sm ">
                {products.map((item) => (
                    <CardProductSummary product={item} />
                ))}
                <div className="p-5 md:p-6 ">
                    <InputDiscount />
                </div>
                <div className="p-5 md:p-6 space-y-4 sm:space-y-4 ">
                    <div className="flex items-center justify-between">
                        <div className="text-gray-600">Subtotal</div>
                        <div >{formatCurrency(total.sub_total)}</div>
                    </div>
                    {total.discount && (
                        <div className="flex items-center justify-between gap-x-1">
                            <Link preserveScroll href={route('checkout.remove-discount')} ><XMarkIcon className="w-4 h-4" /></Link>
                            <div className="grow text-gray-600">
                                Descuento
                                {total.discount.type == "percent" && (
                                    <span className=" text-gray-400 font-light ml-1">({total.discount.value}%)</span>
                                )}
                                <Badge className='tracking-wider ml-3' >{total.discount.code}</Badge>
                            </div>
                            <div className="text-green-500" >-{formatCurrency(total.discount.applied)}</div>
                        </div>
                    )}

                    <div className="flex items-center justify-between ">
                        <div className="text-gray-600">Envío</div>
                        <div >{formatCurrency(total.shipping)}</div>
                    </div>

                    <div className="flex items-center justify-between ">
                        <div className="text-gray-600">
                            Estimación de impuestos <span className=" text-gray-400 font-light">({total.tax_rate}%)</span>
                        </div>
                        <div >{formatCurrency(total.tax_value)}</div>
                    </div>

                </div>

                <div className="p-5 md:p-6 flex items-center justify-between pt-6 text-base border-t font-medium">
                    <div className="text-gray-600">Order total</div>
                    <div>{formatCurrency(total.total)}</div>
                </div>
            </div>

        </div>
    )
}

export default OrderSummary
