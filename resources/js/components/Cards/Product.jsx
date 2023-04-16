import { formatCurrency } from "@/Helpers/helpers"
import { Link } from "@inertiajs/react"


const CardProduct = ({ product, badge = "" }) => {
	return (
		<Link key={product.id} href={route('product', product.slug)} >
			<div>
				<div className="h-48 p-2 flex items-center justify-center relative">
					<img src={"/img/categories/" + product.img} alt={product.slug} className="max-h-full" />
				</div>
				<div className="my-2">
					{/* <div className="bg-red-500 text-white rounded py-1 px-2 text-xs inline-block font-medium">Nuevo</div> */}
					<h2 className="text-heading font-medium mb-1 text-sm md:text-base ">{product.name}</h2>
					<p className="text-body text-xs lg:text-sm leading-normal xl:leading-relaxed line-clamp-2">{product.description_min}</p>
					<div className="mt-2">
						{product.offer ? (
							<div>
								<div className="text-xs text-gray-400 line-through">{formatCurrency(product.price)}</div>
								<div className="flex items-center">
									<div className="text-lg inline-block mr-2 font-bold">{formatCurrency(product.price_offer)}</div>
									<div className="inline-block text-green-500 text-xs font-semibold">{product.offer}%</div>
								</div>
							</div>
						) : (
							<div className="mr-2 text-lg font-bold">{formatCurrency(product.price_offer)}</div>
						)}
					</div>
				</div>
			</div>
		</Link>
	)
}

export default CardProduct
