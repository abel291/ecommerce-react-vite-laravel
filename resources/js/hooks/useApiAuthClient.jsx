import { useQueryClient } from "react-query"
import apiClient from "../auth/apiClient"
const useApiAuthClient = () => {
    const queryClient = useQueryClient()
    //antes de hacer la peticion
    apiClient.interceptors.request.use(
        function (config) {
            const token = localStorage.getItem("token")

            if (token) {
                config.headers.common["Authorization"] = token
            }
            // Do something before request is sent
            return config
        },
        function (error) {
            // Do something with request error
            return Promise.reject(error)
        }
    )

    //respuestas
    apiClient.interceptors.response.use(
        function (res) {
            // Any status code that lie within the range of 2xx cause this function to trigger
            // Do something with response data

            if (res.data.token) {
                localStorage.setItem("token", "Bearer " + res.data.token)
            }
            return res
        },
        function (error) {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            // Do something with response error
            if (error.response.status === 401) {
                localStorage.removeItem("token")
                queryClient.setQueryData("USER", null)
            }

            return Promise.reject(error)
        }
    )
    return apiClient
}

export default useApiAuthClient
