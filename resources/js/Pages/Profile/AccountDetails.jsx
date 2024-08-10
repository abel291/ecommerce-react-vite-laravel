

import TextInput from "@/Components/Form/TextInput"
import PrimaryButton from "@/Components/PrimaryButton"
import LayoutProfile from "../../Layouts/LayoutProfile"
import { Head, useForm, usePage } from "@inertiajs/react"
import { useState } from "react"
import InputLabel from "@/Components/Form/InputLabel"
import InputError from "@/Components/Form/InputError"
import SectionTitle from "@/Components/Sections/SectionTitle"
import { FormGrid } from "@/Components/Form/FormGrid"
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
		patch(route('profile.account-details.update'), {
			preserveScroll: true
		})
	}
	return (
		<LayoutProfile title="Detalles de Cuenta" breadcrumb={[
			{
				title: "Detalles de cuenta",
				path: route("profile.account-details")

			},
		]}>
			<Head title="Detalles de cuenta" />
			<div className="space-y-2">


				<form onSubmit={handleSubmit}>

					<FormGrid className="max-w-2xl">
						<div className="sm:col-span-3">
							<InputLabel>Nombre y Apellido *</InputLabel>
							<TextInput className="w-full mt-2" onChange={(e) => setData('name', e.target.value)} name="name" value={data.name} placeholder={"Nombre y Apellido *"} />
							<InputError message={errors.name} />
						</div>
						<div className=" sm:col-span-3">
							<InputLabel>Telefono *</InputLabel>
							<TextInput className="w-full mt-2" onChange={(e) => setData('phone', e.target.value)} name="phone" value={data.phone} placeholder={"Telefono *"} />
							<InputError message={errors.phone} />
						</div>
						<div className="sm:col-span-3">
							<InputLabel>Email *</InputLabel>
							<TextInput className="w-full mt-2" type="email" onChange={(e) => setData('email', e.target.value)} name="email" value={data.email} placeholder={"Email *"} />
							<InputError message={errors.email} />
						</div>

						<div className="sm:col-span-3">
							<InputLabel>Confirmar Email *</InputLabel>
							<TextInput className="w-full mt-2
							"
								type="email"
								onChange={(e) => setData('email_confirmation', e.target.value)}
								value={data.email_confirmation}
								name="email_confirmation"
								placeholder={"Confirmar Email *"}
							/>
						</div>
						<div className="sm:col-span-3">
							<InputLabel>Ciudad *</InputLabel>
							<TextInput className="w-full mt-2" onChange={(e) => setData('city', e.target.value)} name="city" value={data.city} placeholder={"Ciudad *"} />
							<InputError message={errors.city} />
						</div>
						<div className="sm:col-span-3">
							<InputLabel>Pais *</InputLabel>
							<TextInput className="w-full mt-2" onChange={(e) => setData('country', e.target.value)} name="country" value={data.country} placeholder={"Pais *"} />
							<InputError message={errors.country} />
						</div>
						<div className="text-right sm:col-span-6">
							<PrimaryButton disabled={processing} isLoading={processing}>Guardar</PrimaryButton>
						</div>
					</FormGrid>


				</form>
			</div>
		</LayoutProfile>
	)
}

export default AccountDetails
