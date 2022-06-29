/* This example requires Tailwind CSS v2.0+ */
import { Fragment } from "react"
import { Disclosure, Transition } from "@headlessui/react"
import { MenuIcon, ShoppingCartIcon, XIcon } from "@heroicons/react/outline"
import { Link, NavLink } from "react-router-dom"
import ProfileDropdown from "./ProfileDropdown"
import CategoryDropdown from "./CategoryDropdown"
import useAuth from "../../../hooks/useAuth"

const navigation = [
    { name: "Ofetas", to: "offers" },
    { name: "Combos", to: "combos" },
    { name: "Ensambles", to: "assemblies" },
    { name: "Contacto", to: "contact-us" },
]

export default function MenuMovil() {
    const { isLogged } = useAuth()
    return (
        <Disclosure as="nav" className="bg-orange-500 shadow text-white">
            {({ open, close: closeParent }) => (
                <>
                    <div className="max-w-7xl mx-auto px-2 ">
                        <div className="relative flex items-center justify-between h-16">
                            <div className="absolute inset-y-0 left-0 flex items-center">
                                {/* Mobile menu button*/}
                                <Disclosure.Button className="inline-flex items-center justify-center p-2 rounded-md hover:text-white hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                    <span className="sr-only">Open main menu</span>
                                    {open ? (
                                        <XIcon className="block h-7 w-7" aria-hidden="true" />
                                    ) : (
                                        <MenuIcon className="block h-7 w-7" aria-hidden="true" />
                                    )}
                                </Disclosure.Button>
                            </div>
                            <div className="flex-1 flex items-center justify-center">
                                <div className="flex-shrink-0 flex items-center">
                                    <Link to="/">
                                        <div className="font-bold text-sx text-xl">
                                            <span className="font-light">Ecommerce</span> React
                                        </div>
                                    </Link>
                                </div>
                            </div>
                            <div className="absolute inset-y-0 right-0 flex items-center pr-2">
                                <NavLink to="/shopping-carts"
                                    className={({ isActive }) =>
                                    ("rounded-full  p-2 " +
                                        isActive
                                        ? "border-b-2 border-orange-500"
                                        : ""
                                    )
                                    }>

                                    <ShoppingCartIcon className="h-6 w-6" />
                                </NavLink>
                                {/* Profile dropdown */}
                                {/* <ProfileDropdown /> */}
                            </div>
                        </div>
                    </div>
                    <Transition
                        enter="transition duration-100 ease-out"
                        enterFrom="transform scale-95 opacity-0"
                        enterTo="transform scale-100 opacity-100"
                        leave="transition duration-75 ease-out"
                        leaveFrom="transform scale-100 opacity-100"
                        leaveTo="transform scale-95 opacity-0"
                    >
                        <Disclosure.Panel>
                            <div className="px-2 pt-2 pb-3 space-y-1">
                                <>
                                    {navigation.map((item) => (
                                        <NavLink
                                            onClick={closeParent}
                                            key={item.to}
                                            to={item.to}
                                            className={({ isActive }) =>
                                                    ("text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-400 " + isActive 
                                                    ? "bg-orange-600 hover:bg-orange-600" 
                                                    : ""
                                                    )}
                                        >
                                            {item.name}
                                        </NavLink>
                                    ))}
                                    <CategoryDropdown closeParent={closeParent} />

                                    <div>
                                        {isLogged ? (
                                            <ProfileDropdown closeParent={closeParent} />
                                        ) : (
                                            <div className=" flex items-center">
                                                <NavLink
                                                    onClick={closeParent}
                                                    to="/login"

                                                    className={({ isActive }) =>
                                                    ("text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-400 " + isActive
                                                        ? "bg-orange-600 hover:bg-orange-600"
                                                        : ""
                                                    )}
                                                >

                                                    Acceder
                                                </NavLink>
                                                <NavLink
                                                    onClick={closeParent}
                                                    to="/register"
                                                    className={({ isActive }) =>
                                                    ("text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-400 " + isActive
                                                        ? "bg-orange-600 hover:bg-orange-600"
                                                        : ""
                                                    )}
                                                >
                                                    Crear cuenta
                                                </NavLink>
                                            </div>
                                        )}
                                    </div>
                                </>
                            </div>
                        </Disclosure.Panel>
                    </Transition>
                </>
            )
            }
        </Disclosure >
    )
}
