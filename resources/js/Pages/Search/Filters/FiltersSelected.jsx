import Badge from "@/Components/Badge";
import { formatCurrency } from "@/Helpers/helpers";
import { AdjustmentsVerticalIcon, XMarkIcon } from "@heroicons/react/24/outline";
import { Link, router, usePage } from "@inertiajs/react";

import { useContext, useEffect, useState } from "react";
import { SearchContext } from "../Search";

const FiltersSelected = ({ data, setData, changeFilterAttributes }) => {
    const form = useContext(SearchContext);
    const { listDepartments, listCategories, listColors, listSizes } = usePage().props;

    const [filtersSelected, setFiltersSelected] = useState({})
    // const [typeCardProduct, setTypeCardProduct] = useState('')

    useEffect(() => {
        let newFiltersSelected = {}

        newFiltersSelected.categories = listCategories.filter((category) => {
            return form.data.categories.includes(category.id.toString())
        })
        newFiltersSelected.departments = listDepartments.filter((department) => {
            return form.data.departments.includes(department.id.toString())
        })

        newFiltersSelected.colors = listColors.filter((color) => {
            return form.data.colors.includes(color.id.toString())
        })
        newFiltersSelected.sizes = listSizes.filter((size) => {
            return form.data.sizes.includes(size.id.toString())
        })

        // newFiltersSelected.attributes = Object.entries(form.data.attributes).map(([attribute_slug, values_selected]) => {

        //     let attribute = listAttributes.find((item) => item.slug == attribute_slug);

        //     attribute.attribute_values = attribute.attribute_values.filter((attribute_value) => {
        //         return values_selected.includes(attribute_value.id.toString())
        //     })
        //     return attribute

        // })

        console.log(newFiltersSelected.colors)

        setFiltersSelected(newFiltersSelected);

    }, []);



    const handleClickRemoveItemFilter = (filterName, value) => {
        let newDepartments = data[filterName].filter((item) => item != value);
        setData(filterName, newDepartments);
    };
    const removeAttribute = (attributeName, value) => {
        let newAttributeValues = { ...data.attributes };
        delete newAttributeValues[attributeName]
        // console.log(newAttributeValues)
        setData('attributes', newAttributeValues)
    };

    return (
        <>
            <div className="flex items-center justify-between ">

                <h3 className="font-medium flex items-center gap-x-1 text-gray-700 ">
                    <AdjustmentsVerticalIcon className="w-5 h-5" />
                    Filtros
                </h3>

                <Link className="text-xs font-light" preserveScroll href={route("search")}>
                    Borrar todo
                </Link>
            </div>

            <div className="flex flex-wrap text-xs gap-2.5 mt-4">
                {data.q && (
                    <Badge color="gray">
                        <span className="mr-2 ">"{data.q}"</span>
                        <button onClick={() => setData("q", "")}>
                            <XMarkIcon className="w-3 h-3" />
                        </button>
                    </Badge>
                )}
                {filtersSelected.departments &&
                    filtersSelected.departments.map((department, index) => (
                        <Badge color="gray" key={"department" + index}>
                            <span className="mr-2 up">{department.name}</span>
                            <button
                                onClick={() => handleClickRemoveItemFilter("departments", department.id)}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))}
                {filtersSelected.categories &&
                    filtersSelected.categories.map((category, index) => (
                        <Badge color="gray" key={"category" + index}>
                            <span className="mr-2 up">{category.name}</span>
                            <button
                                onClick={() => handleClickRemoveItemFilter("categories", category.id)}>
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))}

                {filtersSelected.colors &&
                    filtersSelected.colors.map((color, index) => (
                        <Badge color="gray" key={"color" + index}>
                            <span style={{ background: color.hex }} className="rounded-full size-3 mr-1"></span>
                            <span className="mr-2 up">{color.name}</span>
                            <button
                                onClick={() => handleClickRemoveItemFilter("colors", color.id)}>
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))
                }
                {filtersSelected.sizes &&
                    filtersSelected.sizes.map((size, index) => (
                        <Badge color="gray" key={"size" + index}>

                            <span className="mr-2 up">Talla {size.name}</span>
                            <button
                                onClick={() => handleClickRemoveItemFilter("sizes", size.id)}>
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))
                }


                {filtersSelected.attributes && (
                    filtersSelected.attributes.map((attribute, index) => (
                        attribute.attribute_values.map((value) => (
                            <Badge color="gray" key={"attribute_value" + value.name + index}>
                                <span className="mr-2 up capitalize">
                                    {attribute.name} {value.name}
                                </span>
                                <button onClick={() => removeAttribute(attribute.slug, value.id)}>
                                    <XMarkIcon className="w-3 h-3" />
                                </button>
                            </Badge>
                        ))

                    ))
                )}

                {/* {data.brands.length > 0 &&
                    data.brands.map((item) => (
                        <Badge color='gray' key={item}>
                            <span className="mr-2 up">{item}</span>
                            <button onClick={() => handleClickRemoveFilter("brands", item)}>
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))
                } */}
                {
                    data.price_min && (
                        <Badge color="gray">
                            <span className="mr-2 capitalize">
                                Desde {formatCurrency(data.price_min)}
                            </span>
                            <button
                                onClick={() => setData("price_min", '')}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
                {
                    data.price_max && (
                        <Badge color="gray">
                            <span className="mr-2 capitalize">
                                Hasta {formatCurrency(data.price_max)}
                            </span>
                            <button
                                onClick={() => setData("price_max", '')}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
                {
                    data.sortBy && (
                        <Badge color="gray">
                            <span className="mr-2 capitalize">
                                {data.sortBy == 'price_desc' && 'Precio mayor'}
                                {data.sortBy == 'price_asc' && 'Precio menor'}
                            </span>
                            <button
                                onClick={() => setData("sortBy", null)}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
                {
                    data.offer && (
                        <Badge color="gray">
                            <span className="mr-2 ">
                                Descuentos desde {data.offer}%
                            </span>
                            <button
                                onClick={() => setData("offer", null)}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
            </div>

        </>
    );
};

export default FiltersSelected;
