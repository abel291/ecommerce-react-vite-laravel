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

			<footer className=" border-t border-gray-100 ">
				<div className="container  ">
					<div className="py-content grid grid-cols-2 lg:grid-cols-5 gap-8">
						<div className="col-span-2 ">
							<div className="flex-shrink-0 flex items-center text-primary-600">

								<ApplicationLogo />

							</div>
							<p className="text-sm leading-6 mt-2 text-gray-600">
								{settings.company.entry}
							</p>
						</div>

						<div className="text-sm">
							<Link href="/contact-us" className="block">
								<h4 className="font-medium ">
									Contacto
								</h4>
							</Link>
							<div className="mt-2 space-y-2 text-sm font-light">
								<div>{settings.company.email}</div>
								<div>{settings.company.address}</div>
								<div>{settings.company.phone}</div>
							</div>
						</div>

						<div className="text-sm">
							<h4 className="font-medium ">
								Porque elegirnos
							</h4>
							<h4 className="font-medium text-lg  "></h4>
							<div className="mt-2 space-y-2 font-light">
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

						<div className="text-sm">
							<h4 className="font-medium  ">Top Categorias</h4>
							<div className="mt-2 space-y-2  font-light">
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
								{/* <Link href={route('search', { 'categories[]': "almacenamiento" })} className="block">
									Ssd
								</Link> */}
							</div>
						</div>
					</div>
					<div className="border-t py-6">
						<div className="flex items-center justify-between text-sm text-gray-500">
							<p>
								© 2020 {settings.company.name}. All rights reserved.
							</p>
							<div className="flex items-center gap-5">
								<a href={settings.social.facebook} target="_blank">
									<img className="w-6 transition hover:scale-110" src="/img/footer/facebook-icon.png" alt="facebook" />
								</a>
								<a href={settings.social.instagram} target="_blank">
									<img className="w-6 transition hover:scale-110" src="/img/footer/instagram-icon.png" alt="instagram" />
								</a>
								<a href={settings.social.twitter} target="_blank">
									<img className="w-6 transition hover:scale-110" src="/img/footer/twt-icon.png" alt="tw" />
								</a>
								<a href={settings.social.ws} target="_blank">
									<img className="w-6 transition hover:scale-110" src="/img/footer/ws-icon.png" alt="ws" />
								</a>
							</div>
						</div>
					</div>
				</div>

			</footer>
		</>
	)
}

export default Footer
