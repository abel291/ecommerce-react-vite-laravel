import { useState } from "react"
import { Navigate, useNavigate } from "react-router"

import { fakeApi } from "../../hooks/useData"
import { useProductsCheckout } from "../../hooks/useProductsCheckout"
import OrderSummary from "./OrderSummary"
import ShippingAddress from "./ShippingAddress"

const Checkout = () => {
    const productsCheckout = useProductsCheckout()
    const navigate = useNavigate()
    const [isLoading, setIsLoading] = useState(false)

    if (!productsCheckout.data) return <Navigate to="/" />

    if (productsCheckout.error) return "An error has occurred: " + productsCheckout.error.message

    const handleSubmit = (e) => {
        e.preventDefault()
        setIsLoading(true)
        fakeApi(() => {
            setIsLoading(false)
            navigate("/order-complete")
        })
    }
    return (
        <div className="py-content container">
            <div className="flex flex-wrap ">
                <div className="w-full lg:w-4/6 lg:pr-8 py-content">
                    <h2 className="font-bold text-xl mb-4">Dirección de Envío</h2>
                    <div>
                        <ShippingAddress handleSubmit={handleSubmit} isLoading={isLoading} />
                    </div>
                </div>
                <div className="w-full lg:w-2/6 py-content">
                    <h2 className="font-bold text-xl mb-4">Su Pedido </h2>
                    <div>
                        <OrderSummary products={productsCheckout.data.products} charges={productsCheckout.data.charges} />
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Checkout
