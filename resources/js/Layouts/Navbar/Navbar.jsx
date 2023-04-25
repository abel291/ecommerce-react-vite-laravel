import { MagnifyingGlassIcon, ShoppingBagIcon, ShoppingCartIcon } from '@heroicons/react/24/solid'
import React from 'react'

import { Link } from '@inertiajs/react';

import ProfileDropdown from './ProfileDropdown';
import CategoriesDropdown from './CategoriesDropdown';
import ApplicationLogo from '@/Components/ApplicationLogo';
import DesktopNavbar from './DesktopNavbar';
import MovilNavbar from './MovileNavbar';

export default function Navbar({ auth }) {

	const navigation = [
		{
			name: 'Ofetas',
			href: 'offers'
		},
		{
			name: 'Combos',
			href: 'combos'
		},
		{
			name: 'Ensambles',
			href: 'assemblies'
		},
		{
			name: 'Targeta de regalo',
			href: 'gift-card'
		},
		{
			name: 'Blog',
			href: 'blog'
		},
		{
			name: 'Contactenos',
			href: 'contact'
		},
	]
	return (
		<>
			<MovilNavbar navigation={navigation} />
			<DesktopNavbar navigation={navigation} />
		</>
	)

}
