import { Route, Navigate, useLocation } from "react-router-dom"
import LoadingPage from "../components/LoadingPage"
import useAuth from "../hooks/useAuth"


//import { useEffect, useState } from "react"

const PrivateRoute = ({ Component }) => {

    const location = useLocation()
    const { userData } = useAuth()
    const { isLoading, error, data: user } = userData

    if (isLoading) return <LoadingPage />

    if (error) return "An error has occurred: " + error.message

    return user ? (
        <Component />
    ) : (
        <Navigate
            to="/login"
            state={{ from: location }}
        />
    )
}
export default PrivateRoute
