import { Link } from "react-router-dom"
import Suscribe from "../components/Suscribe"

const Footer = () => {
    return (
        <>
            <div className="container py-content">
                <Suscribe />
            </div>

            <footer className="py-content border-t border-gray-100">
                <div className=" container grid grid-cols-2 lg:grid-cols-5 gap-5 lg:gap-3">
                    <div className="col-span-2 space-y-3 lg:pr-5">
                        <div className="flex-shrink-0 flex items-center text-orange-500">
                            <Link to="/">
                                <div className="font-bold text-sx text-xl">
                                    <span className="font-light">Ecommerce</span> React
                                </div>
                            </Link>
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
                        <h4 className="font-semibold text-lg ">Contacto</h4>
                        <div className="mt-2 space-y-2 text-sm font-light">
                            <Link to="/contact-us" className="block">
                                Contacto
                            </Link>
                            <div>example@example.com</div>
                            <div>PO Box 14122 Collins Street West.Victoria</div>
                            <div>+57 311 9588 412</div>
                        </div>
                    </div>

                    <div className="">
                        <h4 className="font-semibold text-lg ">Porque elegirnos</h4>
                        <div className="mt-2 space-y-2 text-sm font-light">
                            <Link to="/shipping-delivery" className="block">
                                Envío y Entrega
                            </Link>
                            <Link to="/return-exchanges" className="block">
                                Devoluciones y cambios
                            </Link>

                            <Link to="/faq" className="block">
                                Preguntas frecuentes y ayudas
                            </Link>
                        </div>
                    </div>

                    <div className="">
                        <h4 className="font-semibold text-lg ">Top Categorias</h4>
                        <div className="mt-2 space-y-2 text-sm font-light">
                            <Link

                                to="/search"
                                state={{ categories: 'teclados' }}
                                className="block"
                            >
                                Teclados
                            </Link>
                            <Link

                                to="/search"
                                state={{ categories: 'mouses' }}
                                className="block"
                            >
                                Mouses
                            </Link>
                            <Link

                                to="/search"
                                state={{ categories: 'procesadores' }}
                                className="block"
                            >
                                Procesadores
                            </Link>
                            <Link

                                to="/search"
                                state={{ categories: 'ram' }}
                                className="block"
                            >
                                Ram
                            </Link>
                            <Link

                                to="/search"
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
