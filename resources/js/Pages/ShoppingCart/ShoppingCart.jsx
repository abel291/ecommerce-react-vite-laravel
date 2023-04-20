import SectionList from "@/Components/Sections/SectionList"
import Layout from "@/Layouts/Layout"
import ProductsCart from "./ProductsCart"
import OrderSummary from "./OrderSummary"
import PrimaryButton from "@/Components/PrimaryButton"
import { Head, Link } from "@inertiajs/react"

const ShoppingCart = ({ products, charges }) => {

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
									<Link href={route('shopping_cart_checkout')} className="btn-primary">Comprar ahora</Link>
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
