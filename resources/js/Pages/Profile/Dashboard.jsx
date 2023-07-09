import { Head, Link } from "@inertiajs/react"
import LayoutProfile from "../../Layouts/LayoutProfile"



const Dashboard = () => {
	//let { url } = useMatch()

	return (
		<LayoutProfile title="Dashboard" breadcrumb={[
			{
				title: "Incio",
				path: route("profile.index")

			},
		]}>
			<Head title="Perfil" />
			<div className="space-y-2">

				<div>
					Desde el panel de control de su cuenta, puede ver sus , administrar los
					<Link href={route('profile.orders')} className="font-bold underline px-1 ">
						pedidos recientes
					</Link>
					, administrar los
					<Link href={route('profile.account-details')} className="font-bold underline px-1 ">
						detalles de su cuenta
					</Link>
					y
					<Link href={route('profile.password')} className="font-bold underline px-1 ">
						cambiar su contraseña.
					</Link>
					.
				</div>
			</div>
		</LayoutProfile >
	)
}

export default Dashboard
