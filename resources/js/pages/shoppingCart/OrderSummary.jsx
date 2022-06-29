import {useCardProducts} from "../../hooks/useCardProducts"
import { formatCurrency } from "../../Helpers/helpers";


const OrderSummary = () => {
    
    const cartProducts = useCardProducts()

    const {  data } = cartProducts
    return (
        <div className="py-8 px-8 space-y-5 text-right border-y border-t border-b border-gray-200">
            <div className=" inline-grid grid-cols-2 gap-6">
                <div className="text-gray-600 ">Sub total</div>
                <div className=" font-medium">{formatCurrency(data.charges.sub_total)}</div>

                <div className="text-gray-600 ">Envío</div>
                <div className=" font-medium">{formatCurrency(data.charges.shipping)}</div>

                <div className=" text-gray-600 ">
                    Impuestos
                    <span className="  text-gray-400 font-light"> ({data.charges.tax_percent * 100}%)</span>
                </div>
                <div className=" font-medium">{formatCurrency(data.charges.tax_amount)}</div>

                <div className="text-xl font-bold">Orden total</div>
                <div className="text-xl font-bold">{formatCurrency(data.charges.total)}</div>
            </div>
        </div>
        
    )
}

export default OrderSummary
