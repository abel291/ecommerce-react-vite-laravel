

import TextInput from "@/Components/TextInput"
import PrimaryButton from "@/Components/PrimaryButton"
import Profile from "./Profile"
import { Head, useForm, usePage } from "@inertiajs/react"
import { useState } from "react"
import InputLabel from "@/Components/InputLabel"
import InputError from "@/Components/InputError"
const AccountDetails = () => {
	const { auth } = usePage().props

	const [notification, setNotifications] = useState({})
	const { data, setData, patch, processing, errors } = useForm({
		name: auth.user.name,
		phone: auth.user.phone,
		email: auth.user.email,
		email_confirmation: auth.user.email,
		city: auth.user.city,
		country: auth.user.country,
	})

	const handleSubmit = (e) => {
		e.preventDefault()
		patch(route('profile.update'), {
			preserveScroll: true
		})
	}
	return (
		<Profile>
			<Head title="Detalles de cuenta" />
			<div className="space-y-2">
				<h3 className="font-bold text-2xl mb-6"> Detalles de Cuenta</h3>

				<form onSubmit={handleSubmit}>
					<div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
						<div>
							<InputLabel>Nombre y Apellido *</InputLabel>
							<TextInput className="w-full mt-1" onChange={(e) => setData('name', e.target.value)} name="name" value={data.name} placeholder={"Nombre y Apellido *"} />
							<InputError message={errors.name} />
						</div>
						<div className=" ">
							<InputLabel>Telefono *</InputLabel>
							<TextInput className="w-full mt-1" onChange={(e) => setData('phone', e.target.value)} name="phone" value={data.phone} placeholder={"Telefono *"} />
							<InputError message={errors.phone} />
						</div>
						<div>
							<InputLabel>Email *</InputLabel>
							<TextInput className="w-full mt-1" type="email" onChange={(e) => setData('email', e.target.value)} name="email" value={data.email} placeholder={"Email *"} />
							<InputError message={errors.email} />
						</div>

						<div>
							<InputLabel>Confirmar Email *</InputLabel>
							<TextInput className="w-full mt-1
							"
								type="email"
								onChange={(e) => setData('email_confirmation', e.target.value)}
								value={data.email_confirmation}
								name="email_confirmation"
								placeholder={"Confirmar Email *"}
							/>
						</div>
						<div>
							<InputLabel>Ciudad *</InputLabel>
							<TextInput className="w-full mt-1" onChange={(e) => setData('city', e.target.value)} name="city" value={data.city} placeholder={"Ciudad *"} />
							<InputError message={errors.city} />
						</div>
						<div>
							<InputLabel>Pais *</InputLabel>
							<TextInput className="w-full mt-1" onChange={(e) => setData('country', e.target.value)} name="country" value={data.country} placeholder={"Pais *"} />
							<InputError message={errors.country} />
						</div>
					</div>
					<div className="text-right">
						<PrimaryButton disabled={processing} isLoading={processing}>Guardar</PrimaryButton>
					</div>
				</form>
			</div>
		</Profile>
	)
}

export default AccountDetails
