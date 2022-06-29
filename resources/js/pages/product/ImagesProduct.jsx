import { useRef } from "react"

const ImagesProduct = ({product}) => {
    const imgShowRef = useRef()
    const handleClickImg = (urlImg) => {
        imgShowRef.current.src = urlImg
    }
    return (
        <div className="py-content flex flex-col-reverse md:flex-row   ">
            <div className="w-full md:w-1/5 ">
                <div className="flex flex-row md:flex-col space-x-2 md:space-x-0 md:space-y-2 ">
                    <button
                        onClick={() => handleClickImg("/img/categories/" + product.img)}
                        className="p-1 border border-gray-200 rounded w-16 h-16 flex items-center justify-center"
                    >
                        <img src={"/img/categories/" + product.img} alt={product.slug} className="max-h-full" />
                    </button>
                    {product.images.map((image) => (
                        <button
                            onClick={() => handleClickImg("/img/categories/" + image.img)}
                            key={image.id}
                            className="p-1 border border-gray-200 rounded w-16 h-16 flex items-center justify-center"
                        >
                            <img src={"/img/categories/" + image.img} alt={image.alt} className="max-h-full" />
                        </button>
                    ))}
                </div>
            </div>
            <div className="flex items-center justify-center w-full md:w-4/5  md:p-5 h-96 mb-10 md:mb-0">
                <img ref={imgShowRef} className="object-contain w-full h-full" src={"/img/categories/" + product.img} alt="" />
            </div>
        </div>
    )
}

export default ImagesProduct
