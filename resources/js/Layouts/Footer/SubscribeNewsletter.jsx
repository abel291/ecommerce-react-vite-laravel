import TextInput from '@/Components/Form/TextInput'
import PrimaryButton from '@/Components/PrimaryButton'
import { useForm } from '@inertiajs/react'
import React from 'react'

const SubscribeNewsletter = () => {

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
        <form onSubmit={handleSubmit} className="flex flex-col lg:flex-row gap-y-2 lg:gap-y-0 gap-x-0 lg:gap-x-3">
            <div className="grow w-full">
                <TextInput
                    onChange={e => setData('email', e.target.value)}
                    type="text"

                    placeholder="Escriba su email aqui"
                    value={data.email}
                    className=""
                />


            </div>
            <PrimaryButton className="justify-center" disabled={processing} isLoading={processing}>Suscribirse</PrimaryButton>
        </form>
    )
}

export default SubscribeNewsletter
