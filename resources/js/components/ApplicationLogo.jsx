import { Link } from "@inertiajs/react";

export default function ApplicationLogo(className, props) {
	return (
		<Link href="/" >
			<div className={className + " text-xl whitespace-nowrap text-primary-600"}>
				React <strong className="font-semibold">Ecommerce</strong>
			</div>
		</Link>
	);
}
