import { useForm, usePage } from '@inertiajs/react';
import React, { useState } from 'react'
import { createContext, useEffect } from 'react';
export const CheckoutContext = createContext(null);

export default function CheckoutProvider({ children }) {

	const { auth, note } = usePage().props
	const userForm = useForm({
		name: auth.user.name,
		address: auth.user.address,
		phone: auth.user.phone,
		email: auth.user.email,
		city: auth.user.city,
		postalCode: "112233",
		note: note,
		paymentMethodId: null
	})




	return (
		<CheckoutContext.Provider value={{ userForm }}>
			{children}
		</CheckoutContext.Provider>
	)
}
