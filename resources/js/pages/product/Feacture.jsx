import { MinusIcon, PlusIcon, ShoppingCartIcon } from "@heroicons/react/solid"
import { useState } from "react"
import { useLocation, useNavigate } from "react-router-dom"

import Button from "../../components/Button"
import Notifications from "../../components/Notifications"

import useAuth from "../../hooks/useAuth"
import { useAddProductToCart } from "../../hooks/useCardProducts"
import { formatCurrency } from "../../Helpers/helpers";
import { useMutationProductsCheckout } from "../../hooks/useProductsCheckout"

const Feacture = ({ product }) => {
    const [quantity, setQuantity] = useState(1)
    const navigate = useNavigate()
    const location = useLocation()

    const addProductToCart = useAddProductToCart()
    const productCheckout = useMutationProductsCheckout()
    const { isLogged } = useAuth()

    const handleClickAddProductToCart = async () => {
        if (isLogged) {
            addProductToCart.mutate({ product_id: product.id, quantity })
        } else {
            navigate("/login", { state: { from: location.from } })
        }
    }

    const handleClickProductCheckout = async () => {
        if (isLogged) {
            productCheckout.mutate({ product_id: product.id, quantity })
        } else {
            console.log(location)
            navigate("/login", { state: { from: location } })
        }
    }
    const handleClickQuantity = (i) => {
        switch (i) {
            case "up":
                if (quantity === product.availables) {
                    return
                }
                setQuantity(quantity + 1)
                break
            case "down":
                if (quantity === 1) {
                    return
                }
                setQuantity(quantity - 1)

                break
            default:
                break
        }
    }
    return (
        <div className="space-y-5">
            <div className="flex items-center">
                <span className="text-sm font-light">Nuevo | {product.availables} disponibles</span>
            </div>
            <h2 className="font-bold text-2xl md:text-lg">{product.name}</h2>
            <p>{product.description_min}</p>
            <div>
                {product.offer && <span className="text-xs text-gray-400 line-through">{formatCurrency(product.price_default)}</span>}
                <div className="flex items-center">
                    <div className="font-bold text-2xl inline-block mr-2">{formatCurrency(product.price)}</div>
                    {product.offer && <div className="inline-block text-green-500  font-semibold">{product.offer}%</div>}
                </div>
            </div>

            <div className="flex space-x-3 items-stretch h-11">
                <div className="flex items-center border border-gray-200 rounded-md divide-gray-200 divide-x  ">
                    <button onClick={() => handleClickQuantity("down")} className=" flex items-center px-4 h-full">
                        <MinusIcon className="h-4 w-4" />
                    </button>
                    <span id="countQuantity" className=" flex items-center px-4 h-full w-20 justify-center">
                        {quantity}
                    </span>
                    <button onClick={() => handleClickQuantity("up")} className=" flex items-center px-4 h-full">
                        <PlusIcon className="h-4 w-4" />
                    </button>
                </div>
                <div className="flex items-center">
                    <span className=" text-sm font-light text-gray-400">( {product.availables} disponibles )</span>
                </div>
            </div>
            <div className="flex flex-col lg:flex-row items-center lg:space-x-2 space-y-2 lg:space-y-0">
                <Button
                    isLoading={addProductToCart.isLoading}
                    styleClass="bg-orange-100 text-orange-500 "
                    textLoading="Añadiendo...."
                    onClick={handleClickAddProductToCart}
                >
                    <div className="inline-flex  ">
                        <ShoppingCartIcon className="w-5 h-5 mr-3" />
                        <span className="  text-sm font-semibold">Agregar al Carrito </span>
                    </div>
                </Button>

                <Button
                    isLoading={productCheckout.isLoading}
                    styleClass="bg-orange-500 text-white "
                    textLoading="Cargandoo...."
                    onClick={handleClickProductCheckout}
                >
                    <div className="inline-flex ">
                        <span className=" text-sm font-semibold">Comprar ahora </span>
                    </div>
                </Button>
            </div>
            {(productCheckout.error || addProductToCart.error) && (
                <Notifications type="error" error={productCheckout.error || addProductToCart.error} />
            )}
        </div>
    )
}

export default Feacture
