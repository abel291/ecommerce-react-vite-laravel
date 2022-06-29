import { useQuery } from "react-query"
import apiClient from "../auth/apiClient"

const usePage = (page) => {
    const fetchPage = async () => {
        const response = await apiClient.get("/page/" + page).then((response) => {
            return response.data
        })
        return response
    }
    return useQuery(["page", page], fetchPage, {
        retry :0,
        staleTime: Infinity,
        notifyOnChangePropsExclusions: ["isStale"],
    })
}

export default usePage
