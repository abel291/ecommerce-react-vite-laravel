import TextInput from "@/Components/TextInput";
import { formatCurrency } from "../../Helpers/helpers";
import PrimaryButton from "@/Components/PrimaryButton";
import { Link, useForm, usePage } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import Badge from "@/Components/Badge";
import { XMarkIcon } from "@heroicons/react/24/solid";
import LabelInput from "@/Components/Form/LabelInput";
import InputDiscount from "./InputDiscount";

const OrderSummary = ({ orderProducts, order }) => {
	console.log(order)
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
				<div className=" mt-4 space-y-2">
					{orderProducts.map((item) => (
						<div className="flex items-start justify-between gap-x-5 " key={item.data.slug}>
							<div className="text-gray-600 ">{item.quantity_selected} x {item.data.name}</div>
							<div className="font-semibold whitespace-nowrap ">{formatCurrency(item.price_quantity)}</div>
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
						<div >{formatCurrency(order.sub_total)}</div>
					</div>
					{order.discount && (
						<div className="flex items-center justify-between gap-x-1">
							<Link preserveScroll href={route('checkout.remove-discount')} ><XMarkIcon className="w-4 h-4" /></Link>
							<div className="text-gray-500 grow  ">
								Descuento
								{order.discount.type == "percent" && (
									<span className=" text-gray-400 font-light ml-1">({order.discount.value}%)</span>
								)}
								<Badge className='tracking-wider ml-3' >{order.discount.code}</Badge>
							</div>
							<div className="text-green-500" >-{formatCurrency(order.discount.applied)}</div>
						</div>
					)}

					<div className="flex items-center justify-between ">
						<div className="text-gray-500">Envío</div>
						<div >{formatCurrency(order.shipping)}</div>
					</div>

					<div className="flex items-center justify-between ">
						<div className="text-gray-500">
							Estimación de impuestos <span className=" text-gray-400 font-light">({order.tax_percent}%)</span>
						</div>
						<div >{formatCurrency(order.tax_amount)}</div>
					</div>

				</div>
				<div className="flex items-center justify-between pt-6 text-base border-t">
					<div>Order total</div>
					<div>{formatCurrency(order.total)}</div>
				</div>
			</div>
		</div >
	)
}

export default OrderSummary
