import { useQuery } from "react-query"
import apiClient from "../auth/apiClient"

export const useData = () => {
    const fetchData = async () => {
        const response = await apiClient.get("/init").then((res) => res.data)
        return response
    }
    return useQuery(["DATA_INIT"], fetchData, {
        retry:0,
        staleTime: Infinity,
        notifyOnChangePropsExclusions: ["isStale"],
        placeholderData: {
            categories: [],
            brands: [],
        },
    })    
}
export const fakeApi = (fc) => {
    return new Promise(function (resolve) {
        setTimeout(async () => {
            resolve(fc())
        }, 1000)
    })
}

export const currencyFormat = Intl.NumberFormat("de-DE", {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
})

export const formatCurrency = (n) => {
    n = n ? n : 0 // number NaN = 0
    return "$ " + currencyFormat.format(parseFloat(n))
}


