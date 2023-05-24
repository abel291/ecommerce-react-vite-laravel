import { useState } from "react"
import InputLabel from "../../components/InputLabel"
import { useForm, usePage } from "@inertiajs/react"
import PrimaryButton from "@/Components/PrimaryButton"
import TextInput from "@/Components/TextInput"
import Textarea from "@/Components/Textarea"
import { FormGrid } from "@/Components/Form/FormGrid"
import LabelInput from "@/Components/Form/LabelInput"


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
		<form onSubmit={handleSubmit}>
			<FormGrid>
				<div className="md:col-span-3">
					<LabelInput>Nombre</LabelInput>
					<TextInput
						name="name"
						required
						onChange={(e) => setData('name', e.target.value)}
						className="w-full"
						value={data.name} />
				</div>
				<div className="md:col-span-3">
					<LabelInput>Email</LabelInput>
					<TextInput
						name="email"
						required
						onChange={(e) => setData('email', e.target.value)}
						className="w-full"
						value={data.email} />
				</div>
				<div className="md:col-span-5">
					<LabelInput>Direccion</LabelInput>
					<TextInput
						name="address"
						required
						onChange={(e) => setData('address', e.target.value)}
						className="w-full"
						value={data.address} />
				</div>
				<div className="md:col-span-3">
					<LabelInput>Telefono</LabelInput>
					<TextInput
						name="phone"
						required
						onChange={(e) => setData('phone', e.target.value)}
						className="w-full"
						value={data.phone} />
				</div>

				<div className="md:col-span-3">
					<LabelInput>Ciudad</LabelInput>
					<TextInput
						name="city"
						required
						onChange={(e) => setData('city', e.target.value)}
						className="w-full"
						value={data.city} />
				</div>
				<div className="md:col-span-3">
					<LabelInput>Codigo Postal</LabelInput>
					<TextInput
						name="postalCode"
						required
						onChange={(e) => setData('postalCode', e.target.value)}
						className="w-full"
						value={data.postalCode}

					/>
				</div>
				<div className="md:col-span-6">
					<LabelInput>Nota adicional</LabelInput>
					<Textarea name="note"
						label="Nota adicional"
						onChange={(e) => setData('note', e.target.value)}
						rows="5"
						value={data.note} />
				</div>
				<div className="text-right md:col-span-6">
					<PrimaryButton isLoading={processing} disabled={processing}>
						Realizar Pedido
					</PrimaryButton>
				</div>
			</FormGrid>
		</form >
	)
}

export default ShippingAddress
