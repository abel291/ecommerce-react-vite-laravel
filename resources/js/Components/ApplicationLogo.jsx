
import { ShoppingCartIcon } from "@heroicons/react/24/solid";
import { Link, usePage } from "@inertiajs/react";


export default function ApplicationLogo({ bgIcon = 'bg-primary-600', colorIcon = 'text-white', textColor = 'text-primary-600' }) {
    const { settings } = usePage().props
    return (
        <Link className="brand flex items-center" href={route('home')}>
            <span className={"flex items-center p-1.5 rounded-full mr-2  " + bgIcon}>
                <ShoppingCartIcon className={'h-7 w-7 ' + colorIcon} />
            </span>
            <span className={"text-2xl font-semibold     " + textColor}>
                {settings.company.name}
            </span>
        </Link>
    );
}


