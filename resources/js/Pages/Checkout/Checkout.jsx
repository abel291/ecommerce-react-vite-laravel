
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
                    <div className="lg:flex lg:gap-x-16 ">
                        <div className="w-full lg:w-8/12 xl:w-6/12 2xl:w-6/12">
                            <div className="max-w-2xl mx-auto">
                                <form className="divide-y">
                                    <div className="pb-8">

                                        <div>
                                            <ShippingAddress />
                                        </div>
                                    </div>
                                    {/* <div className="py-8">
                                        <h3 className="text-lg font-medium mb-4">Metodos de pago</h3>
                                        <div>
                                            <Elements stripe={stripePromise}>
                                                <PaymentForm />
                                            </Elements>
                                        </div>
                                    </div> */}

                                </form>
                            </div>
                        </div>
                        <div className="w-full lg:w-4/12 xl:w-6/12 2xl:w-6/12">
                            <h3 className="block  font-medium  text-lg mb-4">Resumen del pedido</h3>
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
