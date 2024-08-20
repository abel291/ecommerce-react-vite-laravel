import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import CartProduct from "./CartProduct"
import OrderSummary from "./OrderSummary"
import PrimaryButton from "@/Components/PrimaryButton"
import { Head, Link, useForm } from "@inertiajs/react"
import { formatCurrency } from "@/Helpers/helpers"

const ShoppingCart = ({ cardProducts, total }) => {

    const { get, processing } = useForm();
    const handleClickCheckout = () => {
        get(route('checkout.add-shopping-cart'))
    }
    return (
        <Layout>
            <Head title="Carrito de compras" />
            <div className="container relative">
                <div className="space-y-4 max-w-5xl mx-auto">
                    <SectionList title="Carrito de compra">
                        {/* <TitleContent text={"Carrito de compra (" + cartProducts.cardProducts.length + ")"} /> */}
                        <div className=" divide-y divide-gray-200">
                            {cardProducts.map((product) => (
                                <CartProduct cardProduct={product} key={product.presentation.id} />
                            ))}
                        </div>

                        {cardProducts.length ? (
                            <>
                                <div>
                                    <OrderSummary total={total} />
                                </div>
                                <div className="text-right mt-6 ">
                                    <PrimaryButton onClick={handleClickCheckout} isLoading={processing} disabled={processing}>Comprar ahora</PrimaryButton>
                                </div>
                            </>
                        ) : (
                            <span>No hay productos en el carrito de compra</span>
                        )}
                    </SectionList>
                </div>
            </div>
        </Layout>
    )
}

export default ShoppingCart
