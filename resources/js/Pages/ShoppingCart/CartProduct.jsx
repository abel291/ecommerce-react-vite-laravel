

import InputError from "@/Components/Form/InputError";
import { formatCurrency } from "../../Helpers/helpers";
import { Link, useForm } from "@inertiajs/react";
import Spinner from "@/Components/Spinner";
const ProductsCart = ({ item }) => {
	const { delete: destroy, post, processing, errors } = useForm()

	const handleChangeQuantity = (e) => {
		let quantity = e.target.value
		let product_id = item.product.id

		post(route('shopping-cart.store', { product_id, quantity }), {
			preserveScroll: true,
		})
	}

	const handleClickRemoveItem = () => {
		destroy(route('shopping-cart.destroy', item.id), {
			preserveScroll: true,
		})
	}

	let inStock = (item.product.stock.remaining > item.quantity_selected)

	return (
		<div key={item.id} className="relative">
			<div className={" py-6 w-full relative "}>
				{processing && (
					<div className="absolute inset-0 opacity-70 bg-white z-10 flex justify-center items-center">
						<Spinner />
					</div>
				)}

				<div className="grid grid-cols-12 gap-6 md:gap-4 items-stretch">
					<div className="col-span-5 md:col-span-2">
						<Link href={route('product', { slug: item.product.slug })}>
							<div className=" flex items-center justify-center h-full">
								<img className=" md:max-h-28 lg:max-h-28 max-w-full" src={item.product.img} alt={item.product.name} />
							</div>
						</Link>
					</div>
					<div className="col-span-7 md:col-span-5">
						<div className="flex flex-col  h-full gap-y-3">
							<h3 className="text-lg font-semibold">{item.product.name}</h3>
							<div className="hidden lg:block">
								<table className="text-left text-xs">
									<tbody>
										{item.product.specifications.slice(0, 3).map((specification) => (
											<tr key={specification.id}>
												<td className=" font-semibold pr-3 pb-1">{specification.name}</td>
												<td>{specification.value}</td>
											</tr>
										))}
										<tr>
											<td>
												<Link className="text-blue-500 font-medium" href={route('product', { slug: item.product.slug })}>Ver mas</Link>
											</td>
											<td></td>
										</tr>
									</tbody>
								</table>
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
								value={item.quantity_selected}
							>
								{!inStock && (
									<option>Elegir otra cantidad</option>
								)}
								{[...Array(Math.min(item.product.max_quantity, item.product.stock.remaining)).keys()].map((i) => (
									<option key={i} value={i + 1}>
										{i + 1}
									</option>
								))}
							</select>

							<div className=" text-gray-400 text-xs mt-2 space-y-1">
								<span className="block">{item.product.stock.remaining} disponibles</span>
								{item.quantity_selected > 1 && (
									<div className=""> 1 x {formatCurrency(item.product.price_offer)} </div>
								)}
							</div>

							<InputError className="mt-1.5" message={errors.quantity_selected} />
							<InputError className="mt-1.5" message={errors.product_id} />
						</div>

					</div>
					<div className="col-span-6 md:col-span-3">
						<div className="flex flex-col justify-between items-end h-full">
							<div>
								{(item.product.active && inStock) && (
									<div className=" font-semibold text-lg">
										{formatCurrency(item.price_quantity)}
									</div>
								)}
								{!item.product.active && (
									<span className="font-medium text-gray-500 text-sm">
										Producto no disponile
									</span>
								)}

								{(item.product.stock.remaining == 0) && (
									<span className="font-medium text-gray-500 text-sm">
										Producto sin stock
									</span>
								)}

								{(item.product.stock.remaining > 0 && !inStock) && (
									<div>
										<span className="font-medium text-gray-500 text-sm">
											Producto fuera de stock
										</span>
										<Link className="text-blue-500 font-medium block text-xs" href={route('product', { slug: item.product.slug })}>
											Elija otra cantidad
										</Link>
									</div>
								)}
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
