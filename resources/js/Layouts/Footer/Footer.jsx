import { Link } from "@inertiajs/react"
import Suscribe from "./Suscribe"
import ApplicationLogo from "@/Components/ApplicationLogo"

const Footer = () => {
	return (
		<>
			<div className="container py-content">
				<Suscribe />
			</div>

			<footer className="py-content border-t border-gray-100 ">
				<div className="container grid grid-cols-2 lg:grid-cols-5 gap-5 lg:gap-3">
					<div className="col-span-2 space-y-3 lg:pr-5">
						<div className="flex-shrink-0 flex items-center">

							<ApplicationLogo />

						</div>
						<p className="text-sm leading-relaxed">
							La empresa de tecnología líder en comercio electrónico y soluciones fintech de América Latina. Nuestro propósito
							es democratizar el comercio y los servicios financieros para transformar la vida de millones de personas en la
							región.
						</p>
						<div className="flex items-center  space-x-3">
							<img className="w-7" src="/img/footer/facebook-icon.png" alt="facebook" />
							<img className="w-7" src="/img/footer/instragam-icon.png" alt="instragam" />
							<img className="w-7" src="/img/footer/twt-icon.png" alt="tw" />
							<img className="w-7" src="/img/footer/ws-icon.png" alt="ws" />
						</div>
					</div>

					<div className="">
						<h4 className="font-semibold text-lg  ">Contacto</h4>
						<div className="mt-2 space-y-2 text-sm font-light">
							<Link href="/contact-us" className="block">
								Contacto
							</Link>
							<div>example@example.com</div>
							<div>PO Box 14122 Collins Street West.Victoria</div>
							<div>+57 311 9588 412</div>
						</div>
					</div>

					<div className="">
						<h4 className="font-semibold text-lg  ">Porque elegirnos</h4>
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
						<h4 className="font-semibold text-lg  ">Top Categorias</h4>
						<div className="mt-2 space-y-2 text-sm font-light">
							<Link

								href="/search"
								state={{ categories: 'teclados' }}
								className="block"
							>
								Teclados
							</Link>
							<Link

								href="/search"
								state={{ categories: 'mouses' }}
								className="block"
							>
								Mouses
							</Link>
							<Link

								href="/search"
								state={{ categories: 'procesadores' }}
								className="block"
							>
								Procesadores
							</Link>
							<Link

								href="/search"
								state={{ categories: 'ram' }}
								className="block"
							>
								Ram
							</Link>
							<Link

								href="/search"
								state={{ categories: 'almacenamiento' }}
								className="block"
							>
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
