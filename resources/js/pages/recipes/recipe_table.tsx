'use client';

import { Clock, Edit, MoreHorizontal, Trash2 } from 'lucide-react';
import { useState } from 'react';

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { RecipeForm } from './recipe_form';
import { cookingStep, ingredient, recipe } from '@/pages/recipes/recipe';

export function RecipeTable({recipes}: { recipes: recipe[] }) {
    const [isEditModalOpen, setIsEditModalOpen] = useState(false);
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const [selectedRecipe, setSelectedRecipe] = useState<(typeof recipes)[0] | null>(null);

    const handleEdit = (recipe: (typeof recipes)[0]) => {
        setSelectedRecipe(recipe);
        setIsEditModalOpen(true);
    };

    const handleDelete = (recipe: (typeof recipes)[0]) => {
        setSelectedRecipe(recipe);
        setIsDeleteDialogOpen(true);
    };

    const confirmDelete = () => {
        // Here you would implement actual delete functionality
        console.log(`Deleting recipe: ${selectedRecipe?.title_en}`);
        setIsDeleteDialogOpen(false);
    };

    return (
        <>
            <div className="rounded-lg border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead className="w-[6%]">Image</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Category</TableHead>
                            <TableHead>Duration</TableHead>
                            <TableHead>Ingredients</TableHead>
                            <TableHead>Cooking Step</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {recipes.map((recipe) => (
                            <TableRow key={recipe.id}>
                                <TableCell>
                                    <img
                                        src={recipe.image_url || '/placeholder.svg'}
                                        alt={recipe.title_en}
                                        className="rounded-md object-cover h-16 w-16"
                                    />
                                </TableCell>
                                <TableCell className="font-medium">{recipe.title_en}</TableCell>
                                <TableCell>{recipe.category.category_en}</TableCell>
                                <TableCell>
                                    <div className="flex flex-col gap-1">
                                        <div className="text-muted-foreground flex items-center text-xs">
                                            <Clock className="mr-1 h-3 w-3" /> {recipe.duration}
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div className="flex flex-col gap-1">
                                        {recipe.ingredients.map((ingredient : ingredient) => (
                                            <div key={ingredient.id} className="text-muted-foreground flex items-center text-xs">
                                                {ingredient.ingredient_quantity} {ingredient.unit_en} {ingredient.ingredient_name_en}
                                            </div>
                                        ))}
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div>
                                        {recipe.cookingSteps.map((step : cookingStep) => (
                                            <div key={step.id} className="text-muted-foreground flex items-center text-xs">
                                                {step.step_number}. {step.cooking_instruction_en}
                                            </div>
                                        ))}
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant={recipe.status === 'published' ? 'default' : 'secondary'}>{recipe.status}</Badge>
                                </TableCell>
                                <TableCell className="">
                                    {/*<div>*/}
                                    {/*    <Button variant="outline" size="icon" onClick={() => handleEdit(recipe)}>*/}
                                    {/*        <Edit className="h-4 w-4 text-center" />*/}
                                    {/*    </Button>*/}
                                    {/*    <Button variant="outline" size="icon" onClick={() => handleEdit(recipe)}>*/}
                                    {/*        <Trash2 className="mr-2 h-4 w-4 text-center" />*/}
                                    {/*    </Button>*/}
                                    {/*</div>*/}
                                    <DropdownMenu>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="icon">
                                                <MoreHorizontal className="h-4 w-4" />
                                                <span className="sr-only">Actions</span>
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end">
                                            <DropdownMenuItem onClick={() => handleEdit(recipe)}>
                                                <Edit className="mr-2 h-4 w-4" />
                                                Edit
                                            </DropdownMenuItem>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem
                                                onClick={() => handleDelete(recipe)}
                                                className="text-destructive focus:text-destructive"
                                            >
                                                <Trash2 className="mr-2 h-4 w-4" />
                                                Delete
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </div>

            {selectedRecipe && (
                <RecipeForm
                    open={isEditModalOpen}
                    onOpenChange={setIsEditModalOpen}
                    title={`Edit Recipe: ${selectedRecipe.title_en}`}
                    recipe={selectedRecipe}
                />
            )}

            <AlertDialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                            This action cannot be undone. This will permanently delete the recipe &quot;{selectedRecipe?.title_en}&quot; from the
                            database.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction onClick={confirmDelete} className="bg-destructive text-destructive-foreground">
                            Delete
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </>
    );
}
