
import InputLabel from "../../components/InputLabel"
import { Head, useForm } from "@inertiajs/react"
import PrimaryButton from "@/Components/PrimaryButton"
import TextInput from "@/Components/TextInput"
import Profile from "./Profile"
import InputError from "@/Components/InputError"

const ChangePassword = () => {

	const { data, setData, put, errors, processing } = useForm({
		current_password: "",
		password: "",
		password_confirmation: "",
	})

	const handleSubmit = async (e) => {
		e.preventDefault()

		put(route('profile-password-update'), {
			preserveScroll: true
		})
	}

	return (
		<Profile>
			<Head title="Cambio de contraseña" />
			<div className="space-y-2">
				<h3 className="font-bold text-2xl mb-6"> Cambiar contraseña</h3>

				<form action="" onSubmit={handleSubmit}>
					<div className="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 mb-4">
						<div>
							<InputLabel>Contraseña Actual *</InputLabel>
							<TextInput
								className="w-full mt-1"
								required={true}
								type="password"
								value={data.current_password}
								name="current_password"
								onChange={(e) => setData('current_password', e.target.value)}
							/>
							<InputError message={errors.current_password} />
						</div>

						<div>
							<InputLabel>Contraseña nueva*</InputLabel>
							<TextInput
								className="w-full mt-1"
								required={true}
								type="password"
								value={data.password}
								name="password"
								onChange={(e) => setData('password', e.target.value)}
							/>
							<InputError message={errors.password} />
						</div>
						<div>
							<InputLabel>Confirmar contraseña nueva*</InputLabel>
							<TextInput
								className="w-full mt-1"
								required={true}
								type="password"
								value={data.password_confirmation}
								name="password_confirmation"
								onChange={(e) => setData('password_confirmation', e.target.value)}
							/>
							<InputError message={errors.password_confirmation} />
						</div>
					</div>
					<div className="text-right">
						<PrimaryButton isLoading={processing} disabled={processing} >Guardar</PrimaryButton>
					</div>
				</form>
			</div>
		</Profile>
	)
}

export default ChangePassword
