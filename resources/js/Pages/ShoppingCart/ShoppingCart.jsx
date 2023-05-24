import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import ProductsCart from "./ProductCart/ProductsCart"
import OrderSummary from "./OrderSummary"
import PrimaryButton from "@/Components/PrimaryButton"
import { Head, Link, useForm } from "@inertiajs/react"
import { formatCurrency } from "@/Helpers/helpers"

const ShoppingCart = ({ products, charges }) => {

	const { get, processing } = useForm();
	const handleClickCheckout = () => {
		get(route('checkout.shopping_cart'))
	}
	return (
		<Layout>
			<Head title="Carrito de compras" />
			<div className="container py-content relative">
				<div className="space-y-4">
					<SectionList title="Carrito de compra">
						{/* <TitleContent text={"Carrito de compra (" + cartProducts.products.length + ")"} /> */}
						<div className=" divide-y divide-gray-200">
							{products.map((product, index) => (
								<ProductsCart product={product} key={product.id} />
							))}
						</div>

						{products.length ? (
							<>
								<div>
									<OrderSummary charges={charges} />
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
