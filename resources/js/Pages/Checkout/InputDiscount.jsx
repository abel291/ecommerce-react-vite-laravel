import { CheckoutContext } from '@/Components/Context/CheckoutProvider'
import InputLabel from '@/Components/Form/InputLabel'
import InputError from '@/Components/Form/InputError'
import PrimaryButton from '@/Components/PrimaryButton'
import TextInput from '@/Components/Form/TextInput'
import { useForm, usePage } from '@inertiajs/react'
import React from 'react'
import { useContext } from 'react'
import SecondaryButton from '@/Components/SecondaryButton'

const InputDiscount = () => {


	const { dicountCodes } = usePage().props

	const { data, setData, post, errors, processing, reset } = useForm({
		discountCode: '',
	})

	const handleSubmitDiscount = (e) => {
		e.preventDefault()
		post(route('checkout.apply-discount'), {
			preserveScroll: true,
			onSuccess: () => {
				reset('discountCode')
			}
		})
	}
	return (
		<>
			<form onSubmit={handleSubmitDiscount} className=" ">
				<InputLabel>Código de descuento</InputLabel>
				<div className="flex items-stretch gap-x-3 mt-2">
					<TextInput
						name="discountCode"
						required
						onChange={(e) => setData('discountCode', e.target.value)}
						className=" uppercase"

						value={data.discountCode} />
					<SecondaryButton isLoading={processing} disabled={processing} >Aplicar</SecondaryButton>
				</div>
			</form>
			<div className="flex gap-x-3 text-xs text-gray-400 mt-2">
				{dicountCodes.map((item) => (
					<span key={item.code}>{item.code}</span>
				))}
			</div>
			<InputError className="mt-1.5" message={errors.discountCode} />
		</>
	)
}

export default InputDiscount