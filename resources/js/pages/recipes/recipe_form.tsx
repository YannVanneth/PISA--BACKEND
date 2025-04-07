"use client"

import { useState } from "react"
import { X } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { recipe } from '@/pages/recipes/recipe';
import { Switch } from '@headlessui/react';

interface RecipeFormProps {
    open: boolean
    onOpenChange: (open: boolean) => void
    title: string
    recipe?: recipe
}

export function RecipeForm({ open, onOpenChange, title, recipe }: RecipeFormProps) {
    const [ingredients, setIngredients] = useState<string[]>(["", ""]);
    const [instructions, setInstructions] = useState<string[]>(["", ""]);
    const [imageURL, setImageURL] = useState<string[]>(["", ""]);
    const handleImageChange = (index: number, value: string) => {
        const newImageURL = [...imageURL]
        newImageURL[index] = value
        setImageURL(newImageURL)
    }

    const addImage = () => {
        setImageURL([...imageURL, ""])
    }

    const removeImage = (index: number) => {
        const newImageURL = imageURL.filter((_, i) => i !== index)
        setImageURL(newImageURL)
    }
    const handleIngredientsChange = (index: number, value: string) => {
        const newIngredients = [...ingredients]
        newIngredients[index] = value
        setIngredients(newIngredients)
    }

    const addIngredient = () => {
        setIngredients([...ingredients, ""])
    }

    const removeIngredient = (index: number) => {
        const newIngredients = ingredients.filter((_, i) => i !== index)
        setIngredients(newIngredients)
    }

    const handleInstructionsChange = (index: number, value: string) => {
        const newInstructions = [...instructions]
        newInstructions[index] = value
        setInstructions(newInstructions)
    }

    const addInstruction = () => {
        setInstructions([...instructions, ""])
    }

    const removeInstruction = (index: number) => {
        const newInstructions = instructions.filter((_, i) => i !== index)
        setInstructions(newInstructions)
    }

    return (
        <Dialog open={open} onOpenChange={onOpenChange} >
            <DialogContent className="max-h-[90vh] max-w-3xl overflow-y-auto" >
               <div className="overflow-y-auto h-full pr-2">
                   <DialogHeader>
                       <DialogTitle>{title}</DialogTitle>
                       <DialogDescription>
                           Fill in the details for the recipe. Click save when you're done.
                       </DialogDescription>
                   </DialogHeader>
                   <Tabs defaultValue="basic" className="py-4">
                       <TabsList className="grid grid-cols-3">
                           <TabsTrigger value="basic">Basic Info</TabsTrigger>
                           <TabsTrigger value="ingredients">Ingredients</TabsTrigger>
                           <TabsTrigger value="instructions">Instructions</TabsTrigger>
                       </TabsList>
                       <TabsContent value="basic" className="space-y-4 py-4">
                           <div className="grid grid-cols-2 gap-4">
                               <div className="space-y-2">
                                   <Label htmlFor="title-en">Recipe Title EN</Label>
                                   <Input id="title-en" defaultValue={recipe?.title_en || ""} />
                               </div>
                               <div className="space-y-2">
                                   <Label htmlFor="category-en">Category EN</Label>
                                   <Select defaultValue={recipe?.category.category_en || ""}>
                                       <SelectTrigger>
                                           <SelectValue placeholder="Select category" />
                                       </SelectTrigger>
                                       <SelectContent>
                                           <SelectGroup>
                                               <SelectLabel>Categories</SelectLabel>
                                               <SelectItem value="Pasta">Pasta</SelectItem>
                                               <SelectItem value="Curry">Curry</SelectItem>
                                               <SelectItem value="Vegetarian">Vegetarian</SelectItem>
                                               <SelectItem value="Dessert">Dessert</SelectItem>
                                               <SelectItem value="Salad">Salad</SelectItem>
                                               <SelectItem value="Fast Food">Fast Food</SelectItem>
                                           </SelectGroup>
                                       </SelectContent>
                                   </Select>
                               </div>
                           </div>
                           <div className="grid grid-cols-2 gap-4">
                               <div className="space-y-2">
                                   <Label htmlFor="prepTime">Recipe Title Khmer</Label>
                                   <Input id="prepTime" defaultValue={""} />
                               </div>
                               <div className="space-y-2">
                                   <Label htmlFor="category-km">Category KM</Label>
                                   <Select defaultValue={recipe?.category.category_km || ""}>
                                       <SelectTrigger>
                                           <SelectValue placeholder="Select category" />
                                       </SelectTrigger>
                                       <SelectContent>
                                           <SelectGroup>
                                               <SelectLabel>Categories</SelectLabel>
                                               <SelectItem value="Pasta">Pasta</SelectItem>
                                               <SelectItem value="Curry">Curry</SelectItem>
                                               <SelectItem value="Vegetarian">Vegetarian</SelectItem>
                                               <SelectItem value="Dessert">Dessert</SelectItem>
                                               <SelectItem value="Salad">Salad</SelectItem>
                                               <SelectItem value="Fast Food">Fast Food</SelectItem>
                                           </SelectGroup>
                                       </SelectContent>
                                   </Select>
                               </div>
                           </div>
                           <div className="space-y-2">
                               <Label htmlFor="description-en">Description EN</Label>
                               <Textarea id="description" placeholder="Enter a short description of the recipe" />
                           </div>
                           <div className="space-y-2">
                               <Label htmlFor="description-km">Description KM</Label>
                               <Textarea id="description" placeholder="Enter a short description of the recipe" />
                           </div>
                           <div className="space-y-2 flex flex-col gap-1">
                               <Label htmlFor="image">Image</Label>
                               {imageURL.map((imageURL, index) => (
                                   <div key={index} className="flex items-center gap-4">
                                       <Input
                                           id={`image-${index}`}
                                           type="file"
                                           value={imageURL}
                                           onChange={(e) => handleImageChange(index, e.target.value)}
                                           placeholder={`Ingredient ${index + 1}`}
                                       />
                                       <Button
                                           variant="ghost"
                                           size="icon"
                                           onClick={() => removeImage(index)}
                                           disabled={ingredients.length <= 1}
                                       >
                                           <X className="h-4 w-4" />
                                       </Button>
                                   </div>
                               ))}
                               <Button onClick={addImage} variant="outline" className="w-full">
                                   Add Image
                               </Button>
                           </div>
                           <div className="space-y-2">
                               <Label htmlFor="video">Video</Label>
                               <Input
                                   id="video"
                                   type="file"
                                   value={recipe?.video_url}
                               />
                           </div>
                           <div className="flex items-center justify-between space-y-2">
                               <div className="flex items-center space-x-2">
                                   <Label htmlFor="featured">Is Breakfast</Label>
                                   <Switch id="featured" defaultChecked={ false} />
                               </div>
                               <div className="space-x-2">
                                   <Select defaultValue={recipe?.status || "published"}>
                                       <SelectTrigger className="w-[150px]">
                                           <SelectValue placeholder="Status" />
                                       </SelectTrigger>
                                       <SelectContent>
                                           <SelectItem value="published">Published</SelectItem>
                                           <SelectItem value="unpublished">Un Publish</SelectItem>
                                           <SelectItem value="draft">Draft</SelectItem>
                                       </SelectContent>
                                   </Select>
                               </div>
                           </div>
                       </TabsContent>
                       <TabsContent value="ingredients" className="space-y-4 py-4">
                           <div className="space-y-4">
                               {ingredients.map((ingredient, index) => (
                                   <div key={index} className="flex items-center gap-2">
                                       <Input
                                           value={ingredient}
                                           onChange={(e) => handleIngredientsChange(index, e.target.value)}
                                           placeholder={`Ingredient ${index + 1}`}
                                       />
                                       <Button
                                           variant="ghost"
                                           size="icon"
                                           onClick={() => removeIngredient(index)}
                                           disabled={ingredients.length <= 1}
                                       >
                                           <X className="h-4 w-4" />
                                       </Button>
                                   </div>
                               ))}
                               <Button onClick={addIngredient} variant="outline" className="w-full">
                                   Add Ingredient
                               </Button>
                           </div>
                       </TabsContent>
                       <TabsContent value="instructions" className="space-y-4 py-4">
                           <div className="space-y-4">
                               {instructions.map((instruction, index) => (
                                   <div key={index} className="space-y-2">
                                       <div className="flex items-center justify-between">
                                           <Label>Step {index + 1}</Label>
                                           <Button
                                               variant="ghost"
                                               size="icon"
                                               onClick={() => removeInstruction(index)}
                                               disabled={instructions.length <= 1}
                                           >
                                               <X className="h-4 w-4" />
                                           </Button>
                                       </div>
                                       <Textarea
                                           value={instruction}
                                           onChange={(e) => handleInstructionsChange(index, e.target.value)}
                                           placeholder={`Describe step ${index + 1}`}
                                           rows={2}
                                       />
                                   </div>
                               ))}
                               <Button onClick={addInstruction} variant="outline" className="w-full">
                                   Add Step
                               </Button>
                           </div>
                       </TabsContent>
                   </Tabs>
                   <div className="flex justify-end gap-2">
                       <Button variant="outline" onClick={() => onOpenChange(false)}>
                           Cancel
                       </Button>
                       <Button>Save Recipe</Button>
                   </div>
               </div>
            </DialogContent>
        </Dialog>
    )
}

