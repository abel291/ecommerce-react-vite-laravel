import { useState } from "react"
import InputLabel from "../../components/InputLabel"
import { useForm, usePage } from "@inertiajs/react"
import PrimaryButton from "@/Components/PrimaryButton"
import TextInput from "@/Components/TextInput"
import Textarea from "@/Components/Textarea"
import { FormGrid } from "@/Components/Form/FormGrid"
import LabelInput from "@/Components/Form/LabelInput"
import { PaymentElement } from "@stripe/react-stripe-js"

import { useContext } from "react"
import { CheckoutContext } from "@/Components/Context/CheckoutProvider"

const ShippingAddress = ({ handleSubmit }) => {
	const { userForm } = useContext(CheckoutContext);
	return (

		<FormGrid>
			<div className="md:col-span-3">
				<LabelInput>Nombre</LabelInput>
				<TextInput
					name="name"
					required
					onChange={(e) => userForm.setData('name', e.target.value)}
					className="w-full"
					value={userForm.data.name} />
			</div>
			<div className="md:col-span-3">
				<LabelInput>Email</LabelInput>
				<TextInput
					name="email"
					required
					onChange={(e) => userForm.setData('email', e.target.value)}
					className="w-full"
					value={userForm.data.email} />
			</div>
			<div className="md:col-span-5">
				<LabelInput>Direccion</LabelInput>
				<TextInput
					name="address"
					required
					onChange={(e) => userForm.setData('address', e.target.value)}
					className="w-full"
					value={userForm.data.address} />
			</div>
			<div className="md:col-span-3">
				<LabelInput>Telefono</LabelInput>
				<TextInput
					name="phone"
					required
					onChange={(e) => userForm.setData('phone', e.target.value)}
					className="w-full"
					value={userForm.data.phone} />
			</div>

			<div className="md:col-span-3">
				<LabelInput>Ciudad</LabelInput>
				<TextInput
					name="city"
					required
					onChange={(e) => userForm.setData('city', e.target.value)}
					className="w-full"
					value={userForm.data.city} />
			</div>
			<div className="md:col-span-3">
				<LabelInput>Codigo Postal</LabelInput>
				<TextInput
					name="postalCode"
					required
					onChange={(e) => userForm.setData('postalCode', e.target.value)}
					className="w-full"
					value={userForm.data.postalCode}

				/>
			</div>

			<div className="md:col-span-6">
				<LabelInput>Nota adicional</LabelInput>
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
