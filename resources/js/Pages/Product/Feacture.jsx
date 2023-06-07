
import InputError from "@/Components/InputError"
import PrimaryButton from "@/Components/PrimaryButton"
import SecondaryButton from "@/Components/SecondaryButton"
import { formatCurrency } from "@/Helpers/helpers"
import { MinusIcon, PlusIcon, ShoppingCartIcon } from "@heroicons/react/24/solid"
import { useForm, usePage } from "@inertiajs/react"
import { useState } from "react"

const Feacture = ({ product }) => {
	const [processing, setProcessing] = useState('')

	const { data, setData, post, get, errors } = useForm({
		quantity: 1,
		product_id: product.id
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
		<div className="space-y-5">
			<div className="flex items-center">
				<span className="text-sm font-light">Nuevo | {product.stock.remaining} disponibles</span>
			</div>
			<h2 className="font-bold text-2xl md:text-lg">{product.name}</h2>
			<p>{product.description_min}</p>
			<div>
				{product.offer != 0 &&
					<span className="text-xs text-gray-400 line-through">
						{formatCurrency(product.price)}
					</span>
				}
				<div className="flex items-center">
					<div className="font-bold text-2xl inline-block mr-2">{formatCurrency(product.price_offer)}</div>
					{product.offer != 0 && <div className="inline-block text-green-500  font-semibold">{product.offer}%</div>}
				</div>
			</div>

			<div className="flex space-x-3 items-stretch h-11">
				<div className="flex items-center border border-gray-200 rounded-md divide-gray-200 divide-x  ">
					<button onClick={() => handleClickQuantity("down")} className=" flex items-center px-4 h-full">
						<MinusIcon className="h-4 w-4" />
					</button>
					<span id="countQuantity" className=" flex items-center px-4 h-full w-20 justify-center">
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
			<div className="flex flex-col lg:flex-row items-center lg:space-x-2 space-y-2 lg:space-y-0">
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
			<InputError className="mt-1.5" message={errors.quantity} />
			<InputError className="mt-1.5" message={errors.product_id} />


		</div >
	)
}

export default Feacture
