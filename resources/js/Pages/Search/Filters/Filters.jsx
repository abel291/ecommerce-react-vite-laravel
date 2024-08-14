import React from "react";
import FiltersSelected from "./FiltersSelected";
import { usePage } from "@inertiajs/react";
import FilterButton from "./FilterButton";
import FilterPrice from "./FilterPrice";
import FilterRadio from "./FilterRadio";
import FilterContainer from "./FilterContainer";

import FilterCheckbox from "./FilterCheckbox";
import FilterAttributes from "./FilterAttributes";

const offers = [
    {
        name: "Desde 10%",
        slug: "10",
    },
    {
        name: "Desde 20%",
        slug: "20",
    },
    {
        name: "Desde 30%",
        slug: "30",
    },
    {
        name: "Desde 40%",
        slug: "40",
    },
];
const Filters = ({ data, setData }) => {

    const { listDepartments, listCategories, listAttributes, listBrands } =
        usePage().props;

    const changeFilterCheckbox = (filterName, optionsChecked) => {
        setData(filterName, optionsChecked);
    };

    const changeFilterAttributes = (attributeName, newAttributeValues) => {

        setData("attributes", {
            ...data.attributes,
            [attributeName]: newAttributeValues,
        });
    };

    return (
        <div className="divide-y divide-gray-200 ">

            <div className="pb-5">
                <FiltersSelected
                    data={data}
                    setData={setData}
                    changeFilterAttributes={changeFilterAttributes}
                    changeFilter={changeFilterCheckbox}
                />
            </div>
            {data.departments.length == 0 && (
                <FilterContainer title="Departamentos">
                    <FilterCheckbox
                        optionsList={listDepartments}
                        optionsChecked={data.departments || []}
                        changeFilterCheckbox={changeFilterCheckbox}
                        filterName="departments"
                    />
                </FilterContainer>
            )}
            {data.categories.length == 0 && (
                <FilterContainer title="Categorias">
                    <FilterCheckbox
                        optionsList={listCategories}
                        optionsChecked={data.categories || []}
                        changeFilterCheckbox={changeFilterCheckbox}
                        filterName="categories"
                    />
                </FilterContainer>
            )}

            {listAttributes.map((attribute, key) => (
                !data.attributes[attribute.name] && (
                    <FilterContainer key={key} title={attribute.name}>
                        <FilterCheckbox
                            optionsList={attribute.attribute_values}
                            optionsChecked={
                                (data.attributes && data.attributes[attribute.name]) || []
                            }
                            changeFilterCheckbox={changeFilterAttributes}
                            filterName={attribute.name}
                        />
                    </FilterContainer>
                )
            ))}
            {/*
            <FilterContainer title="Precio">
                <FilterPrice data={data} setData={setData} />
            </FilterContainer>

            <FilterContainer title="Ofertas">
                <FilterRadio
                    options={offers}
                    data={data}
                    setData={setData}
                    filterName="offer"
                />
            </FilterContainer>
            {(listBrands.length > 1) && (
                <FilterContainer title="Marcas">
                    <FilterCheckbox
                        optionsList={listBrands}
                        optionsChecked={data.brands || []}
                        changeFilterCheckbox={changeFilterCheckbox}
                        filterName="brands"
                    />
                </FilterContainer>
            )} */}
        </div>
    );
};

export default Filters;

export const FilterTitle = ({ children }) => {
    return <h3 className="font-medium mb-4 ">{children}</h3>;
};
// export const FilterContainer = ({ title = "", children }) => {
// 	return (
// 		<div className="py-5 max-h-96 mr-5">
// 			<FilterTitle>{title}</FilterTitle>
// 			<div>
// 				{children}
// 			</div>
// 		</div>
// 	)
// }
