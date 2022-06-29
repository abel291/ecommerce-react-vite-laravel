import { Disclosure } from "@headlessui/react"
import { ChevronDownIcon } from "@heroicons/react/outline"
import { Fragment } from "react"
import { NavLink } from "react-router-dom"
import TextLoadingSpinner from "../../../components/TextLoadingSpinner"
import useAuth from "../../../hooks/useAuth"

const ProfileDropdown = ({ closeParent }) => {
    const { user, logout } = useAuth()

    if (logout.isLoading) return <TextLoadingSpinner isLoading={true} />
    return (
        <Disclosure>
            {({ open }) => (
                <>
                    <Disclosure.Button className="text-white  px-3 py-2 rounded-md text-base font-medium flex items-center">
                        <span className="sr-only">Open menu Profile</span>
                        {user.name}
                        <ChevronDownIcon className="block h-4 w-4 ml-1" aria-hidden="true" />
                    </Disclosure.Button>
                    <Disclosure.Panel className="px-3">
                        <NavLink onClick={closeParent} to="/my-account" className="text-white block px-3 py-2 rounded-md text-sm">
                            <span>Mi cuenta</span>
                        </NavLink>

                        <NavLink onClick={closeParent} to="/my-account/order" className="text-white block px-3 py-2 rounded-md text-sm">
                            <span>Ordenes</span>
                        </NavLink>

                        <button
                            onClick={() => {
                                logout.mutate(null, { onSuccess: () => closeParent() })
                            }}
                            className="text-white block px-3 py-2 rounded-md text-sm"
                        >
                            Salir
                        </button>
                    </Disclosure.Panel>
                </>
            )}
        </Disclosure>
    )
}

export default ProfileDropdown
