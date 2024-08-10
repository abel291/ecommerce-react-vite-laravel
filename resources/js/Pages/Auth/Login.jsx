import { useEffect } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/Form/InputError';
import InputLabel from '@/Components/Form/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/Form/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
	const { data, setData, post, processing, errors, reset } = useForm({
		email: 'user@user.com',
		password: 'password',
		remember: false,
	});

	useEffect(() => {
		return () => {
			reset('password');
		};
	}, []);

	const submit = (e) => {
		e.preventDefault();

		post(route('login'));
	};

	return (
		<GuestLayout title="Iniciar sesión en su cuenta">
			<Head title="Iniciar sesión" />

			{status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

			<form onSubmit={submit}>
				<div>
					<InputLabel htmlFor="email" value="Email" />

					<TextInput
						id="email"
						type="email"
						name="email"
						value={data.email}
						className="mt-1 block w-full"
						autoComplete="username"
						isFocused={true}
						onChange={(e) => setData('email', e.target.value)}
					/>

					<InputError message={errors.email} className="mt-2" />
				</div>

				<div className="mt-4">
					<InputLabel htmlFor="password" value="Contraseña" />

					<TextInput
						id="password"
						type="password"
						name="password"
						value={data.password}
						className="mt-1 block w-full"
						autoComplete="current-password"
						onChange={(e) => setData('password', e.target.value)}
					/>

					<InputError message={errors.password} className="mt-2" />
				</div>

				<div className="flex items-center justify-between mt-8">
					<div>
						<label className="flex items-center">
							<Checkbox
								name="remember"
								checked={data.remember}
								onChange={(e) => setData('remember', e.target.checked)}
							/>
							<span className="ml-2 text-sm text-gray-600 dark:text-gray-400">Acuérdate de mí</span>
						</label>
					</div>

					<div>
						{canResetPassword && (
							<Link
								href={route('password.request')}
								className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800"
							>
								¿Olvidaste tu contraseña?
							</Link>
						)}


					</div>
				</div>
				<div>
					<PrimaryButton className="w-full mt-8 flex justify-center" disabled={processing} isLoading={processing}>
						Iniciar sesión
					</PrimaryButton>
				</div>
			</form>
		</GuestLayout>
	);
}
