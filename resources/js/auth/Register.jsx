import { useEffect, useState } from "react"
import { Link, Navigate, useLocation, useNavigate } from "react-router-dom"
import Button from "../components/Button"
import InputLabel from "../components/InputLabel"
import Notifications from "../components/Notifications"
import useAuth from "../hooks/useAuth"

const Register = () => {
    let navigate = useNavigate();
    let location = useLocation();
    const [notification, setNotifications] = useState({})
    let email = "dani" + Math.floor(Math.random() * 101) + "@dani.com"

    const [dataRegister, setDataRegister] = useState({
        name: "dan",
        email: email,
        email_confirmation: email,
        phone: "32244321",
        country: "Mexico",
        city: "Mexico",
        password: "12312333",
        password_confirmation: "12312333",
    })

    const { register, isLogged } = useAuth()

    const handleChangle = (e) => {
        let target = e.target
        let value = target.type === "checkbox" ? target.checked : target.value
        setDataRegister({ ...dataRegister, [target.name]: value })
    }

    const handleSubmit = async (e) => {
        e.preventDefault()
        setNotifications({ type: "" })
        register.mutate(dataRegister, {

            onError: (error, variables, contexto) => {
                setNotifications({
                    type: "error",
                    errorResponse: error.response,
                })
            },
        })
    }
    useEffect(() => {
        if (isLogged) navigate("/", { replace: true })

    }, [isLogged, location])

    return (
        <div className="py-content flex items-center justify-center  px-4 sm:px-6 lg:px-8">
            <div className="max-w-xl w-full space-y-8">
                <div className="text-center">
                    <h2 className="mt-6 text-lg font-bold">Registrate</h2>
                    <span className="text-sm ">Al registrarse, acepta nuestros términos y política</span>
                </div>
                <Notifications {...notification} />
                <form className="mt-8 space-y-6" onSubmit={handleSubmit}>
                    <div>
                        <div className="space-y-6">
                            <div className=" grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                                <div>
                                    <InputLabel
                                        required={true}
                                        onChange={handleChangle}
                                        name="name"
                                        value={dataRegister.name}
                                        label={"Nombre y Apellido *"}
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        required={true}
                                        onChange={handleChangle}
                                        name="phone"
                                        value={dataRegister.phone}
                                        label={"Telefono *"}
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        type="email"
                                        required={true}
                                        onChange={handleChangle}
                                        name="email"
                                        value={dataRegister.email}
                                        label={"Email *"}
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        type="email"
                                        required={true}
                                        onChange={handleChangle}
                                        name="email_confirmation"
                                        value={dataRegister.email_confirmation}
                                        label={"ConfirmarEmail *"}
                                    />
                                </div>

                                <div>
                                    <InputLabel
                                        required={true}
                                        onChange={handleChangle}
                                        name="country"
                                        value={dataRegister.country}
                                        label={"Pais *"}
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        required={true}
                                        onChange={handleChangle}
                                        name="city"
                                        value={dataRegister.city}
                                        label={"Ciudad *"}
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        required={true}
                                        onChange={handleChangle}
                                        type="password"
                                        name="password"
                                        value={dataRegister.password}
                                        label={"Contraseña *"}
                                    />
                                </div>
                                <div>
                                    <InputLabel
                                        required={true}
                                        onChange={handleChangle}
                                        type="password"
                                        name="password_confirmation"
                                        value={dataRegister.password_confirmation}
                                        label={"Confirmar contraseña *"}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <Button
                            height="h-9"
                            isLoading={register.isLoading}
                            textLoading="Espere..."
                            styleClass="lg:w-full text-white bg-orange-600 "
                        >
                            Registrarme
                        </Button>
                    </div>
                    <div>
                        <p className="mt-2 text-center text-sm ">
                            <span>¿Ya tienes una cuenta? </span>
                            <Link to="/login" className="font-bold text-orange-600 hover:text-orange-500">
                                Inicia sesión
                            </Link>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    )
}

export default Register
