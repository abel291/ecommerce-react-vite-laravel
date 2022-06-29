import { Popover, Transition } from "@headlessui/react"
import { ChevronDownIcon } from "@heroicons/react/solid"
import { Fragment } from "react"
import { Link } from "react-router-dom"
import SpinnerLoad from "../../../components/SpinnerLoad"
import { useData } from "../../../hooks/useData"

const CategoryDropdown = () => {
    const { isLoading, error, data } = useData()

    if (isLoading) return <SpinnerLoad />

    if (error) return "error"

    return (
        <Popover >
            <Popover.Button>
                <div className="flex items-center font-semibold">
                    <span>Categoria</span>
                    <ChevronDownIcon className="h-5 w-5 ml-1" />
                </div>
            </Popover.Button>

            <Transition
                as={Fragment}
                enter="transition ease-out duration-200"
                enterFrom="opacity-0 translate-y-1"
                enterTo="opacity-100 translate-y-0"
                leave="transition ease-in duration-150"
                leaveFrom="opacity-100 translate-y-0"
                leaveTo="opacity-0 translate-y-1"
            >
                <Popover.Panel className="absolute inset-x-0  z-20 mt-2  max-w-3xl">
                    <div className="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white">
                        <div className="p-4 lg:p-7 grid  grid-cols-2  lg:grid-cols-3 gap-4 lg:gap-5 ">
                            {data.categories.map((category) => (
                                <Popover.Button key={category.id}>
                                    <div>
                                        <Link
                                            to="/search"
                                            state={{ categories: category.slug }}
                                        >
                                            <div className="flex items-center">
                                                <div className="mr-3 w-16 h-16 p-1 bg-gray-200 rounded-lg flex items-center">
                                                    <img src={"/img/categories/" + category.img} className="" alt={category.name} />
                                                </div>
                                                <div className="lg:text-base font-semibold mb-2">{category.name}</div>
                                            </div>
                                        </Link>
                                    </div>
                                </Popover.Button>
                            ))}
                        </div>
                        <div className="p-4 lg:p-7 bg-gray-50 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus-visible:ring focus-visible:ring-orange-500 focus-visible:ring-opacity-50">
                            <Link to="search">
                                <div className="text-right">
                                    <Link to="/search">
                                        <span className="text-sm font-semibold ">Ver todo los productos</span>
                                    </Link>

                                </div>

                            </Link>
                        </div>
                    </div>
                </Popover.Panel>
            </Transition>
        </Popover>
    )
}

export default CategoryDropdown
