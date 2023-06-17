import { formatCurrency } from "@/Helpers/helpers"
import { Link } from "@inertiajs/react"
import Badge from "../Badge"


const CardProduct = ({ product, badge = "" }) => {
	return (
		<Link key={product.id} href={route('product', product.slug)}
			className="block max-w-md mx-auto h-full rounded-md p-4 transition duration-200 ease-in-out transform hover:-translate-y-1 md:hover:-translate-y-1.5 hover:shadow-lg " >
			<div className="h-full flex flex-col">

				<div className="h-48 px-6 flex items-center justify-center relative  ">
					<img src={product.img} alt={product.slug} className="  max-w-full max-h-full" />
				</div>

				<div className="grow flex flex-col mt-6">
					<h2 className="text-heading font-semibold text-base ">{product.name}</h2>

					<p className="mt-3  text-sm leading-normal xl:leading-relaxed line-clamp-2 text-gray-600">
						{product.description_min}
					</p>

					<div className="pt-4 grow flex items-end justify-between ">
						<div>
							{product.offer ? (
								<>
									<div className="text-xs text-gray-400 line-through">{formatCurrency(product.price)}</div>
									<div className="flex items-center">
										<div className="text-lg inline-block mr-2 font-semibold">{formatCurrency(product.price_offer)}</div>
										<div className="inline-block text-green-500 text-xs font-semibold">{product.offer}%</div>
									</div>
								</>
							) : (
								<div className="mr-2 text-lg font-semibold">{formatCurrency(product.price_offer)}</div>
							)}
						</div>

					</div>
				</div>
			</div>

		</Link >
	)
}

export default CardProduct
