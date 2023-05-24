import React from 'react'
import DesktopNavbar from './DesktopNavbar';

import MovileNavbar from './MovileNavbar/MovileNavbar';
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
			<MovileNavbar navigation={navigation} />
			<DesktopNavbar navigation={navigation} />
		</>
	)

}
