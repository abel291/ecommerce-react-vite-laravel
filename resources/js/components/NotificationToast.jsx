import { usePage } from '@inertiajs/react';
import toast, { Toaster } from 'react-hot-toast';
import { useEffect } from 'react';
const NotificationToast = () => {
	const { flash } = usePage().props
	useEffect(() => {
		flash.success && toast.success(flash.success);
		flash.error && toast.error(flash.error);

	}, [flash])


	return (
		<div>
			<Toaster
				position="top-right"
				reverseOrder={true}
				toastOptions={{
					success: {
						duration: 10000,

					}
				}}
			/>
		</div>
	)
}

export default NotificationToast