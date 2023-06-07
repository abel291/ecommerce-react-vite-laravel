import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import CartProduct from "./CartProduct"
import OrderSummary from "./OrderSummary"
import PrimaryButton from "@/Components/PrimaryButton"
import { Head, Link, useForm } from "@inertiajs/react"
import { formatCurrency } from "@/Helpers/helpers"

const ShoppingCart = ({ shoppingCart, order }) => {

	const { get, processing } = useForm();
	const handleClickCheckout = () => {
		get(route('checkout.add-shopping-cart'))
	}
	return (
		<Layout>
			<Head title="Carrito de compras" />
			<div className="container relative">
				<div className="space-y-4">
					<SectionList title="Carrito de compra">
						{/* <TitleContent text={"Carrito de compra (" + cartProducts.products.length + ")"} /> */}
						<div className=" divide-y divide-gray-200">
							{shoppingCart.map((item, index) => (
								<CartProduct item={item} key={item.id} />
							))}
						</div>

						{shoppingCart.length ? (
							<>
								<div>
									<OrderSummary order={order} />
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
