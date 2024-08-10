
import { ChevronDownIcon } from '@heroicons/react/24/solid'
import { Link, usePage } from '@inertiajs/react'
import { Fragment } from 'react'
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/react'

export default function DepartmentDropdown() {
    const { departments } = usePage().props
    return (
        <Popover>
            <PopoverButton className="focus:ring-0 focus:border-none focus:outline-none">
                <div className="flex items-center">
                    <span>Categorias</span>
                    <ChevronDownIcon className="h-4 w-4 ml-1" />
                </div>
            </PopoverButton >


            <PopoverPanel transition

                className="absolute inset-x-0 z-20 mt-5 max-w-3xl w-full transition duration-200 ease-in-out [--anchor-gap:var(--spacing-5)] data-[closed]:-translate-y-1 data-[closed]:opacity-0" >
                {({ close }) => (
                    <div className="overflow-hidden w-full rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white">
                        <div className="p-4 lg:p-7 flex flex-wrap gap-4 lg:gap-8 ">
                            {departments.map((department, index) => (
                                <div key={index}>
                                    <div className="flex items-start text-sm">
                                        <div className='grow '>
                                            <Link href={route('department', department.slug)} onClick={close}
                                                className='flex items-center gap-x-1 '>
                                                {/* <img src={department.icon} className='w-5' /> */}
                                                <p id="Clothing-heading" class="font-medium text-gray-900">{department.name}</p>

                                            </Link>
                                            <ul className='grid grid-cols-1 mt-3'>
                                                <li>
                                                    {department.categories.map((category) => (
                                                        <Link key={category.id}
                                                            href={route('search', { 'categories[]': category.slug, 'departments[]': department.slug })} onClick={close}
                                                            className='text-left flex py-1 items-center font-normal text-gray-500 hover:text-gray-800'>

                                                            {category.name}
                                                        </Link>
                                                    ))}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>



                                </div>
                            ))}
                        </div>
                        <div className="p-4 lg:p-5 bg-neutral-50 transition duration-150 ease-in-out hover:bg-neutral-100 focus:outline-none focus-visible:ring ">
                            <div className="text-right">
                                <Link to="/search">
                                    <span className="text-sm font-medium ">Ver todo los productos</span>
                                </Link>

                            </div>
                        </div>
                    </div>
                )}
            </PopoverPanel>


        </Popover >
    )
}
