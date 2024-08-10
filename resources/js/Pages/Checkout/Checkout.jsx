
import Layout from "@/Layouts/Layout"
import { Head, useForm, } from "@inertiajs/react"
import ShippingAddress from "./ShippingAddress"
import OrderSummary from "./OrderSummary"
import CheckoutProvider from "@/Components/Context/CheckoutProvider"
import PaymentForm from "./PaymentForm";
import { Elements } from "@stripe/react-stripe-js";
import { loadStripe } from '@stripe/stripe-js';
const stripePromise = loadStripe('pk_test_ejdWQWajqC4QwST95KoZiDZK');

const Checkout = ({ products, total }) => {

    return (
        <Layout>
            <Head title='Checkout' />
            <CheckoutProvider>
                <div className="py-content container">
                    <div className="lg:flex lg:gap-x-8 ">
                        <div className="w-full lg:w-7/12 xl:w-7/12">
                            <div className="max-w-2xl mx-auto">
                                <form className="divide-y">
                                    <div className="pb-8">
                                        <h2 className="title-section mb-8">Dirección de Envío</h2>
                                        <div>
                                            <ShippingAddress />
                                        </div>
                                    </div>
                                    <div className="py-8">
                                        <h2 className="title-section mb-8">Metodos de pago</h2>
                                        <div>
                                            <Elements stripe={stripePromise}>
                                                <PaymentForm />
                                            </Elements>

                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div className="w-full lg:w-5/12 xl:w-5/12">
                            <h2 className="title-section mb-4">Su pedido </h2>
                            <div>
                                <OrderSummary products={products} total={total} />
                            </div>
                        </div>
                    </div>


                </div>
            </CheckoutProvider>
        </Layout>
    )
}

export default Checkout
