import TextInput from "@/Components/Form/TextInput";
import { formatCurrency } from "../../Helpers/helpers";
import PrimaryButton from "@/Components/PrimaryButton";
import { Link, useForm, usePage } from "@inertiajs/react";
import InputError from "@/Components/Form/InputError";
import Badge from "@/Components/Badge";
import { XMarkIcon } from "@heroicons/react/24/solid";
import InputLabel from "@/Components/Form/InputLabel";
import InputDiscount from "./InputDiscount";

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
        <div className="bg-gray-50 rounded-lg text-sm font-medium">
            <div className="p-4 md:p-6">
                <h3 className="block   text-lg">Resumen del pedido</h3>
                <div className="mt-4 divide-y">
                    {products.map((item) => (
                        <div className="flex items-start justify-between gap-x-5 py-2.5" key={item.slug}>
                            <div className="text-gray-600 ">{item.quantity} x {item.name}</div>
                            <div className="font-semibold whitespace-nowrap ">{formatCurrency(item.total)}</div>
                        </div>
                    ))}
                </div>
            </div>
            <div className="p-4 md:p-6 border-t">
                <div>
                    <InputDiscount />
                </div>
                <div className="my-6 space-y-4 sm:space-y-6 ">
                    <div className="flex items-center justify-between">
                        <div className="text-gray-500">Subtotal</div>
                        <div >{formatCurrency(total.subtotal)}</div>
                    </div>
                    {total.discount && (
                        <div className="flex items-center justify-between gap-x-1">
                            <Link preserveScroll href={route('checkout.remove-discount')} ><XMarkIcon className="w-4 h-4" /></Link>
                            <div className="text-gray-500 grow  ">
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
                        <div className="text-gray-500">Envío</div>
                        <div >{formatCurrency(total.shipping)}</div>
                    </div>

                    <div className="flex items-center justify-between ">
                        <div className="text-gray-500">
                            Estimación de impuestos <span className=" text-gray-400 font-light">({total.tax_rate}%)</span>
                        </div>
                        <div >{formatCurrency(total.tax_value)}</div>
                    </div>

                </div>
                <div className="flex items-center justify-between pt-6 text-base border-t font-semibold">
                    <div>Order total</div>
                    <div>{formatCurrency(total.total)}</div>
                </div>
            </div>
        </div >
    )
}

export default OrderSummary
