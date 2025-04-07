// "use client"

import { Filter, LayoutGrid, ListIcon, Plus, Search } from 'lucide-react';
import { useState } from 'react';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { RecipeForm } from './recipes/recipe_form';
import { RecipeTable } from './recipes/recipe_table';
import RecipeGridView from '@/pages/recipes/recipeGridView';
import { recipe, recipeStatus } from '@/pages/recipes/recipe';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import { Head } from '@inertiajs/react';

const recipes: recipe[] = [

    {
        id: 1,
        category: {
            id: 1,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 2,
        category: {
            id: 2,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },


    {
        id: 3,
        category: {
            id: 3,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 1,
        category: {
            id: 1,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 2,
        category: {
            id: 2,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },


    {
        id: 3,
        category: {
            id: 3,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 1,
        category: {
            id: 1,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 2,
        category: {
            id: 2,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },


    {
        id: 3,
        category: {
            id: 3,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 1,
        category: {
            id: 1,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 2,
        category: {
            id: 2,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },


    {
        id: 3,
        category: {
            id: 3,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 1,
        category: {
            id: 1,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

    {
        id: 2,
        category: {
            id: 2,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },


    {
        id: 3,
        category: {
            id: 3,
            category_en: 'Pasta',
            category_km: 'ប៉ាស្តា',
        },
        title_en: 'Spaghetti Carbonara',
        title_km: 'ស្ពាហ្គេទី Carbonara',
        description_en: 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
        description_kh: 'មីអ៊ីតាលីបែបបុរាណដែលធ្វើពីស៊ុប, ប៊ឺរី, ប៉ាន់សេតា និងម្ទេស។',
        image_url: 'https://i.pinimg.com/736x/f1/74/b3/f174b346ed028cbfea9093cabc1e5a7d.jpg',
        video_url: '',
        duration: '20 mins',
        is_breakfast: false,
        ingredients: [
            {
                id: 1,
                ingredient_name_en: 'Spaghetti',
                ingredient_name_km: 'ស្ពាហ្គេទី',
                ingredient_quantity: '200g',
                unit_en: 'grams',
                unit_km: 'ក្រាម',
                image_url: '',
            },
            {
                id: 2,
                ingredient_name_en: 'Eggs',
                ingredient_name_km: 'ពងមាន់',
                ingredient_quantity: '2',
                unit_en: 'pieces',
                unit_km: 'ដុំ',
                image_url: '',
            },
        ],
        cookingSteps: [
            {
                id: 1,
                step_number: 1,
                cooking_instruction_en: 'Boil the spaghetti.',
                cooking_instruction_km: 'ចំហុយស្ពាហ្គេទី។',
            },
            {
                id: 2,
                step_number: 2,
                cooking_instruction_en: 'Fry the pancetta.',
                cooking_instruction_km: 'ចំហុយប៉ាន់សេតា។',
            },
        ],
        status: recipeStatus.PUBLISHED,
    },

];

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/',
    },
    {
        title: 'Recipes',
        href: '/recipes',
    }
]

export default function RecipePage() {
    const [isCreateModalOpen, setIsCreateModalOpen] = useState(false);
    const [isGridView, setIsGridView] = useState(false);
    function handleLayoutchange() {
        setIsGridView(!isGridView);
    }
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Recipes"/>
            <div className="flex min-h-screen w-full">
                <div className="flex flex-1 flex-col">
                    <header className="bg-background sticky top-0 z-10 flex h-16 items-center gap-4 border-b px-6">
                        <h1 className="text-xl font-semibold">Recipe Management</h1>
                    </header>
                    {
                        <main className="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-8">
                            <div className="flex items-center justify-between">
                                <div className="flex items-center gap-2">
                                    <div className="relative">
                                        <Search className="text-muted-foreground absolute top-2.5 left-2.5 h-4 w-4" />
                                        <Input type="search" placeholder="Search recipes..." className="w-full rounded-lg pl-8 md:w-[300px]" />
                                    </div>
                                    <Tooltip>
                                        <TooltipTrigger asChild>
                                            <Button variant="outline" size="icon">
                                                <Filter className="h-4 w-4" />
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>Filter</p>
                                        </TooltipContent>
                                    </Tooltip>

                                    <Tooltip>
                                        <TooltipTrigger asChild>
                                            <Button variant="outline" size="icon"  onClick={() => handleLayoutchange()} >
                                                {isGridView ? (
                                                    <ListIcon className="h-4 w-4" />
                                                ): <LayoutGrid className="h-4 w-4" />}
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent>
                                            <p>{isGridView ? "Grid View" : "List View"}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </div>
                                <Button onClick={() => setIsCreateModalOpen(true)}>
                                    <Plus className="mr-2 h-4 w-4" />
                                    Add Recipe
                                </Button>
                            </div>
                            {isGridView ? (<RecipeGridView recipe={recipes}/>
                             ) : (<RecipeTable recipes={recipes}/>)}
                        </main>
                    }
                </div>
                <RecipeForm open={isCreateModalOpen} onOpenChange={setIsCreateModalOpen} title="Create New Recipe" />
            </div>
        </AppLayout>
    );
}
