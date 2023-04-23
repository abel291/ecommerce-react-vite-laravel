import { useState } from "react"
import InputLabel from "../../components/InputLabel"
import { useForm, usePage } from "@inertiajs/react"
import PrimaryButton from "@/Components/PrimaryButton"
import TextInput from "@/Components/TextInput"
import Textarea from "@/Components/Textarea"


const ShippingAddress = () => {
	const { auth, products } = usePage().props

	const { data, setData, post, errors, processing } = useForm({
		name: auth.user.name,
		address: "address",
		phone: auth.user.phone,
		email: auth.user.email,
		city: auth.user.city,
		postalCode: "112233",
		note: "",
	})

	const handleSubmit = (e) => {
		e.preventDefault()
		post(route('pay'))
	}

	return (
		<form className="grid grid-cols-1 md:grid-cols-2 gap-4" onSubmit={handleSubmit}>
			<div>
				<TextInput
					name="name"
					required
					onChange={(e) => setData('name', e.target.value)}
					className="w-full"
					placeholder="Nombre *"
					value={data.name} />
			</div>
			<div className="hidden md:grid"></div>
			<div className="md:col-span-2">
				<TextInput
					name="address"
					required
					onChange={(e) => setData('address', e.target.value)}
					className="w-full"
					placeholder="Direccion *"
					value={data.address} />
			</div>
			<div>
				<TextInput
					name="phone"
					required
					onChange={(e) => setData('phone', e.target.value)}
					className="w-full"
					placeholder="Telefono"
					value={data.phone} />
			</div>
			<div>
				<TextInput
					name="email"
					required
					onChange={(e) => setData('email', e.target.value)}
					className="w-full"
					placeholder="Email"
					value={data.email} />
			</div>
			<div>
				<TextInput
					name="city"
					required
					onChange={(e) => setData('city', e.target.value)}
					className="w-full"
					placeholder="Ciudad"
					value={data.city} />
			</div>
			<div>
				<TextInput
					name="postalCode"
					required
					onChange={(e) => setData('postalCode', e.target.value)}
					className="w-full"
					placeholder="Codigo Postal"
					value={data.postalCode}

				/>
			</div>
			<div className="md:col-span-2">
				<Textarea name="note"
					placeholder="Nota adicional"
					onChange={(e) => setData('note', e.target.value)}
					rows="5"
					value={data.note} />
			</div>
			<div>
				<PrimaryButton isLoading={processing} disabled={processing}>
					Realizar Pedido
				</PrimaryButton>
			</div>
		</form>
	)
}

export default ShippingAddress
