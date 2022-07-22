import { useEffect, useState } from "react"
import { Link, useNavigate, useLocation } from "react-router-dom"
import Button from "../components/Button"
import InputLabel from "../components/InputLabel"
import Notifications from "../components/Notifications"
import LoadingPage from "../components/LoadingPage"



import useAuth from "../hooks/useAuth"
//import Input from "../components/Input"

const Login = () => {
	const [notification, setNotifications] = useState({})

	const location = useLocation()
	const navigate = useNavigate()

	//console.log()

	let { from } = location.state || { from: { pathname: "/" } }

	const { userData, login, isLogged } = useAuth()

	const [dataLogin, setDataLogin] = useState({
		email: "example@exmaple.com",
		password: "123123",
		remember: true,
	})
	useEffect(() => {
		console.log(from)
		if (isLogged) {
			navigate(from.pathname, { replace: true })
		}
	}, [isLogged, from])

	const handleSubmit = async (e) => {
		e.preventDefault()
		setNotifications({ type: "" })
		login.mutate(dataLogin, {
			onError: (error, variables, contexto) => {
				setNotifications({
					type: "error",
					errorResponse: error.response,
				})
			},
		})
	}

	const handleChangle = (e) => {
		let target = e.target
		let value = target.type === "checkbox" ? target.checked : target.value
		setDataLogin({ ...dataLogin, [target.name]: value })
	}

	if (userData.isLoading) return <LoadingPage />

	return (
		<div className="py-content flex items-center justify-center  px-4 sm:px-6 lg:px-8">
			<div className="max-w-md w-full">
				<div>
					<h2 className="mt-6 text-lg font-bold">Inicie sesión con su correo electrónico y contraseña</h2>
				</div>
				<Notifications {...notification} />

				<form className="mt-8 space-y-6" onSubmit={handleSubmit}>
					
					<div className="rounded-md shadow-sm space-y-4">
						<div>
							<InputLabel
								require={true}
								onChange={handleChangle}
								name="email"
								value={dataLogin.email}
								label={"Email *"}
								type="email"
							/>
						</div>
						<div>
							<InputLabel
								require={true}
								onChange={handleChangle}
								type="password"
								name="password"
								value={dataLogin.password}
								label={"Contraseña *"}
							/>
						</div>
					</div>

					<div className="flex items-center justify-between text-sm">
						<div className="flex items-center">
							<input
								name="remember"
								type="checkbox"
								className="h-4 w-4"
								checked={dataLogin.remember}
								onChange={handleChangle}
							/>
							<label htmlFor="remember" className="ml-2 block ">
								Recordarme
							</label>
						</div>

						<div className="">
							<a href="/" className="font-medium text-orange-600 hover:text-orange-500">
								Olvidaste tu contraseña?
							</a>
						</div>
					</div>
					<div className="text-left text-sm font-medium text-gray-500">
						<span className="block">user: example@exmaple.com</span>
						<span className="block">contraseña : 123123</span>
					</div>
					<div>
						<Button

							isLoading={login.isLoading}
							textLoading="Iniciando..."
							styleClass="w-full text-white bg-orange-600 "
						>
							Iniciar sesión
						</Button>
					</div>
					<div>
						<p className="mt-2 text-center text-sm ">
							<span>¿No tienes cuenta? </span>
							<Link to="/register" className="font-bold text-orange-600 hover:text-orange-500">
								Registrarte
							</Link>
						</p>
					</div>
				</form>
			</div>
		</div>
	)
}

export default Login
