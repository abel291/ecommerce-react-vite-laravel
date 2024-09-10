import Layout from '@/Layouts/Layout'
import { Head, Link } from '@inertiajs/react'
import React from 'react'

const ErrorPage = ({ status }) => {
    const title = {
        503: '503: Servicio no disponible',
        500: '500: Error del servidor',
        404: '404: Página no encontrada',
        403: '403: Prohibido',
    }[status]

    const description = {
        503: 'Lo sentimos, estamos haciendo algo de mantenimiento. Por favor vuelve pronto.',
        500: 'Vaya, algo salió mal en nuestros servidores.',
        404: 'Lo sentimos, no se pudo encontrar la página que estás buscando.',
        403: 'Lo sentimos, tienes prohibido acceder a esta página.',
    }[status]

    return (
        <main class="grid h-screen place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
            <Head title='ERROR ' />
            <div class="text-center">
                <p class="text-base font-semibold text-primary-600">404</p>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">{title}</h1>
                <p class="mt-6 text-base leading-7 text-gray-600">{description}</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <Link href={route('home')} class="rounded-md bg-primary-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                        Volver al Inincio
                    </Link>
                    <Link href={route('contact')} class="text-sm font-semibold text-gray-900">
                        Contactar con soporte
                        <span aria-hidden="true">&rarr;</span>
                    </Link>
                </div>
            </div>
        </main>
    )
}

export default ErrorPage
