import axios from "axios"
import { useMutation, useQuery, useQueryClient } from "react-query"
import { useNavigate } from "react-router-dom"
import apiClient from "../auth/apiClient"

import useApiAuthClient from "./useApiAuthClient"

const useAuth = (dispatch) => {
	
	const queryClient = useQueryClient()
	const navigate = useNavigate()
	const csrf = () => axios.get('/sanctum/csrf-cookie')

	const apiAuthClient = axios.create({
		baseURL: "http://localhost:8000",
		withCredentials: true,
	})

	const userData = useQuery(
		["USER"],
		async () => {
			const response = await apiClient
				.get("/user")
				.then((res) => res.data)
				.catch((res) => null)
			return response
		},
		{ staleTime: Infinity }
	)

	const login = useMutation(
		async (dataLogin) => {
			await csrf()
			const response = await apiAuthClient.post("/login", { ...dataLogin })
			return response
		},
		{
			onSuccess: function (res) {
				queryClient.setQueryData("USER", () => {
					return res.data
				})
			},
		}
	)

	const register = useMutation(
		async (registerData) => {
			await csrf()
			const response = await apiAuthClient.post("/register", {
				...registerData,
			})

			return response
		},
		{
			onSuccess: function (res) {
				queryClient.setQueryData("USER", () => {
					return res.data
				})
			},
		}
	)

	const logout = useMutation(
		async () => {
			const response = await apiAuthClient.post("/logout")
			return response
		},
		{
			onSuccess: function (response) {
				queryClient.setQueryData("USER", null)
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
		await csrf()
		const response = await apiAuthClient.put("/user/password", { ...dataPassword })
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
