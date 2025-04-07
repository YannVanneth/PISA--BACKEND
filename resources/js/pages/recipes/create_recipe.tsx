"use client"

import type React from "react"

import { useState } from "react"
import { Video, Plus, Trash2, Check } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Switch } from "@/components/ui/switch"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"

import { RecipePreview } from "@/components/recipe_preview"
import { recipe, recipeStatus, ingredient, cookingStep, recipeCategory } from './recipe';
import AppLayout from '@/layouts/app-layout';


const categories : recipeCategory[]= [
    { id: 1, category_en: "Dessert", category_km: "ម្ហូបផ្អែម" },
    { id: 2, category_en: "Main Course", category_km: "ម្ហូបសំខាន់" },
    { id: 3, category_en: "Appetizer", category_km: "ម្ហូបអាហារកន្លែង" },
]
export default function RecipeCreationForm() {
    // Form state
    const [title_en, setTitleEn] = useState("")
    const [title_km, setTitleKm] = useState("")
    const [description_en, setDescriptionEn] = useState("")
    const [description_kh, setDescriptionKh] = useState("")
    const [category_id, setCategoryId] = useState<number>(1)
    const [duration, setDuration] = useState("")
    const [is_breakfast, setIsBreakfast] = useState(false)
    const [status, setStatus] = useState<recipeStatus>(recipeStatus.DRAFT)
    const [image_url, setImageUrl] = useState("https://i.pinimg.com/736x/72/d9/af/72d9af964d384fc2a16fd087c1062a7c.jpg")
    const [video_url, setVideoUrl] = useState("")

    // Ingredients state
    const [ingredients, setIngredients] = useState<Omit<ingredient, "id">[]>([
        {
            ingredient_name_en: "",
            ingredient_name_km: "",
            ingredient_quantity: "",
            unit_en: "",
            unit_km: "",
            image_url: "",
        },
    ])

    // Cooking steps state
    const [cookingSteps, setCookingSteps] = useState<Omit<cookingStep, "id">[]>([
        {
            step_number: 1,
            cooking_instruction_en: "",
            cooking_instruction_km: "",
        },
    ])

    // Get selected category
    const selectedCategory = categories.find((cat) => cat.id === category_id) || categories[0]

    // Handlers for ingredients
    const handleAddIngredient = () => {
        setIngredients([
            ...ingredients,
            {
                ingredient_name_en: "",
                ingredient_name_km: "",
                ingredient_quantity: "",
                unit_en: "",
                unit_km: "",
                image_url: "",
            },
        ])
    }

    const handleRemoveIngredient = (index: number) => {
        const newIngredients = [...ingredients]
        newIngredients.splice(index, 1)
        setIngredients(newIngredients)
    }

    const handleIngredientChange = (index: number, field: keyof Omit<ingredient, "id">, value: string) => {
        const newIngredients = [...ingredients]
        newIngredients[index] = {
            ...newIngredients[index],
            [field]: value,
        }
        setIngredients(newIngredients)
    }

    // Handlers for cooking steps
    const handleAddStep = () => {
        setCookingSteps([
            ...cookingSteps,
            {
                step_number: cookingSteps.length + 1,
                cooking_instruction_en: "",
                cooking_instruction_km: "",
            },
        ])
    }

    const handleRemoveStep = (index: number) => {
        const newSteps = [...cookingSteps]
        newSteps.splice(index, 1)

        // Renumber steps
        const renumberedSteps = newSteps.map((step, idx) => ({
            ...step,
            step_number: idx + 1,
        }))

        setCookingSteps(renumberedSteps)
    }

    const handleStepChange = (index: number, field: keyof Omit<cookingStep, "id" | "step_number">, value: string) => {
        const newSteps = [...cookingSteps]
        newSteps[index] = {
            ...newSteps[index],
            [field]: value,
        }
        setCookingSteps(newSteps)
    }

    // Image upload handler
    const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0]
        if (file) {
            const reader = new FileReader()
            reader.onload = (e) => {
                setImageUrl(e.target?.result as string)
            }
            reader.readAsDataURL(file)
        }
    }

    // Form submission
    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault()

        // Create recipe object
        const recipeData: Omit<recipe, "id"> = {
            category: selectedCategory,
            title_en,
            title_km,
            description_en,
            description_kh,
            image_url,
            video_url,
            duration,
            is_breakfast,
            ingredients: ingredients.map((ing, idx) => ({ ...ing, id: idx + 1 })),
            cookingSteps: cookingSteps.map((value, index) => ({
                id : index + 1,
                step_number: value.step_number,
                cooking_instruction_en: value.cooking_instruction_en,
                cooking_instruction_km: value.cooking_instruction_km,
            })),
            status,
        }

        console.log(recipeData)
        alert("Recipe submitted successfully!")
    }

    // Preview data
    const previewData = {
        title: title_en,
        description: description_en,
        category: selectedCategory.category_en,
        duration,
        is_breakfast,
        image_url,
    }

    const breadcrumbs = [
        {
            title: 'Dashboard',
            href: '/',
        },
        {
            title: 'Recipes',
            href: '/recipes',
        },
        {
            title: 'Create Recipe',
            href: '/recipes/create',
        },
    ]

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <div className="grid md:grid-cols-2 gap-8 px-4">
                <Tabs defaultValue="details" className="w-full">
                    <TabsList className="grid grid-cols-4 mb-4">
                        <TabsTrigger value="details">Details</TabsTrigger>
                        <TabsTrigger value="ingredients">Ingredients</TabsTrigger>
                        <TabsTrigger value="steps">Steps</TabsTrigger>
                        <TabsTrigger value="media">Media</TabsTrigger>
                    </TabsList>

                    <form onSubmit={handleSubmit}>
                        <TabsContent value="details" className="space-y-4">
                            <div className="space-y-2">
                                <Label htmlFor="category">Category</Label>
                                <Select value={category_id.toString()} onValueChange={(value) => setCategoryId(Number.parseInt(value))}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select category" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {categories.map((category) => (
                                            <SelectItem key={category.id} value={category.id.toString()}>
                                                {category.category_en}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="title_en">Recipe Title (English)</Label>
                                <Input
                                    id="title_en"
                                    placeholder="Enter recipe title in English"
                                    value={title_en}
                                    onChange={(e) => setTitleEn(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="title_km">Recipe Title (Khmer)</Label>
                                <Input
                                    id="title_km"
                                    placeholder="បញ្ចូលចំណងជើងរូបមន្តជាភាសាខ្មែរ"
                                    value={title_km}
                                    onChange={(e) => setTitleKm(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="description_en">Description (English)</Label>
                                <Textarea
                                    id="description_en"
                                    placeholder="Describe your recipe in English"
                                    value={description_en}
                                    onChange={(e) => setDescriptionEn(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="description_kh">Description (Khmer)</Label>
                                <Textarea
                                    id="description_kh"
                                    placeholder="ពិពណ៌នាអំពីរូបមន្តរបស់អ្នកជាភាសាខ្មែរ"
                                    value={description_kh}
                                    onChange={(e) => setDescriptionKh(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <div className="space-y-2">
                                    <Label htmlFor="duration">Cooking Time (minutes)</Label>
                                    <Input
                                        id="duration"
                                        type="number"
                                        placeholder="30"
                                        value={duration}
                                        onChange={(e) => setDuration(e.target.value)}
                                        required
                                    />
                                </div>

                                <div className="space-y-2 flex flex-col">
                                    <Label htmlFor="is_breakfast" className="mb-2">
                                        Breakfast Recipe
                                    </Label>
                                    <div className="flex items-center space-x-2">
                                        <Switch id="is_breakfast" checked={is_breakfast} onCheckedChange={setIsBreakfast} />
                                        <Label htmlFor="is_breakfast" className="cursor-pointer">
                                            {is_breakfast
                                                ? "Yes, it's a breakfast recipe"
                                                : "No, it's not a breakfast recipe"}
                                        </Label>
                                    </div>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="status">Recipe Status</Label>
                                <Select value={status} onValueChange={(value) => setStatus(value as recipeStatus)}>
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value={recipeStatus.DRAFT}>Draft</SelectItem>
                                        <SelectItem value={recipeStatus.PUBLISHED}>Published</SelectItem>
                                        <SelectItem value={recipeStatus.UNPUBLISHED}>Unpublished</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </TabsContent>

                        <TabsContent value="ingredients" className="space-y-4">
                            <div className="space-y-6">
                                {ingredients.map((ingredient, index) => (
                                    <div key={index} className="p-4 border rounded-lg space-y-4">
                                        <div className="flex justify-between items-center">
                                            <h3 className="font-medium">
                                                Ingredient #{index + 1}
                                            </h3>
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                onClick={() => handleRemoveIngredient(index)}
                                                disabled={ingredients.length === 1}
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </div>

                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div className="space-y-2">
                                                <Label htmlFor={`ingredient_name_en-${index}`}>Name (English)</Label>
                                                <Input
                                                    id={`ingredient_name_en-${index}`}
                                                    placeholder="e.g., Flour"
                                                    value={ingredient.ingredient_name_en}
                                                    onChange={(e) => handleIngredientChange(index, "ingredient_name_en", e.target.value)}
                                                    required
                                                />
                                            </div>

                                            <div className="space-y-2">
                                                <Label htmlFor={`ingredient_name_km-${index}`}>Name (Khmer)</Label>
                                                <Input
                                                    id={`ingredient_name_km-${index}`}
                                                    placeholder="ឧ. មេសៅ"
                                                    value={ingredient.ingredient_name_km}
                                                    onChange={(e) => handleIngredientChange(index, "ingredient_name_km", e.target.value)}
                                                    required
                                                />
                                            </div>
                                        </div>

                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div className="space-y-2">
                                                <Label htmlFor={`ingredient_quantity-${index}`}>Quantity</Label>
                                                <Input
                                                    id={`ingredient_quantity-${index}`}
                                                    placeholder="e.g., 2"
                                                    value={ingredient.ingredient_quantity}
                                                    onChange={(e) => handleIngredientChange(index, "ingredient_quantity", e.target.value)}
                                                    required
                                                />
                                            </div>

                                            <div className="space-y-2">
                                                <Label htmlFor={`unit_en-${index}`}>Unit (English)</Label>
                                                <Input
                                                    id={`unit_en-${index}`}
                                                    placeholder="e.g., cups"
                                                    value={ingredient.unit_en}
                                                    onChange={(e) => handleIngredientChange(index, "unit_en", e.target.value)}
                                                    required
                                                />
                                            </div>

                                            <div className="space-y-2">
                                                <Label htmlFor={`unit_km-${index}`}>Unit (Khmer)</Label>
                                                <Input
                                                    id={`unit_km-${index}`}
                                                    placeholder="ឧ. ពែង"
                                                    value={ingredient.unit_km}
                                                    onChange={(e) => handleIngredientChange(index, "unit_km", e.target.value)}
                                                    required
                                                />
                                            </div>
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor={`ingredient_image-${index}`}>Ingredient Image URL</Label>
                                            <Input
                                                id={`ingredient_image-${index}`}
                                                placeholder="https://example.com/image.jpg"
                                                value={ingredient.image_url}
                                                onChange={(e) => handleIngredientChange(index, "image_url", e.target.value)}
                                            />
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <Button type="button" variant="outline" onClick={handleAddIngredient} className="w-full">
                                <Plus className="mr-2 h-4 w-4" /> Add Ingredient
                            </Button>
                        </TabsContent>

                        <TabsContent value="steps" className="space-y-4">
                            <div className="space-y-6">
                                {cookingSteps.map((step, index) => (
                                    <div key={index} className="p-4 border rounded-lg space-y-4">
                                        <div className="flex justify-between items-center">
                                            <h3 className="font-medium">
                                                Step #{step.step_number}
                                            </h3>
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                onClick={() => handleRemoveStep(index)}
                                                disabled={cookingSteps.length === 1}
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor={`cooking_instruction_en-${index}`}>
                                                Instructions (English)
                                            </Label>
                                            <Textarea
                                                id={`cooking_instruction_en-${index}`}
                                                placeholder={`Describe step ${step.step_number} in English`}
                                                value={step.cooking_instruction_en}
                                                onChange={(e) => handleStepChange(index, "cooking_instruction_en", e.target.value)}
                                                required
                                            />
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor={`cooking_instruction_km-${index}`}>
                                                Instructions (Khmer)
                                            </Label>
                                            <Textarea
                                                id={`cooking_instruction_km-${index}`}
                                                placeholder={`ពិពណ៌នាជំហានទី ${step.step_number} ជាភាសាខ្មែរ`}
                                                value={step.cooking_instruction_km}
                                                onChange={(e) => handleStepChange(index, "cooking_instruction_km", e.target.value)}
                                                required
                                            />
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <Button type="button" variant="outline" onClick={handleAddStep} className="w-full">
                                <Plus className="mr-2 h-4 w-4" /> Add Step
                            </Button>
                        </TabsContent>

                        <TabsContent value="media" className="space-y-4">
                            <div className="space-y-4">
                                <div className="space-y-2">
                                    <Label htmlFor="image">Recipe Image</Label>
                                    <div className="grid place-items-center border-2 border-dashed rounded-md p-6">
                                        <img
                                            src={image_url || "https://i.pinimg.com/736x/72/d9/af/72d9af964d384fc2a16fd087c1062a7c.jpg"}
                                            alt="Recipe preview"
                                            className="max-h-[200px] object-contain mb-4"
                                        />
                                        <Input id="image" type="file" accept="image/*" onChange={handleImageChange} className="max-w-sm" />
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Label htmlFor="video_url">Recipe Video URL</Label>
                                    <div className="flex gap-2">
                                        <Input
                                            id="video_url"
                                            placeholder="https://example.com/video.mp4"
                                            value={video_url}
                                            onChange={(e) => setVideoUrl(e.target.value)}
                                            className="flex-1"
                                        />
                                        <Button type="button" variant="outline" size="icon">
                                            <Video className="h-4 w-4" />
                                        </Button>
                                    </div>
                                    <p className="text-xs text-muted-foreground">
                                        Enter a YouTube or direct video URL
                                    </p>
                                </div>
                            </div>
                        </TabsContent>

                        <div className="mt-6 flex gap-4">
                            <Button type="submit" className="flex-1">
                                <Check className="mr-2 h-4 w-4" />
                                {status === recipeStatus.DRAFT ? "Save Draft" : "Publish Recipe"}
                            </Button>
                        </div>
                    </form>
                </Tabs>

                <div className="sticky top-4">
                    <h2 className="text-xl font-semibold mb-4">Recipe Preview</h2>
                    <RecipePreview {...previewData} />
                </div>
            </div>
        </AppLayout>
    )
}

