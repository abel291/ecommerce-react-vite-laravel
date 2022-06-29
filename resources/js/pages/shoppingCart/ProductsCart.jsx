import { XIcon } from "@heroicons/react/outline"
import { Link } from "react-router-dom"
import { useAddProductToCart, useRemoveProductToCart } from "../../hooks/useCardProducts"
import { formatCurrency } from "../../Helpers/helpers";
const ProductsCart = ({ product }) => {
    const addProductToCart = useAddProductToCart()
    const removeProductToCart = useRemoveProductToCart()

    const handleChangeQuantity = (e) => {
        let quantity = e.target.value
        let product_id = product.id
        addProductToCart.mutate({ product_id, quantity })
    }

    const handleClickRemoveItem = () => {
        removeProductToCart.mutate(product.id)
    }

    return (
        <div key={product.id} className={" py-6 w-full " + ((removeProductToCart.isLoading || addProductToCart.isLoading) && "opacity-25")}>
            <div className="grid grid-cols-12 gap-6 md:gap-4 items-stretch">
                <div className="col-span-5 md:col-span-2 ">
                    <Link to={"/product/" + product.id + "/" + product.slug}>
                        <div className=" flex items-center justify-center h-full">
                            <img className=" md:max-h-28 lg:max-h-40 max-w-full" src={"/img/categories/" + product.img} alt="asd" />
                        </div>
                    </Link>
                </div>
                <div className="col-span-7 md:col-span-5">
                    <div className="flex flex-col justify-between h-full space-y-4">
                        <span className="text-lg font-semibold">{product.name}</span>

                        <div className="hidden lg:block">
                            <table className="text-left text-xs">
                                <tbody>
                                    {product.specifications.map((specification) => (
                                        <tr key={specification.id}>
                                            <td className=" font-semibold pr-3 pb-1">{specification.name}</td>
                                            <td>{specification.pivot.value}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        <span className="font-light text-gray-500 text-xs">{product.availables} disponibles</span>
                    </div>
                </div>
                <div className=" col-span-6 md:col-span-2">
                    <div className="space-y-1">
                        <select
                            className="rounded-md py-1 border-gray-200 focus:ring-none"
                            name="quantity"
                            disabled={removeProductToCart.isLoading || addProductToCart.isLoading}
                            onChange={handleChangeQuantity}
                            value={product.pivot.quantity}
                        >
                            {[...Array(product.availables).keys()].map((i) => (
                                <option key={i} value={i + 1}>
                                    {i + 1}
                                </option>
                            ))}
                        </select>
                        {product.pivot.quantity > 1 && (
                            <div className=" text-gray-400 text-xs ml-1 mt-2"> 1 x {formatCurrency(product.price)} </div>
                        )}
                    </div>
                </div>
                <div className="col-span-6 md:col-span-3">
                    <div className="flex flex-col justify-between items-end h-full">
                        <span className=" font-bold text-lg">{formatCurrency(product.pivot.total_price_quantity)}</span>
                        <button onClick={handleClickRemoveItem} className="text-sm text-red-500 text-right font-medium">
                            Remover
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default ProductsCart
