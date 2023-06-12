import { Link, usePage } from "@inertiajs/react"
import Suscribe from "./Suscribe"
import ApplicationLogo from "@/Components/ApplicationLogo"

const Footer = () => {
	const { settings } = usePage().props;
	return (
		<>
			<div className="container py-content">
				<Suscribe />
			</div>

			<footer className="py-content border-t border-gray-100 ">
				<div className="container grid grid-cols-2 lg:grid-cols-5 gap-5">
					<div className="col-span-2 ">
						<div className="flex-shrink-0 flex items-center">

							<ApplicationLogo />

						</div>
						<p className="text-sm leading-relaxed mt-2">
							{settings.company.entry}
						</p>
						<div className="flex items-center space-x-3 mt-5">
							<img className="w-7" src="/img/footer/facebook-icon.png" alt="facebook" />
							<img className="w-7" src="/img/footer/instragam-icon.png" alt="instragam" />
							<img className="w-7" src="/img/footer/twt-icon.png" alt="tw" />
							<img className="w-7" src="/img/footer/ws-icon.png" alt="ws" />
						</div>
					</div>

					<div className="">
						<h4 className="font-medium text-lg  ">Contacto</h4>
						<div className="mt-2 space-y-2 text-sm font-light">
							<Link href="/contact-us" className="block">
								Contacto
							</Link>
							<div>{settings.company.email}</div>
							<div>{settings.company.address}</div>
							<div>{settings.company.phone}</div>
						</div>
					</div>

					<div className="">
						<h4 className="font-medium text-lg  ">Porque elegirnos</h4>
						<div className="mt-2 space-y-2 text-sm font-light">
							<Link href="/shipping-delivery" className="block">
								Envío y Entrega
							</Link>
							<Link href="/return-exchanges" className="block">
								Devoluciones y cambios
							</Link>

							<Link href="/faq" className="block">
								Preguntas frecuentes y ayudas
							</Link>
						</div>
					</div>

					<div className="">
						<h4 className="font-medium text-lg  ">Top Categorias</h4>
						<div className="mt-2 space-y-2 text-sm font-light">
							<Link href={route('search', { 'categories[]': "teclados" })} className="block">
								Teclados
							</Link>
							<Link href={route('search', { 'categories[]': "mouses" })} className="block">
								Mouses
							</Link>
							<Link href={route('search', { 'categories[]': "procesadores" })} className="block">
								Procesadores
							</Link>
							<Link href={route('search', { 'categories[]': "ram" })} className="block">
								Ram
							</Link>
							<Link href={route('search', { 'categories[]': "almacenamiento" })} className="block">
								Ssd
							</Link>
						</div>
					</div>
				</div>
			</footer>
		</>
	)
}

export default Footer
