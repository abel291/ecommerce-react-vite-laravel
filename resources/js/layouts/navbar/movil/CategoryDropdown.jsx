import { Disclosure } from "@headlessui/react"
import { ChevronDownIcon } from "@heroicons/react/outline"
import { NavLink } from "react-router-dom"
import SpinnerLoad from "../../../components/SpinnerLoad"
import { useData } from "../../../hooks/useData"

const CategoryDropdown = ({ closeParent }) => {

    const { isLoading, error, data } = useData()

    if (isLoading) return <SpinnerLoad />

    if (error) return "error"
    return (
        <Disclosure className="">
            {({ open }) => (
                <>
                    <Disclosure.Button className="text-white  px-3 py-2 rounded-md text-base font-medium flex items-center">
                        <span className="sr-only">Open menu categories</span>
                        Categories
                        <ChevronDownIcon className="block h-4 w-4 ml-1" aria-hidden="true" />
                    </Disclosure.Button>

                    <Disclosure.Panel className="px-3">
                        {data.categories.map((category) => (
                            <NavLink
                                to="/search"
                                state={{ categories: category.slug }}
                                onClick={closeParent}
                            >
                                <div className="text-white block px-3 py-2 rounded-md text-sm">{category.name}</div>
                            </NavLink>
                        ))}
                    </Disclosure.Panel>
                </>
            )}
        </Disclosure>
    )
}

export default CategoryDropdown
