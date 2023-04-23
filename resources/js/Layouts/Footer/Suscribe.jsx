import InputError from "@/Components/InputError"
import PrimaryButton from "@/Components/PrimaryButton"
import TextInput from "@/Components/TextInput"
import { useForm, usePage } from "@inertiajs/react"



const Suscribe = () => {
	const { data, setData, post, processing, errors, reset } = useForm({
		email: '',
	})

	function handleSubmit(e) {
		e.preventDefault()
		post('/subscribe', {
			preserveScroll: true,
			onSuccess: () => reset('email'),
		})
	}

	return (
		<div className="bg-gray-50 p-6 lg:p-16 rounded-lg  ">
			<div className="flex flex-col lg:flex-row  space-y-8 lg:space-y-0 space-x-0 lg:space-x-2  lg:items-center lg:justify-between">
				<div className="lg:w-1/2 text-center lg:text-left">
					<h3 className="text-xl lg:text-2xl font-bold mb-2 lg:mb-4">
						Obtenga consejos de profesionales en su bandeja de entrada
					</h3>
					<p className="lg:text-sm">Suscríbase a nuestro boletín y manténgase actualizado.</p>
				</div>
				<div className="lg:w-1/2 ">
					<form onSubmit={handleSubmit} className="flex flex-col lg:flex-row  space-y-2 lg:space-y-0 space-x-0 lg:space-x-2">
						<div className="grow w-full">
							<TextInput
								onChange={e => setData('email', e.target.value)}
								type="text"
								className=" w-full text-sm shadow-none"
								placeholder="Escriba su email aqui"
								value={data.email}
							/>


						</div>
						<PrimaryButton className="justify-center" disabled={processing} isLoading={processing}>Suscribirse</PrimaryButton>
					</form>
					<InputError className="mt-1.5" message={errors.email} />

				</div>
			</div>
		</div>
	)
}

export default Suscribe
