export enum recipeStatus {
    DRAFT = 'draft',
    PUBLISHED = 'published',
    UNPUBLISHED = 'unpublished',
}

// Recipe Types
export type recipe = {
    id : number,
    category: recipeCategory,
    title_en: string,
    title_km : string,
    description_en: string,
    description_kh: string,
    image_url : string,
    video_url : string,
    duration : string,
    is_breakfast: boolean,
    ingredients : ingredient[],
    cookingSteps : cookingStep[],
    status: recipeStatus,
}

export type recipeCategory = {
    id : number,
    category_en : string,
    category_km : string,
}

export type cookingStep = {
    id : number,
    step_number : number,
    cooking_instruction_en : string,
    cooking_instruction_km : string,
}


export type ingredient = {
    id : number,
    // recipe : recipes,
    ingredient_name_en : string,
    ingredient_name_km : string,
    ingredient_quantity: string,
    unit_en : string,
    unit_km : string,
    image_url : string,
}
