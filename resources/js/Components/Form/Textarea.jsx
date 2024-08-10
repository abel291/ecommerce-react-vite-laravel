import React from 'react'

export default function Textarea({ className = '', children, ...props }) {
	return (
		<textarea
			{...props}
			className={
				'input-textarea ' +
				className
			}>

			{children}</textarea>
	)
}
