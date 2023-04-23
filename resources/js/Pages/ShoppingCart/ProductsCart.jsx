

import InputError from "@/Components/InputError";
import { formatCurrency } from "../../Helpers/helpers";
import { Link, useForm } from "@inertiajs/react";
const ProductsCart = ({ product }) => {


	const handleChangeQuantity = (e) => {
		let quantity = e.target.value
		let product_id = product.id

		post(route('shopping-cart.store', { product_id, quantity }), {
			preserveScroll: true,
		})
	}

	const { delete: destroy, post, processing, errors } = useForm()

	const handleClickRemoveItem = () => {
		destroy(route('shopping-cart.destroy', product.id), {
			preserveScroll: true,
		})
	}

	return (
		<div key={product.id} className={" py-6 w-full " + (processing && "opacity-25")}>
			<div className="grid grid-cols-12 gap-6 md:gap-4 items-stretch">
				<div className="col-span-5 md:col-span-2 ">
					<Link href={route('product', { slug: product.slug })}>
						<div className=" flex items-center justify-center h-full">
							<img className=" md:max-h-28 lg:max-h-40 max-w-full" src={product.img} alt={product.name} />
						</div>
					</Link>
				</div>
				<div className="col-span-7 md:col-span-5">
					<div className="flex flex-col justify-between h-full space-y-4">
						<span className="text-lg font-semibold">{product.name}</span>

						<div className="hidden lg:block">
							<table className="text-left text-xs">
								<tbody>
									{product.specifications.slice(0, 4).map((specification) => (
										<tr key={specification.id}>
											<td className=" font-semibold pr-3 pb-1">{specification.name}</td>
											<td>{specification.value}</td>
										</tr>
									))}
									<tr>
										<td >
											<Link className="text-blue-500 font-medium" href={route('product', { slug: product.slug })}>Ver mas</Link>
										</td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>

						<span className="font-light text-gray-500 text-xs">{product.stock} disponibles</span>
					</div>
				</div>
				<div className=" col-span-6 md:col-span-2">
					<div className="space-y-1">
						<select
							className="rounded-md py-1 border-gray-200 focus:ring-none"
							name="quantity"
							disabled={processing}
							onChange={handleChangeQuantity}
							value={product.shopping_cart.quantity}
						>
							{[...Array(product.stock).keys()].map((i) => (
								<option key={i} value={i + 1}>
									{i + 1}
								</option>
							))}
						</select>
						{product.shopping_cart.quantity > 1 && (
							<div className=" text-gray-400 text-xs ml-1.5 mt-2.5"> 1 x {formatCurrency(product.price_offer)} </div>
						)}
						<InputError className="mt-1.5" message={errors.quantity} />
					</div>
				</div>
				<div className="col-span-6 md:col-span-3">
					<div className="flex flex-col justify-between items-end h-full">
						<span className=" font-bold text-lg">{formatCurrency(product.shopping_cart.total_price_quantity)}</span>
						<button onClick={handleClickRemoveItem} className="text-sm text-red-500 text-right font-medium">
							Eliminar
						</button>
					</div>
				</div>
			</div>
		</div >
	)
}

export default ProductsCart
