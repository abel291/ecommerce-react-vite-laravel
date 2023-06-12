import PrimaryButton from '@/Components/PrimaryButton'
import SectionTitle from '@/Components/Sections/SectionTitle'
import TextInput from '@/Components/Form/TextInput'
import Textarea from '@/Components/Form/Textarea'
import { useForm } from '@inertiajs/react'
import React from 'react'
import { useState } from "react"
import { toast } from 'react-hot-toast'


const ContactForm = () => {

	const handleChange = (e) => {
		setData({ ...data, [e.target.name]: e.target.value })
	}
	const { data, setData, post, processing, errors, reset } = useForm({
		name: "user",
		email: "user@user.com",
		subject: "Lorem ipsum",
		message: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla voluptas ex inventore neque tenetur! Dolor architecto, cum dolore ut quisquam aliquam quidem repellat maxime excepturi, impedit unde eos quos fugiat?"
	})

	function handleSubmit(e) {
		e.preventDefault()
		post(route('contact-form'), {
			preserveScroll: true,
			onSuccess: () => reset(),
		})
	}
	return (
		<div>
			<div>
				<SectionTitle title="Ponerse en contacto"></SectionTitle>

				<div className="mt-5">
					<form className="space-y-5" onSubmit={handleSubmit}>
						<div className="flex  space-x-2">
							<div className="w-1/2 ">
								<label className="text-sm font-medium" htmlFor="name">
									Nombre *
								</label>
								<TextInput value={data.name}
									onChange={e => setData('name', e.target.value)}
									required
									type="text"
									className="w-full mt-1"
									placeholder="Ingrese su nombre"
									name="name"
								/>
							</div>
							<div className="w-1/2">
								<label className="text-sm font-medium" htmlFor="email">
									Email *
								</label>
								<TextInput value={data.email}
									onChange={e => setData('email', e.target.value)}
									required
									type="text"
									className="w-full mt-1"
									placeholder="Ingrese su email"
									name="email"
								/>
							</div>
						</div>
						<div className="">
							<label className="text-sm font-medium" htmlFor="subject">
								Asunto *
							</label>
							<TextInput value={data.subject}
								onChange={e => setData('subject', e.target.value)}
								required
								type="text"
								className="w-full mt-1"
								placeholder="Ingrese el asunto"
								name="subject"
							/>
						</div>
						<div className="">
							<label className="text-sm font-medium block" htmlFor="message">
								Mensaje *
							</label>
							<Textarea
								value={data.message}
								onChange={e => setData('message', e.target.value)} className="w-full mt-1" name="message" id="" rows="5"></Textarea>
						</div>
						<div className="text-right">
							<PrimaryButton disabled={processing}>Enviar Mensaje</PrimaryButton>
						</div>

					</form>
				</div>
			</div></div>
	)
}

export default ContactForm