import { SearchIcon } from "@heroicons/react/solid"
import { ShoppingCartIcon } from "@heroicons/react/outline"
import { Link, NavLink } from "react-router-dom"
import useAuth from "../../../hooks/useAuth"

import CategoryDropdown from "./CategoryDropdown"
import ProfileDropdown from "./ProfileDropdown"

const MenuDesktop = ({ handleSubmitSearch, inputSearchRef }) => {
    const { isLogged } = useAuth()
    return (
        <header className="text-black shadow py-3">
            <div className="container">
                <div className="flex items-center mb-5 w-full">
                    <div className="mr-5">
                        <Link to="/" className=" outline-none">
                            <div className="font-bold text-sx text-xl  text-orange-600">
                                <span className="font-light">Ecommerce</span> React
                            </div>
                        </Link>
                    </div>
                    <div className="w-3/6">
                        <form
                            onSubmit={handleSubmitSearch}
                            className="flex rounded shadow-md bg-white divide-x divide-gray-200 py-1
                            ring-2 ring-orange-500 "
                        >
                            <input
                                ref={inputSearchRef}
                                type="text"
                                name="search"
                                id="search"
                                className="border-none flex-1 block w-full rounded-l sm:text-sm focus:ring-0  px-4 placeholder-gray-400"
                                placeholder="Busca productos, marcas y mas"
                            />
                            <button type="submit" className="inline-flex items-center px-3 rounded-r-md  text-sm text-gray-500">
                                <SearchIcon className="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </div>
                <div className="flex items-center justify-between mt-2 text-sm relative  ">
                    <div className=" flex items-center space-x-10 ">
                        <div>
                            <CategoryDropdown />
                        </div>

                        <NavLink
                            to="/offers"
                            className={({ isActive }) =>
                                isActive ? "border-b-2 border-orange-500" : ""
                            }>
                            Ofetas
                        </NavLink>

                        <NavLink to="/combos"
                            className={({ isActive }) =>
                                isActive ? "border-b-2 border-orange-500" : ""
                            }>
                            Combos
                        </NavLink>

                        <NavLink to="/assemblies"
                            className={({ isActive }) =>
                                isActive ? "border-b-2 border-orange-500" : ""
                            }>

                            Ensambles
                        </NavLink>

                        <NavLink to="/contact-us"
                            className={({ isActive }) =>
                                isActive ? "border-b-2 border-orange-500" : ""
                            }>
                            Contacto
                        </NavLink>
                        {/* <Link to="/">Tienda</Link> */}
                    </div>

                    <div className="flex space-x-3 items-center ">
                        {isLogged ? (
                            <ProfileDropdown />
                        ) : (
                            <>
                                <Link to="/login">Acceder</Link>
                                <Link to="/register">Crear cuenta</Link>
                            </>
                        )}

                        <Link to="/shopping-carts">
                            <ShoppingCartIcon className="w-5 h-5 ml-1 text-orange-500" />
                        </Link>
                    </div>
                </div>
            </div>
        </header>
    )
}

export default MenuDesktop
