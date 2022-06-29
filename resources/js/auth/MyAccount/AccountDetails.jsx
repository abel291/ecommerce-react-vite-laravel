import InputLabel from "../../components/InputLabel"
import Button from "../../components/Button"

import { useState } from "react"


import Notifications from "../../components/Notifications"
import useAuth from "../../hooks/useAuth"
const AccountDetails = () => {
    const { user, updateUser } = useAuth()

    const [notification, setNotifications] = useState({})
    const [dataUser, setDataUser] = useState({
        name: user.name,
        phone: user.phone,
        email: user.email,
        email_confirmation: user.email,
        city: user.city,
        country: user.country,
    })
    /**setNotifications({
                    ...notification,
                    type: "ok",
                    title: "Operacion exitosa",
                })
setNotifications({
                    ...notification,
                    type: "error",
                    errors: ValidaterErrors(response.response), //return array
                }) */
    const handleSubmit = async (e) => {
        e.preventDefault()
        setNotifications({ ...notification, type: "" })
        updateUser.mutate(dataUser, {
            onSuccess: (data, variables, context) => {
                setNotifications({
                    ...notification,
                    type: "ok",
                    title: "Operacion exitosa",
                })
            },
            onError: (error, variables, context) => {
                setNotifications({
                    ...notification,
                    type: "error",
                    errorResponse: error.response,
                })
            },
        })
    }
    const handleChangle = (e) => {
        let target = e.target
        setDataUser({ ...dataUser, [target.name]: target.value })
    }
    return (
        <div className="space-y-2">
            <h3 className="font-bold text-2xl mb-6"> Detalles de Cuenta</h3>
            <Notifications {...notification} />
            <form action="" onSubmit={handleSubmit}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-5 gap-x-4 gap-y-2 mb-4">
                    <div>
                        <InputLabel onChange={handleChangle} name="name" value={dataUser.name} label={"Nombre y Apellido *"} />
                    </div>
                    <div className=" ">
                        <InputLabel onChange={handleChangle} name="phone" value={dataUser.phone} label={"Telefono *"} />
                    </div>
                    <div>
                        <InputLabel type="email" onChange={handleChangle} name="email" value={dataUser.email} label={"Email *"} />
                    </div>

                    <div>
                        <InputLabel
                            type="email"
                            onChange={handleChangle}
                            value={dataUser.email_confirmation}
                            name="email_confirmation"
                            label={"Confirmar Email *"}
                        />
                    </div>
                    <div>
                        <InputLabel onChange={handleChangle} name="city" value={dataUser.city} label={"Ciudad *"} />
                    </div>
                    <div>
                        <InputLabel onChange={handleChangle} name="country" value={dataUser.country} label={"Pais *"} />
                    </div>
                </div>
                <Button isLoading={updateUser.isLoading}>Guardar</Button>
            </form>
        </div>
    )
}

export default AccountDetails
