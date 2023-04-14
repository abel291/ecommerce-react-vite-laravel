import PrimaryButton from "@/Components/PrimaryButton"
import TextInput from "@/Components/TextInput"



const Suscribe = () => {
	return (
		<div className="bg-gray-50 p-6 lg:p-16 rounded-lg shadow ">
			<div className="flex flex-col lg:flex-row  space-y-8 lg:space-y-0 space-x-0 lg:space-x-2  lg:items-center lg:justify-between">
				<div className="lg:w-1/2 text-center lg:text-left">
					<h3 className="text-xl lg:text-2xl font-bold mb-2 lg:mb-4">
						Obtenga consejos de Profesionales en su bandeja de entrada
					</h3>
					<p className="lg:text-sm">Suscríbase a nuestro boletín y manténgase actualizado.</p>
				</div>
				<div className="lg:w-1/2 ">
					<div className="flex flex-col lg:flex-row  space-y-2 lg:space-y-0 space-x-0 lg:space-x-2">
						<TextInput
							type="text"
							className="grow  shadow-none"
							placeholder="Escriba su email aqui"
						/>
						<PrimaryButton>Suscribirse</PrimaryButton>
					</div>
				</div>
			</div>
		</div>
	)
}

export default Suscribe
