import { useEffect, useState, useContext } from 'react'

import { CardElement, PaymentElement, useElements, useStripe } from "@stripe/react-stripe-js"
import PrimaryButton from '@/Components/PrimaryButton'
import { formatCurrency } from '@/Helpers/helpers'
import InputLabel from '@/Components/Form/InputLabel'
import { router, usePage } from '@inertiajs/react'
import TextInput from '@/Components/Form/TextInput'
import { FormGrid } from '@/Components/Form/FormGrid'
import { CheckCircleIcon } from '@heroicons/react/24/solid'
import InputError from '@/Components/Form/InputError'
import { CheckoutContext } from '@/Components/Context/CheckoutProvider'


function PaymentForm() {

	const { userForm } = useContext(CheckoutContext);
	const stripe = useStripe();
	const elements = useElements();

	const { total, errors } = usePage().props

	const [cardData, setCardData] = useState({
		name: userForm.data.name,
		email: userForm.data.email,
	})

	const [loading, setLoading] = useState(false)

	const [errorCard, setErrorCard] = useState(null)

	const handleSubmit = async (event) => {

		event.preventDefault();

		if (!stripe || !elements) {
			return;
		}
		setErrorCard(null)
		setLoading(true)

		await stripe.createPaymentMethod(
			'card', elements.getElement(CardElement), {
			billing_details: {
				name: userForm.data.name,
				email: userForm.data.email,
				phone: userForm.data.phone,
			},
		}).then(function (result) {

			router.visit(route('purchase'), {
				method: 'post',
				preserveScroll: true,
				preserveState: true,
				data: {
					...userForm.data,
					paymentMethodId: result.paymentMethod.id
				},
				onFinish: visit => {
					setLoading(false)
				},
			});

		}).catch(function (error) {
			setLoading(false)
			setErrorCard(error.message)


		})

	};

	const CARD_ELEMENT_OPTIONS = {
		style: {
			base: {
				fontWeight: '500',
				fontFamily: 'Inter, sans-serif',
				fontSize: '16px',
				fontSmoothing: 'antialiased',
			},
			invalid: {
				iconColor: '#FFC7EE',
				color: '#FFC7EE',
			},
		},
	};

	return (
		<FormGrid>
			<div className="sm:col-span-6">
				<InputLabel >Nombre</InputLabel>
				<TextInput
					name="cardData"
					required
					onChange={(e) => setCardData(e.target.value)}
					className="w-full"
					value={cardData.name} />
			</div>

			<div className="sm:col-span-6">
				<InputLabel >Email</InputLabel>
				<TextInput
					name="cardData"
					required
					onChange={(e) => setCardData(e.target.value)}
					className="w-full"
					value={cardData.email} />
			</div>

			<div className="sm:col-span-6">
				<InputLabel htmlFor="card-element">Targeta de credito</InputLabel>
				<div className={" py-2.5 px-3 rounded-md " + ((errorCard) ? 'ring-inset ring-2 ring-red-500' : 'border')}>
					<CardElement id="card-element" options={CARD_ELEMENT_OPTIONS} />
				</div>
				<span className='text-sm text-gray-400 mt-1 block'>ej: 4242424242424242 </span>
				<InputError message={errorCard} className="mt-2" />
				<InputError message={errors.card} className="mt-2" />

			</div>
			<div className="sm:col-span-6">
				<PrimaryButton className="w-full mt-4" onClick={handleSubmit}
					isLoading={loading} disabled={loading}>
					Pagar {formatCurrency(total.total)}
				</PrimaryButton>
			</div>

			{/* <div className="sm:col-span-6">
				<ol className="space-y-4 font-medium text-sm">
					<li>
						<div className="flex items-center gap-x-3">
							<CheckCircleIcon className="w-5 h-5 text-green-500" />
							Validando Monto
						</div>
					</li>
					<li>
						<div className="flex items-center gap-x-3">
							<CheckCircleIcon className="w-5 h-5 text-green-500" />
							Validando Targeta
						</div>
					</li>
					<li>
						<div className="flex items-center gap-x-3">
							<CheckCircleIcon className="w-5 h-5 text-green-500" />
							Creando Orden
						</div>
					</li>
					<li>
						<div className="flex items-center gap-x-3">
							<CheckCircleIcon className="w-5 h-5 text-green-500" />
							Redireccionando
						</div>
					</li>
				</ol>
			</div> */}
		</FormGrid>
	)
}

export default PaymentForm