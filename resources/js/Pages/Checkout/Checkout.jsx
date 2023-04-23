import { useState } from "react"



//wimport OrderSummary from "./OrderSummary"

import Layout from "@/Layouts/Layout"
import { Head } from "@inertiajs/react"
import ShippingAddress from "./ShippingAddress"
import OrderSummary from "./OrderSummary"

const Checkout = ({ products, charges }) => {

	return (
		<Layout>
			<Head title='Checkout' />
			<div className="py-content container">
				<div className="flex flex-wrap ">
					<div className="w-full lg:w-4/6 lg:pr-8 py-content">
						<h2 className="font-bold text-xl mb-4">Dirección de Envío</h2>
						<div>
							<ShippingAddress />
						</div>
					</div>
					<div className="w-full lg:w-2/6 py-content">
						<h2 className="font-bold text-xl mb-4">Su pedido </h2>
						<div>
							<OrderSummary products={products} charges={charges} />
						</div>
					</div>
				</div>
			</div>
		</Layout>
	)
}

export default Checkout
