import { useMutation, useQuery, useQueryClient } from "react-query"
import { useNavigate } from "react-router"
import useApiAuthClient from "./useApiAuthClient"

export const useCardProducts = () => {
    const apiAuthClient = useApiAuthClient()
    return useQuery(
        ["PRODUCTS_CART"],
        async () => {
            const response = await apiAuthClient.get("/card-products").then((res) => res.data)
            return response
        },
        {
            staleTime: Infinity,
        }
    )
}

export const useAddProductToCart = () => {
    const apiAuthClient = useApiAuthClient()
    const queryClient = useQueryClient()
    const navigate = useNavigate()

    return useMutation(
        async (params) => {
            const response = await apiAuthClient.post("/card-products", { ...params })
            return response
        },
        {
            onSuccess: function (response) {
                navigate("/shopping-carts")

                queryClient.setQueryData("PRODUCTS_CART", () => {
                    return response.data
                })
            },
        }
    )
}

export const useRemoveProductToCart = () => {
    const apiAuthClient = useApiAuthClient()
    const queryClient = useQueryClient()

    return useMutation(
        async (product_id) => {
            const response = await apiAuthClient.delete("/card-products/" + product_id)
            return response
        },
        {
            onSuccess: function (response) {
                queryClient.setQueryData("PRODUCTS_CART", () => {
                    return response.data
                })
            },
        }
    )
}
