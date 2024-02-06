
import { ShoppingCartIcon } from "@heroicons/react/24/solid";
import { Link } from "@inertiajs/react";

export default function ApplicationLogo(className, props) {
    return (
        <Link href="/" >
            <div className="flex items-center gap-x-3">
                <div className="rounded-full h-8 w-8 p-1.5 bg-primary-600">
                    <ShoppingCartIcon className="w-full h-full text-white" />
                </div>
                <div className="text-primary-600 text-lg text-center whitespace-nowrap font-semibold">
                    RectEcom
                </div>
            </div>
        </Link >
    );
}
