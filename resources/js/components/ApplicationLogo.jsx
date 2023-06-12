import { Link } from "@inertiajs/react";

export default function ApplicationLogo(props) {
	return (
		<Link href="/">
			<div className="text-white sm:text-primary-600 text-xl text-center whitespace-nowrap font-light">
				React <strong className="font-semibold">Ecommerce</strong>
			</div>
		</Link>
	);
}
