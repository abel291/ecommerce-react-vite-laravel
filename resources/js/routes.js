import Offers from "./pages/offers/Offers"
import Assemblies from "./pages/assemblies/Assemblies"
import Combos from "./pages/combos/Combos"
import ContactUs from "./pages/contact/ContactUs"
import FAQPage from "./pages/FAQPage"
import ShippingDelivery from "./pages/ShippingDelivery"
import ReturnExchanges from "./pages/ReturnExchanges"
import Home from "./pages/home/Home"
import Product from "./pages/product/Product"
import Search from "./pages/search/Search"
import ShoppingCarts from "./pages/shoppingCart/ShoppingCarts"
import Register from "./auth/Register"
import MyAccount from "./auth/MyAccount/MyAccount"
import Checkout from "./pages/checkout/Checkout"
import OrderComplete from "./pages/checkout/OrderComplete"
import Login from "./auth/Login"

const routesPublic = [
    { path: "/", Component: Home },
    { path: "/search", Component: Search },
    { path: "/product/:id/:slug", Component: Product },
    { path: "/offers", Component: Offers },
    { path: "/assemblies", Component: Assemblies },
    { path: "/combos", Component: Combos },
    { path: "/contact-us", Component: ContactUs },
    { path: "/faq", Component: FAQPage },
    { path: "/shipping-delivery", Component: ShippingDelivery },
    { path: "/return-exchanges", Component: ReturnExchanges },
    { path: "/login", Component: Login },
    {  path: "/register", Component: Register },
]

const routesPrivate = [
    { path: "/my-account/*", Component: MyAccount },
    { path: "/shopping-carts", Component: ShoppingCarts },
    { path: "/checkout", Component: Checkout },
    { path: "/order-complete", Component: OrderComplete },
    { path: "/orders", Component: OrderComplete },
]

export {
    routesPublic,
    routesPrivate
}