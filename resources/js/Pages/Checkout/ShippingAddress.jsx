
import TextInput from "@/Components/Form/TextInput"
import Textarea from "@/Components/Form/Textarea"
import { FormGrid } from "@/Components/Form/FormGrid"
import InputLabel from "@/Components/Form/InputLabel"
import { PaymentElement } from "@stripe/react-stripe-js"

import { useContext } from "react"
import { CheckoutContext } from "@/Components/Context/CheckoutProvider"

const ShippingAddress = ({ handleSubmit }) => {
	const { userForm } = useContext(CheckoutContext);
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
			</div>
			<div className="md:col-span-3">
				<InputLabel>Email</InputLabel>
				<TextInput
					name="email"
					required
					onChange={(e) => userForm.setData('email', e.target.value)}
					className="w-full"
					value={userForm.data.email} />
			</div>
			<div className="md:col-span-5">
				<InputLabel>Direccion</InputLabel>
				<TextInput
					name="address"
					required
					onChange={(e) => userForm.setData('address', e.target.value)}
					className="w-full"
					value={userForm.data.address} />
			</div>
			<div className="md:col-span-3">
				<InputLabel>Telefono</InputLabel>
				<TextInput
					name="phone"
					required
					onChange={(e) => userForm.setData('phone', e.target.value)}
					className="w-full"
					value={userForm.data.phone} />
			</div>

			<div className="md:col-span-3">
				<InputLabel>Ciudad</InputLabel>
				<TextInput
					name="city"
					required
					onChange={(e) => userForm.setData('city', e.target.value)}
					className="w-full"
					value={userForm.data.city} />
			</div>
			<div className="md:col-span-3">
				<InputLabel>Codigo Postal</InputLabel>
				<TextInput
					name="postalCode"
					required
					onChange={(e) => userForm.setData('postalCode', e.target.value)}
					className="w-full"
					value={userForm.data.postalCode}

				/>
			</div>

			<div className="md:col-span-6">
				<InputLabel>Nota adicional</InputLabel>
				<Textarea name="note"
					label="Nota adicional"
					onChange={(e) => userForm.setData('note', e.target.value)}
					rows="5"
					value={userForm.data.note} />
			</div>

		</FormGrid>

	)
}

export default ShippingAddress
