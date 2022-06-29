import { useState } from "react"
import Button from "../../components/Button"
import InputLabel from "../../components/InputLabel"
import Notifications from "../../components/Notifications"

import useAuth from "../../hooks/useAuth"


const ChangePassword = () => {
    
    const { updatePassword } = useAuth()
    

    const [notification, setNotifications] = useState({})
    const dataPasswordInit={
        current_password: "",
        password: "",
        password_confirmation: "",
    }
    const [dataPassword, setDataPassword] = useState(dataPasswordInit)

    const handleSubmit = async (e) => {
        e.preventDefault()
        setNotifications({ ...notification, type: "" })
        updatePassword.mutate(dataPassword, {
            onSuccess: (data, variables, context) => {
                setNotifications({
                    ...notification,
                    type: "ok",
                    title: "Operacion exitosa",
                })
                setDataPassword(dataPasswordInit)

            },
            onError: (error, variables, context) => {
                setNotifications({
                    ...notification,
                    type: "error",
                    errorResponse: error.response, //return array
                })
            },
        })
    }
    const handleChangle = (e) => {
        let target = e.target
        setDataPassword({ ...dataPassword, [target.name]: target.value })
    }
    return (
        <div className="space-y-2">
            <h3 className="font-bold text-2xl mb-6"> Cambiar contraseña</h3>
            <Notifications {...notification} />
            <form action="" onSubmit={handleSubmit}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 mb-4">
                    <div>
                        <InputLabel
                            required={true}
                            type="password"
                            onChange={handleChangle}
                            value={dataPassword.current_password}
                            name="current_password"
                            label="Contraseña Actual *"
                        />
                    </div>
                    <div></div>
                    <div>
                        <InputLabel
                            required={true}
                            type="password"
                            onChange={handleChangle}
                            value={dataPassword.password}
                            name="password"
                            label={"Contraseña nueva*"}
                        />
                    </div>
                    <div>
                        <InputLabel
                            required={true}
                            type="password"
                            onChange={handleChangle}
                            value={dataPassword.password_confirmation}
                            name="password_confirmation"
                            label={"Confirmar contraseña nueva*"}
                        />
                    </div>
                </div>
                <Button isLoading={updatePassword.isLoading} >Guardar</Button>
            </form>
        </div>
    )
}

export default ChangePassword
