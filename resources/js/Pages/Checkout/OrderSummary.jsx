import TextInput from "@/Components/TextInput";
import { formatCurrency } from "../../Helpers/helpers";
import PrimaryButton from "@/Components/PrimaryButton";
import { Link, useForm, usePage } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import Badge from "@/Components/Badge";
import { XMarkIcon } from "@heroicons/react/24/solid";
import LabelInput from "@/Components/Form/LabelInput";

const OrderSummary = ({ products, charges }) => {

	const { dicountCodes } = usePage().props

	const { data, setData, post, errors, processing, reset } = useForm({
		discountCode: '',
	})

	const handleSubmitDiscount = (e) => {
		e.preventDefault()
		post(route('checkout.discount'), {
			preserveScroll: true,
			onSuccess: () => reset('discountCode')
		})
	}

	return (
		<div className="bg-gray-50 rounded-lg text-sm font-medium">
			<div className="p-4 md:p-6">
				<h3 className="block   text-lg">Resumen del pedido</h3>


				<div className=" mt-4 space-y-2">
					{products.map((product) => (
						<div className="flex items-start justify-between gap-x-5 " key={product.slug}>
							<div className="text-gray-600 ">{product.quantity_selected} x {product.name}</div>
							<div className="font-semibold whitespace-nowrap ">{formatCurrency(product.price_quantity)}</div>
						</div>
					))}
				</div>
			</div>
			<div className="p-4 md:p-6 border-t">
				<div>
					<form onSubmit={handleSubmitDiscount} className=" ">
						<LabelInput>Código de descuento</LabelInput>
						<div className="flex items-end gap-x-3 mt-2">
							<TextInput
								name="discountCode"
								required
								onChange={(e) => setData('discountCode', e.target.value)}
								className=" uppercase"

								value={data.discountCode} />
							<PrimaryButton isLoading={processing} disabled={processing} >Canjear</PrimaryButton>
						</div>
					</form>
					<div className="flex gap-x-3 text-xs text-gray-400 mt-2">
						{dicountCodes.map((item) => (
							<span key={item.code}>{item.code}</span>
						))}
					</div>
					<InputError className="mt-1.5" message={errors.discountCode} />
				</div>
				<div className="my-6 space-y-4 sm:space-y-6 ">
					<div className="flex items-center justify-between">
						<div className="text-gray-500">Subtotal</div>
						<div >{formatCurrency(charges.sub_total)}</div>
					</div>
					{charges.discount && (
						<div className="flex items-center justify-between gap-x-1">
							<Link preserveScroll href={route('checkout.discount.delete')} ><XMarkIcon className="w-4 h-4" /></Link>
							<div className="text-gray-500 grow  ">
								Descuento
								{charges.discount.type == "percent" && (
									<span className=" text-gray-400 font-light ml-1">({charges.discount.value}%)</span>
								)}
								<Badge className='tracking-wider ml-3' >{charges.discount.code}</Badge>
							</div>
							<div className="text-green-500" >-{formatCurrency(charges.discount.applied)}</div>
						</div>
					)}

					<div className="flex items-center justify-between ">
						<div className="text-gray-500">Envío</div>
						<div >{formatCurrency(charges.shipping)}</div>
					</div>

					<div className="flex items-center justify-between ">
						<div className="text-gray-500">
							Estimación de impuestos <span className=" text-gray-400 font-light">({charges.tax_percent * 100}%)</span>
						</div>
						<div >{formatCurrency(charges.tax_amount)}</div>
					</div>

				</div>
				<div className="flex items-center justify-between pt-6 text-base border-t">
					<div>Order total</div>
					<div>{formatCurrency(charges.total)}</div>
				</div>
			</div>
		</div >
	)
}

export default OrderSummary
