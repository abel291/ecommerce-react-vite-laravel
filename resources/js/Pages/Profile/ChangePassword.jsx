
import InputLabel from "../../Components/Form/InputLabel"
import { Head, useForm } from "@inertiajs/react"
import PrimaryButton from "@/Components/PrimaryButton"
import TextInput from "@/Components/Form/TextInput"
import LayoutProfile from "../../Layouts/LayoutProfile"
import InputError from "@/Components/Form/InputError"
import { FormGrid } from "@/Components/Form/FormGrid"

const ChangePassword = () => {

	const { data, setData, put, errors, processing } = useForm({
		current_password: "",
		password: "",
		password_confirmation: "",
	})

	const handleSubmit = async (e) => {
		e.preventDefault()

		put(route('profile.password-update'), {
			preserveScroll: true
		})
	}

	return (
		<LayoutProfile title="Cambiar contraseña" breadcrumb={[
			{
				title: "Cambio de contraseña",
				path: route("profile.password")

			},
		]}>
			<Head title="Cambio de contraseña" />
			<div className="space-y-2">
				<form onSubmit={handleSubmit}>
					<FormGrid className="max-w-2xl">
						<div className="sm:col-span-3">
							<InputLabel>Contraseña Actual *</InputLabel>
							<TextInput
								className="w-full mt-2"
								required={true}
								type="password"
								value={data.current_password}
								name="current_password"
								onChange={(e) => setData('current_password', e.target.value)}
							/>
							<InputError message={errors.current_password} />
						</div>

						<div className="sm:col-span-3">
							<InputLabel>Contraseña nueva*</InputLabel>
							<TextInput
								className="w-full mt-2"
								required={true}
								type="password"
								value={data.password}
								name="password"
								onChange={(e) => setData('password', e.target.value)}
							/>
							<InputError message={errors.password} />
						</div>
						<div className="sm:col-span-3">
							<InputLabel>Confirmar contraseña nueva*</InputLabel>
							<TextInput
								className="w-full mt-2"
								required={true}
								type="password"
								value={data.password_confirmation}
								name="password_confirmation"
								onChange={(e) => setData('password_confirmation', e.target.value)}
							/>
							<InputError message={errors.password_confirmation} />
						</div>
						<div className="text-right sm:col-span-6">
							<PrimaryButton isLoading={processing} disabled={processing} >Guardar</PrimaryButton>
						</div>
					</FormGrid>

				</form>
			</div>
		</LayoutProfile>
	)
}

export default ChangePassword
