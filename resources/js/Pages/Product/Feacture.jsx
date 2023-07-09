
import InputError from "@/Components/Form/InputError"
import PrimaryButton from "@/Components/PrimaryButton"
import SecondaryButton from "@/Components/SecondaryButton"
import { formatCurrency } from "@/Helpers/helpers"
import { FaceFrownIcon } from "@heroicons/react/24/outline"
import { MinusIcon, PlusIcon, ShoppingCartIcon } from "@heroicons/react/24/solid"
import { useForm, usePage } from "@inertiajs/react"
import { useState } from "react"
import Attributes from "./Attributes/Attributes"

const Feacture = ({ product, attributesDefault }) => {
	const [processing, setProcessing] = useState('')

	const { data, setData, post, get, errors } = useForm({
		quantity: 1,
		product_id: product.id,
		attributes: attributesDefault,
	})

	const handleClickAddProductToCart = () => {
		post(route('shopping-cart.store'), {
			preserveScroll: true,
			onStart: visit => { setProcessing('shoppingCart') },
			onFinish: visit => { setProcessing('') },
		})
	}

	const handleClickBuyProduct = () => {
		post(route('checkout.add-single-product'), {
			preserveScroll: true,
			onStart: visit => { setProcessing('checkout') },
			onFinish: visit => { setProcessing('') },
		})
	}
	const handleClickQuantity = (i) => {
		switch (i) {
			case "up":
				if (data.quantity === product.stock) {
					return
				}
				setData('quantity', data.quantity + 1)
				break
			case "down":
				if (data.quantity === 1) {
					return
				}
				setData('quantity', data.quantity - 1)

				break
			default:
				break
		}
	}
	return (
		<div >

			{product.attributes.length > 0 && (
				<div className="mt-8">
					<Attributes product={product} data={data} setData={setData} />
				</div>
			)}

			<div className="mt-8">
				{product.stock.remaining <= 0 ? (
					<div className="text-gray-500  text-base flex items-center gap-x-2">
						<FaceFrownIcon className="h-6  " />
						<span>Producto Agotado</span>
					</div>
				) : (
					<>
						<div className="flex space-x-3 items-stretch">
							<div className="flex items-center border border-gray-200 rounded-md divide-gray-200 divide-x bg-white  h-10">
								<button onClick={() => handleClickQuantity("down")} className=" flex items-center px-4 h-full">
									<MinusIcon className="h-4 w-4" />
								</button>
								<span id="countQuantity" className=" flex items-center  h-full w-14 justify-center">
									{data.quantity}
								</span>
								<button onClick={() => handleClickQuantity("up")} className=" flex items-center px-4 h-full">
									<PlusIcon className="h-4 w-4" />
								</button>
							</div>
							<div className="flex items-center">
								<span className=" text-sm font-light text-gray-400">( {product.stock.remaining} disponibles )</span>
							</div>
						</div>
						<div className="flex flex-row items-center space-x-2 mt-8">
							<SecondaryButton isLoading={processing == "shoppingCart"} onClick={handleClickAddProductToCart}>
								<div className="inline-flex items-center  ">
									<ShoppingCartIcon className="w-3 h-3 mr-3" />
									<span className="text-sm font-semibold">Agregar al Carrito </span>
								</div>
							</SecondaryButton>

							<PrimaryButton isLoading={processing == "checkout"} onClick={handleClickBuyProduct}>
								<div className="inline-flex ">
									<span className=" text-sm font-semibold">Comprar ahora </span>
								</div>
							</PrimaryButton>
						</div>
						<InputError className="mt-3" message={errors.quantity} />
						<InputError className="mt-3" message={errors.product_id} />
					</>
				)}
			</div>


		</div >
	)
}

export default Feacture
