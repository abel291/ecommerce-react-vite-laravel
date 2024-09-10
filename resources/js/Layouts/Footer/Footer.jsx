import { Link, usePage } from "@inertiajs/react";
import Suscribe from "./Suscribe";
import ApplicationLogo from "@/Components/ApplicationLogo";
import SocilaMediaIcon from "./SocilaMediaIcon";
import SubscribeNewsletter from "./SubscribeNewsletter";

const Footer = () => {
    const { settings, departments } = usePage().props;

    const footerItems = [
        {
            name: "Contacto",
            links: [
                {
                    title: settings.company.email,
                },
                {
                    title: settings.company.address,
                },
                {
                    title: settings.company.phone,
                },
            ],
        },
        {
            name: "Porque elegirnos",
            links: [
                {
                    title: "Envío y Entrega",
                    path: "/shipping-delivery",
                },
                {
                    title: "Devoluciones y cambios",
                    path: "/return-exchanges",
                },
                {
                    title: "Preguntas frecuentes y ayudas",
                    path: "/faq",
                },
            ],
        },
        {
            name: "Departamentos",
            links: departments.map((department) => ({
                title: department.name,
                path: route("department", department.slug),
            })),
        },
        {
            name: "Enlaces Rápidos",
            links: [
                {
                    title: "Teclados",
                    path: route("search", { "categories[]": "teclados" }),
                },
                {
                    title: "Mouses",
                    path: route("search", { "categories[]": "mouses" }),
                },
                {
                    title: " Procesadores",
                    path: route("search", { "categories[]": "procesadores" }),
                },
                {
                    title: " Ram",
                    path: route("search", { "categories[]": "ram" }),
                },
            ],
        },
    ];
    return (
        <>
            {/* <div className="container py-content">
                <Suscribe />
            </div> */}

            <footer className="pt-content">
                <div className="border-t ">
                    <div className="container   text-sm">
                        <div className="py-8 md:py-10 lg:py-12 xl:py-14 grid grid-cols-2 lg:grid-cols-6 gap-8">
                            {/* <div className="col-span-2 ">
                            <div className="flex-shrink-0 flex items-center text-primary-600">
                                <ApplicationLogo bgIcon="bg-white" colorIcon="text-primary-600" textColor="text-white" />
                            </div>
                            <p className="leading-6 mt-2 lg:mt-5 opacity-80">
                                {settings.company.entry}
                            </p>
                        </div> */}
                            {footerItems.map((item, key) => (
                                <ItemFooter key={key} title={item.name}>
                                    <ul className="space-y-3">
                                        {item.links.map((link, key) => (
                                            <li key={key}>
                                                {link.path ? (
                                                    <Link
                                                        href={link.path}
                                                        className="block hover:opacity-100 opacity-90"
                                                    >
                                                        {link.title}
                                                    </Link>
                                                ) : (
                                                    link.title
                                                )}
                                            </li>
                                        ))}
                                    </ul>
                                </ItemFooter>
                            ))}
                            <ItemFooter
                                title="Suscribite a nuestras promociones"
                                className="col-span-2 "
                            >
                                <div className="space-y-4">
                                    <p className="text-gray-500">
                                        Las últimas noticias, artículos y
                                        recursos, enviados a su bandeja de
                                        entrada semanalmente.
                                    </p>
                                    <SubscribeNewsletter />
                                </div>
                            </ItemFooter>
                        </div>

                        <div className="border-t border-white/10 py-4 text-xs">
                            <div className="flex items-center justify-between text-gray-500 ">
                                <p>
                                    © 2024 {settings.company.name}. All rights
                                    reserved.
                                </p>
                                <SocilaMediaIcon />
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </>
    );
};
export const ItemFooter = ({ title, children, className }) => {
    return (
        <div className={className}>
            <h4 className="mt-2 font-medium">{title}</h4>
            <div className="mt-2 lg:mt-5 ">{children}</div>
        </div>
    );
};

export default Footer;
