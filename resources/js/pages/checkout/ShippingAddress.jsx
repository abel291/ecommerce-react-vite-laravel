import { useState } from "react"

import Button from "../../components/Button"
import InputLabel from "../../components/InputLabel"
import useAuth from "../../hooks/useAuth"


const ShippingAddress = ({ handleSubmit, isLoading }) => {
    const { user } = useAuth()

    const [dataAdress, setDataAdress] = useState({
        name: user.name,
        address: "address",
        phone: user.phone,
        email: user.email,
        city: user.city,
        postalCode: "112233",
        note: "",
    })
    const handleChangle = (e) => {
        let target = e.target
        let value = target.value
        setDataAdress({ ...dataAdress, [target.name]: value })
    }

    return (
        <form className="grid grid-cols-1 md:grid-cols-2 gap-4" onSubmit={handleSubmit}>
            <div>
                <InputLabel name="name" required={true} onChange={handleChangle} label="Nombre *" value={dataAdress.name} />
            </div>
            <div className="hidden md:grid"></div>
            <div className="md:col-span-2">
                <InputLabel name="address" required={true} onChange={handleChangle} label="Direccion *" value={dataAdress.address} />
            </div>
            <div>
                <InputLabel name="phone" required={true} onChange={handleChangle} label="Telefono" value={dataAdress.phone} />
            </div>
            <div>
                <InputLabel name="email" required={true} onChange={handleChangle} label="Email" value={dataAdress.email} />
            </div>
            <div>
                <InputLabel name="city" required={true} onChange={handleChangle} label="Ciudad" value={dataAdress.city} />
            </div>
            <div>
                <InputLabel
                    name="postalCode"
                    required={true}
                    onChange={handleChangle}
                    label="Codigo Postal"
                    value={dataAdress.postalCode}
                />
            </div>
            <div className="md:col-span-2">
                <label htmlFor="email" className="text-sm font-semibold">
                    Nota adicional
                </label>
                <textarea name="note" onChange={handleChangle} className="mt-1 w-full text-sm px-4 py-3" rows="5" value={dataAdress.note} />
            </div>
            <div>
                <Button isLoading={isLoading}>
                    Realizar Pedido
                </Button>
            </div>
        </form>
    )
}

export default ShippingAddress
