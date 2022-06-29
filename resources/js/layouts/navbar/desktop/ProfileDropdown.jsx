import { Menu, Transition } from "@headlessui/react"
import { Fragment } from "react"
import { ChevronDownIcon } from "@heroicons/react/solid"

import { Link } from "react-router-dom"
import useAuth from "../../../hooks/useAuth"
import TextLoadingSpinner from "../../../components/TextLoadingSpinner"
const ProfileDropdown = () => {
    const { user, logout } = useAuth()

    if (logout.isLoading) return <TextLoadingSpinner isLoading={true} />

    return (
        <Menu as="div" className="relative inline-block z-40 ">
            <Menu.Button className="inline-flex items-center rounded-md">
                {user.name}
                <ChevronDownIcon className="w-5 h-5 ml-1 -mr-1 text-violet-200 hover:text-violet-100" aria-hidden="true" />
            </Menu.Button>

            <Transition
                as={Fragment}
                enter="transition ease-out duration-100"
                enterFrom="transform opacity-0 scale-95"
                enterTo="transform opacity-100 scale-100"
                leave="transition ease-in duration-75"
                leaveFrom="transform opacity-100 scale-100"
                leaveTo="transform opacity-0 scale-95"
            >
                <Menu.Items className="absolute right-0 text-sm  w-52 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
                    <div className="">
                        <Menu.Item>
                            <Link to="/my-account" className="px-3 py-3 block hover:bg-gray-50">
                                <div className="flex items-center">
                                    {/* <UserCircleIcon className="h-5 w-5 mr-2"/> */}
                                    <span>Mi cuenta</span>
                                </div>
                            </Link>
                        </Menu.Item>
                        <Menu.Item>
                            <Link to="/my-account/order" className="px-3 py-3 block hover:bg-gray-50">
                                <div className="flex items-center">
                                    {/* <ShoppingBagIcon className="h-5 w-5 mr-2"/> */}
                                    <span>Ordenes</span>
                                </div>
                            </Link>
                        </Menu.Item>
                    </div>
                    <div className="">
                        <Menu.Item>
                            <button
                                onClick={() => {
                                    logout.mutate()
                                }}
                                className="px-3 py-3 block hover:bg-gray-50 w-full text-left"
                            >
                                Salir
                            </button>
                        </Menu.Item>
                    </div>
                </Menu.Items>
            </Transition>
        </Menu>
    )
}

export default ProfileDropdown
