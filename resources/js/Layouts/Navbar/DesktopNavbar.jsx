import { MagnifyingGlassIcon } from '@heroicons/react/24/solid'
import { ChevronDownIcon, ChevronUpDownIcon, ShoppingBagIcon, ShoppingCartIcon } from '@heroicons/react/24/outline'
import React from 'react'

import { Link, useForm, usePage } from '@inertiajs/react';

import ProfileDropdown from './ProfileDropdown';
import DepartmentDropdown from './DepartmentDropdown';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { formatCurrency } from '@/Helpers/helpers';

export default function DesktopNavbar({ navigation }) {

    const { auth, filters, departments, settings } = usePage().props
    const { data, setData, get, processing, errors, reset } = useForm({
        q: filters?.q || null,
    })

    function handleSubmit(e) {
        e.preventDefault()
        get('/search', {
            preserveScroll: true,
            //onSuccess: () => reset('q'),
        })
    }
    return (
        <nav className="border-b  hidden lg:block">
            {settings.rates.freeShipping && (
                <p className="flex h-10 items-center justify-center gradient-primary px-4 text-sm text-white sm:px-6 lg:px-8">
                    Obtenga envío gratuito en pedidos superiores a {formatCurrency(settings.rates.freeShipping)}
                </p>
            )}

            <div className="container pt-4 text-neutral-700 text-sm">
                <div className='relative  grid grid-cols-12 gap-x-5  items-center'>
                    <div className='col-span-3'>
                        <ApplicationLogo />
                    </div>

                    <div className="w-full md:col-span-7 ">
                        <div >
                            <form onSubmit={handleSubmit} className="overflow-hidden border-2 border-primary-600 bg-primary-600 flex rounded-lg shadow-sm">
                                <input
                                    id="search-main"
                                    type="text"
                                    name="q"
                                    onChange={e => setData('q', e.target.value)}
                                    className=" block w-full border-none focus:border-none ring-0 focus:ring-none focus:ring-0  "
                                    autoComplete="search"
                                    required

                                />
                                <button type="submit" className="inline-flex items-center px-3  text-sm text-white ">
                                    <MagnifyingGlassIcon className="w-6 h-6" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div className='h-14 pt-2 flex justify-between items-center '>
                    <div className="flex items-center ">
                        <div >
                            <DepartmentDropdown />
                        </div>
                        <div className='hidden xl:block'>
                            <div className=' ml-5 flex gap-x-4'>
                                {departments.map((item) => (
                                    <LinkNavbar key={item.slug} href={route('department', item.slug)}
                                        active={route().current('department', item.slug)}>
                                        {item.name}
                                    </LinkNavbar>
                                ))}
                                {navigation.map((item, key) => (
                                    <LinkNavbar key={key} href={route(item.href)}
                                        active={route().current(item.href)}>
                                        {item.name}
                                    </LinkNavbar>
                                ))}
                            </div>
                        </div>
                    </div>
                    <div className="flex gap-x-5 items-center ">
                        {auth.user ? (
                            <ProfileDropdown>
                                <button className="inline-flex items-center">
                                    {auth.user.name}
                                    <ChevronUpDownIcon className="w-5 h-5 ml-1 -mr-1 " aria-hidden="true" />
                                </button>
                            </ProfileDropdown>
                        ) : (

                            <>
                                <div className="flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-2">
                                    <Link href={route('login')} className="  hover:">Acceder</Link>
                                    <span className="h-4 w-px bg-neutral-400" aria-hidden="true"></span>
                                    <Link href={route('register')} className="  hover:">Crear cuenta</Link>
                                </div>
                            </>
                        )}

                        <Link href={route('shopping-cart.index')}>
                            <div className='group -m-2 flex items-center p-2'>
                                <ShoppingBagIcon className="h-6 w-6 flex-shrink-0  group-hover:" />
                                <span className="ml-2 text-sm  group-hover:">{auth.shoppingCartCount || 0}</span>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </nav>
    )
}
function LinkNavbar({ children, active, ...props }) {
    return (
        <Link {...props}
            className={
                (active
                    ? 'border-primary-600/50 text-primary-600 font-medium border-b-2'
                    : '') +
                ' whitespace-nowrap block '}>
            {children}
        </Link>
    )
}
