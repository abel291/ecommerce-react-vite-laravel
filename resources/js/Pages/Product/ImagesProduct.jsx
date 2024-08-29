import { useRef } from "react"

const ImagesProduct = ({ product }) => {
    const imgShowRef = useRef()
    const handleClickImg = (urlImg) => {
        imgShowRef.current.src = urlImg
    }

    const allImages = [{
        id: 'principal-image',
        alt: product.variant.slug,
        img: product.variant.img,
    }, ...product.variant.images]
    return (
        <div className="flex  gap-x-4">

            <div className="space-y-4">

                {allImages.map((image) => (
                    <button
                        onClick={() => handleClickImg(image.img)}
                        key={image.id}
                        className="w-28  flex justify-center items-center "
                    >
                        <img src={image.img} alt={image.alt} className="max-h-full object-contain rounded-sm" />
                    </button>
                ))}
            </div>
            <div>
                <img ref={imgShowRef} className="w-full max-w-full rounded-sm" src={allImages[0].img} alt="" />
            </div>

        </div>
    )
}

export default ImagesProduct
