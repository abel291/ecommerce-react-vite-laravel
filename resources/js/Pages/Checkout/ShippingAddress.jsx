
import TextInput from "@/Components/Form/TextInput"
import Textarea from "@/Components/Form/Textarea"
import { FormGrid } from "@/Components/Form/FormGrid"
import InputLabel from "@/Components/Form/InputLabel"
import { PaymentElement } from "@stripe/react-stripe-js"

import { useContext } from "react"
import { CheckoutContext } from "@/Components/Context/CheckoutProvider"
import { usePage } from "@inertiajs/react"
import InputError from "@/Components/Form/InputError"

const ShippingAddress = ({ handleSubmit }) => {
	const { userForm } = useContext(CheckoutContext);
	const { errors } = usePage().props
	return (

		<FormGrid>
			<div className="md:col-span-3">
				<InputLabel>Nombre</InputLabel>
				<TextInput
					name="name"
					required
					onChange={(e) => userForm.setData('name', e.target.value)}
					className="w-full"
					value={userForm.data.name} />
				<InputError message={errors.name} className="mt-2" />
			</div>
			<div className="md:col-span-3">
				<InputLabel>Email</InputLabel>
				<TextInput
					name="email"
					required
					onChange={(e) => userForm.setData('email', e.target.value)}
					className="w-full"
					value={userForm.data.email} />
				<InputError message={errors.email} className="mt-2" />
			</div>
			<div className="md:col-span-5">
				<InputLabel>Direccion</InputLabel>
				<TextInput
					name="address"
					required
					onChange={(e) => userForm.setData('address', e.target.value)}
					className="w-full"
					value={userForm.data.address} />
				<InputError message={errors.address} className="mt-2" />
			</div>
			<div className="md:col-span-3">
				<InputLabel>Telefono</InputLabel>
				<TextInput
					name="phone"
					required
					onChange={(e) => userForm.setData('phone', e.target.value)}
					className="w-full"
					value={userForm.data.phone} />
				<InputError message={errors.phone} className="mt-2" />
			</div>

			<div className="md:col-span-3">
				<InputLabel>Ciudad</InputLabel>
				<TextInput
					name="city"
					required
					onChange={(e) => userForm.setData('city', e.target.value)}
					className="w-full"
					value={userForm.data.city} />
				<InputError message={errors.city} className="mt-2" />
			</div>
			<div className="md:col-span-3">
				<InputLabel>Codigo Postal</InputLabel>
				<TextInput
					name="postalCode"
					required
					onChange={(e) => userForm.setData('postalCode', e.target.value)}
					className="w-full"
					value={userForm.data.postalCode} />
				<InputError message={errors.postalCode} className="mt-2" />
			</div>

			<div className="md:col-span-6">
				<InputLabel>Nota adicional</InputLabel>
				<Textarea name="note"
					label="Nota adicional"
					onChange={(e) => userForm.setData('note', e.target.value)}
					rows="3"
					value={userForm.data.note} />
				<InputError message={errors.note} className="mt-2" />
			</div>

		</FormGrid>

	)
}

export default ShippingAddress
