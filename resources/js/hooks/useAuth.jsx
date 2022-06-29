import { useMutation, useQuery, useQueryClient } from "react-query"

import useApiAuthClient from "./useApiAuthClient"

const useAuth = (dispatch) => {
    const apiAuthClient = useApiAuthClient()
    const queryClient = useQueryClient()

    const userData = useQuery(
        ["USER"],
        async () => { 
            if (!localStorage.getItem("token")) {
                return null
            }
            const response = await apiAuthClient
                .get("/auth/profile")
                .then((res) => res.data)
                .catch((res) => null)
            return response
        },
        { staleTime: Infinity }
    )

    const login = useMutation(
        async (dataLogin) => {
            const response = await apiAuthClient.post("/auth/login", { ...dataLogin })

            return response
        },
        {
            onSuccess: function (res) {
                queryClient.setQueryData("USER", () => {
                    return res.data.user
                })
            },
        }
    )

    const register = useMutation(
        async (registerData) => {
            const response = await apiAuthClient.post("/auth/register", {
                ...registerData,
            })

            return response
        },
        {
            onSuccess: function (res) {
                queryClient.setQueryData("USER", () => {
                    return res.data.user
                })
            },
        }
    )

    const logout = useMutation(
        async () => {
            const response = await apiAuthClient.post("/auth/logout")
            return response
        },
        {
            onSuccess: function (response) {
                queryClient.setQueryData("USER", null)
                localStorage.removeItem("token")
            },
        }
    )

    const updateUser = useMutation(
        async (dataUser) => {
            const response = await apiAuthClient.put("/auth/user/profile-store", { ...dataUser })
            return response
        },
        {
            onSuccess: function (data, variables, context) {
                queryClient.setQueryData("USER", { ...userData.data, ...variables })
            },
        }
    )

    const updatePassword = useMutation(async (dataPassword) => {
        const response = await apiAuthClient.put("/auth/user/password-store", { ...dataPassword })
        return response
    })

    return {
        user: userData.data,
        isLogged: userData.data ? true : false,
        userData,
        login,
        register,
        logout,
        updateUser,
        updatePassword,
    }
}

export default useAuth
